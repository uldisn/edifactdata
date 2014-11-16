<?php

/**
 * For crontam reaading terminal EDI messages.
 */
Yii::import('system.cli.commands.*');

class ReadTerminalPop3Command extends CConsoleCommand {

    public function getHelp() {
        return <<<EOD
USAGE
    php yiic_crontab.php ReadTerminalPop3

DESCRIPTION
  This command read terminal messages and save

PARAMETERS
 * no parametres

EOD;
    }

    /**
     * Execute the action.
     *
     */
    public function run($args) {
        
        include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Parser.php';
        include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Reader.php';
        include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Analyser.php';

        if (empty($args)) {
            foreach (Yii::app()->params['terminal_pop3'] as $terminal => $pop3_settings) {
                echo 'Read terminal: ' . $terminal . PHP_EOL;
                $attacments = $this->readPop3Attachments($pop3_settings['host'], $pop3_settings['user'], $pop3_settings['password']);
                if ($attacments) {
                    foreach ($attacments as $attachment){
                        echo 'file: ' . $attachment['filename'] . PHP_EOL;
                        $this->saveAttachment($attachment['filename'], $attachment['data']);
                    }    
                }
                echo 'Finish Read terminal: ' . $terminal . PHP_EOL;
            }
            return true;
        }

        if ($args[0] == 'analyze') {

            $this->analyze($args[1]);
        }
        if ($args[0] == 'read') {
            if(isset($args[1])){
                $this->readEdiData($args[1]);
            }else{
                $all = Edifact::model()->findAll();
                foreach($all as $edifact){
                    $this->readEdiData($edifact->id);
                }
            }
        }
    }

    public function connectPop3($strHost, $strUser, $strPass) {
        $mailBox = imap_open('{' . $strHost . ':110/pop3/novalidate-cert}', $strUser, $strPass);

        if ($mailBox) {
            // call this to avoid the mailbox is empty error message
            if (imap_num_msg($mailBox) == 0)
                $errors = imap_errors();
            return $mailBox;
        }
        // imap_errors() will contain the list of real errors
        return FALSE;
    }

    public function readPop3Attachments($strHost, $strUser, $strPass) {
        echo 'a';
        $inbox = $this->connectPop3($strHost, $strUser, $strPass);
        if ($inbox === false) {
            echo 'Can not create connection to POP3!' . PHP_EOL;
            return false;
        }



        $emails = imap_search($inbox, 'ALL');
        echo 'b';
        /* if any emails found, iterate through each email */
        $ra = [];
        if (!$emails) {
            /* close the connection */
            imap_close($inbox);
            echo 'No any emails!' . PHP_EOL;
            return $ra;
        }

        $count = 1;

        /* put the newest emails on top */
        rsort($emails);
        echo 'c';

        /* for every email... */
        echo 'Reademails' ;
        foreach ($emails as $email_number) {
            echo 'E';

            /* get information specific to this email */
            $overview = imap_fetch_overview($inbox, $email_number, 0);

            /* get mail message */
            $message = imap_fetchbody($inbox, $email_number, 2);

            /* get mail structure */
            $structure = imap_fetchstructure($inbox, $email_number);

            $attachments = array();

            /* if any attachments found... */
            if (isset($structure->parts) && count($structure->parts)) {
                for ($i = 0; $i < count($structure->parts); $i++) {
                    $attachments[$i] = array(
                        'is_attachment' => false,
                        'filename' => '',
                        'name' => '',
                        'attachment' => ''
                    );

                    if ($structure->parts[$i]->ifdparameters) {
                        foreach ($structure->parts[$i]->dparameters as $object) {
                            if (strtolower($object->attribute) == 'filename') {
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['filename'] = $object->value;
                            }
                        }
                    }

                    if ($structure->parts[$i]->ifparameters) {
                        foreach ($structure->parts[$i]->parameters as $object) {
                            if (strtolower($object->attribute) == 'name') {
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['name'] = $object->value;
                            }
                        }
                    }

                    if ($attachments[$i]['is_attachment']) {
                        $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i + 1);

                        /* 4 = QUOTED-PRINTABLE encoding */
                        if ($structure->parts[$i]->encoding == 3) {
                            $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                        }
                        /* 3 = BASE64 encoding */ elseif ($structure->parts[$i]->encoding == 4) {
                            $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                        }
                    }
                }
            }

            /* iterate through each attachment and save it */
            foreach ($attachments as $attachment) {
                if ($attachment['is_attachment'] != 1) {
                    continue;
                }


                $filename = $attachment['name'];
                if (empty($filename))
                    $filename = $attachment['filename'];

                echo 'A';
                $ra[] = array(
                    'filename' => $filename,
                    'data' => $attachment['attachment'],
                );
            }
            
            echo PHP_EOL;
        }

        /* close the connection */
        imap_close($inbox);
        return $ra;
    }

    public function saveAttachment($file_name, $data) {

        $f = explode(PHP_EOL, $data);
        $EdiReader = new EDI\Reader($f);

        //read & save data
        $prepare_date = $EdiReader->readEdiDataValue('UNB', 4, 0);
        $prepare_time = $EdiReader->readEdiDataValue('UNB', 4, 1);
        $prepare_datetime = preg_replace('#(\d\d)(\d\d)(\d\d)#', '20$1-$2-$3', $prepare_date)
                . ' '
                . preg_replace('#(\d\d)(\d\d)#', '$1:$2', $prepare_time);

        echo ' Terminal:' . $EdiReader->readEdiDataValue('UNB', 2).PHP_EOL;
        echo ' Number:' . $EdiReader->readEdiDataValue('UNH', 1).PHP_EOL;
        
        $edifact = new Edifact();
        $edifact->terminal = $EdiReader->readEdiDataValue('UNB', 2);
        $edifact->message_ref_number = $EdiReader->readEdiDataValue('UNH', 1);
        $edifact->prep_datetime = $prepare_datetime;
        $edifact->filename = $file_name;
        $edifact->message = $data;
        if (!$edifact->save()) {
            var_dump($edifact->errors);
            return false;
        }
        $this->readEdiData($edifact->id);
    }

    public function analyze($edi_id) {

        $edifact = Edifact::model()->FindByPk($edi_id);

        $EdiParser = new EDI\Parser();
        $f = explode(PHP_EOL, $edifact->message);
        $parsed = $EdiParser->parse($f);

        $analyser = new EDI\Analyser();
        $analyser->edi_message = $f;
        $mapping_segments = realpath(Yii::getPathOfAlias('edifact-parser')) . '/Mapping/D95B/segments.xml';
        $analyser->loadSegmentsXml($mapping_segments);
        $text = $analyser->process($parsed);

        $save_file_path = Yii::app()->params['edi_analyzer']['result_path'] . '/edi_analyze_' . $edi_id . '.txt';

        file_put_contents($save_file_path, $text);
    }

    public function readEdiData($edi_id) {

        echo '$edi_id=' . $edi_id .PHP_EOL;
        
        $error = array();
    
       $edifact = Edifact::model()->FindByPk($edi_id);

        $parser = new EDI\Parser();
        $f = explode(PHP_EOL, $edifact->message);
        $parser->parse($f);
        
        $EdiReader = new EDI\Reader($f);        

        $dateTimePreparation = $EdiReader->readEdiDataValue('UNB', 4, 0) . $EdiReader->readEdiDataValue('UNB', 4, 1);
        if(empty($dateTimePreparation)){
            $dateTimePreparation = $EdiReader->readEdiDataValue('UNB', 4);
        }
        
        // PositioningDatetimeOfEquipment - iekraushana/izkraushana
        
        $terminal = $EdiReader->readEdiDataValue('UNB', 2);
        $MessageType = $EdiReader->readUNHmessageType();

        $ecnt = EcntContainer::model()->findByAttributes(array('ecnt_edifact_id' => $edifact->id));
        if(!$ecnt){
            $ecnt = new EcntContainer();
        }        
        $ecnt->ecnt_edifact_id = $edifact->id;
        $ecnt->ecnt_terminal = $terminal;
        $ecnt->ecnt_message_type = $MessageType;        
        
        $ecnt->ecnt_container_nr = $EdiReader->readEdiDataValue('EQD', 2);        
        $ecnt->ecnt_iso_type = $EdiReader->readEdiDataValue('EQD', 3,0);

        if(!empty($ecnt->ecnt_iso_type)){
            switch (substr($ecnt->ecnt_iso_type,0,1)) {
                case '2':
                    $ecnt->ecnt_length = EcntContainer::ECNT_LENGTH_20;
                    break;
                case '4':
                    $ecnt->ecnt_length = EcntContainer::ECNT_LENGTH_40;
                    break;
                default:
                    $error[] = 'Nekorekts ISO TYPR:'.  $ecnt->ecnt_iso_type;
                    break;
            }
        }        
        
        if($terminal == 'RIXBCT'){
            //BGM  1001 Document name code :
            //34 - Cargo status  IN
            //36 - Identity card OUT
            
            
            //$ecnt->ecnt_length` enum('40','20') DEFAULT NULL,
            

            
            //Effective from date/time
            //(2069) Date and/or time at which specified event or document becomes effective.

            
            //20 - Main-carriage transport
            //The primary stage in the movement of cargo from the point of origin to the intended destination.
            
            
   
            if($MessageType == 'COARRI'){
                
                //2005 Date/time/period qualifier: code
                //‘203' Execution date
                $ecnt->ecnt_datetime = $EdiReader->readEdiSegmentDTM(203);                
                
                //TDT        8067 Mode of transport, coded: codes
                //                '1' maritime transport
                //                '8' inland water transport
                $ModeOfTransport = $EdiReader->readEdiDataValue(['TDT',[1=>20]],3,1);
                $LoadingLocationIdentification = $EdiReader->readEdiDataValue(['LOC',[1=>9]],2,0);
                $DischargingLocationIdentification = $EdiReader->readEdiDataValue(['LOC',[1=>11]],2,0);
                if($LoadingLocationIdentification == 'LVRIX'){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_VESSEL_LOAD;   
                    $ecnt->ecnt_ib_carrier = 'TRUCK';
                    //$ecnt->ecnt_ob_carrier = 'TRUCK'; 
                }elseif($DischargingLocationIdentification == 'LVRIX'){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_VESSEL_DISCHARGE; 
                    //$ecnt->ecnt_ib_carrier = 'TRUCK'; 
                    $ecnt->ecnt_ob_carrier = 'TRUCK';                    
                }else{
                    $error[] = 'Neatrada operation - vessel load/unload!'  
                        .'/Loading:'.$LoadingLocationIdentification
                        .'/Discharging:'.$DischargingLocationIdentification 
                            ;
                }     
                 //PARTY QUALIFIER 
                //CA Carrier
                //(3126) Party undertaking or arranging transport of goods between named points.
                $ecnt->ecnt_fwd = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CA']], 2,0);
                
                //8051 TRANSPORT STAGE QUALIFIER: 
                //  '20' (main carriage)                
                // Read: 8028 CONVEYANCE REFERENCE NUMBER: the vessel operator's loading voyage number
                $ecnt->ecnt_transport_id = $EdiReader->readEdiDataValue(['TDT', ['1' => 20]], 2);

            }elseif($MessageType == 'CODECO'){
          
                //2005 Date/time/period qualifier: code
                // 7 - efective datetime
                $ecnt->ecnt_datetime = $EdiReader->readEdiSegmentDTM(7);                

                //LOC Place of loading
                // 9 - [3334] Seaport, airport, freight terminal, 
                //              rail station or other place at which the goods (cargo) 
                //              are loaded on to the means of transport being used for their carriage.
                //    TRUCK IN          
                //11 - Place of discharge
                //      [3392] Seaport, airport, freight terminal, rail station or other 
                //      place at which goods are unloaded from the means of transport 
                //      having been used for their carriage.
                // TRUCK OUT                       
                $LocationFunctionPlaceLoading =  $EdiReader->readEdiDataValue(['LOC',[1=>9]],2);
                $LocationFunctionPlaceDischarge =  $EdiReader->readEdiDataValue(['LOC',[1=>11]],2);
                if(!empty($LocationFunctionPlaceLoading)){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_IN;   
                }elseif(!empty($LocationFunctionPlaceDischarge)){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_OUT;   
                }else{
                    $error[] = 'Neatrada operation - truck in/out';
                }

                //PARTY QUALIFIER 
                //CF Container operator/lessee
                // Party to whom the possession of specified property (e.g. container) has been conveyed for a period of time in return for rental payments.
                $ecnt->ecnt_fwd = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CF']], 2);
                
                $ecnt->ecnt_transport_id = $EdiReader->readTDTtransportIdentification(1);
                if(!empty($ecnt->ecnt_transport_id)){
                    $ecnt->ecnt_ib_carrier = 'TRUCK';
                }                
            }else{
                $error[] = 'Unknown message type:' . $MessageType;
            }

            //$ecnt->ecnt_ob_carrier` varchar(50) DEFAULT NULL,
            $ecnt->ecnt_weight = $EdiReader->readEdiDataValue(['MEA', ['2' => 'G']], 3, 1);
            
            //8169 - fullemptyIndicatorCoded
            //To indicate the extent to which the equipment is full or empty.
            $FullEmpty = $EdiReader->readEdiDataValue('EQD', 6);
            if($FullEmpty == 4){
                $ecnt->ecnt_statuss = EcntContainer::ECNT_STATUSS_EMPTY;
            }elseif($FullEmpty == 5){
                $ecnt->ecnt_statuss = EcntContainer::ECNT_STATUSS_FULL;
            }else{
                $error[] = 'Neatrada empty/full';
            }
            //$ecnt->ecnt_line` varchar(50) DEFAULT NULL,
            
            $ecnt->ecnt_booking = $EdiReader->readEdiDataValue(['RFF', ['1.0' => 'BN']], 1,1);
            //$ecnt->ecnt_eu_status` enum('C','N') DEFAULT NULL,
            //$ecnt->ecnt_imo_code` varchar(50) DEFAULT NULL,
                
            if(!$ecnt->save()){
                var_dump($ecnt->errors);
            }else{
                $ecnt->recalc();
            }
            if(!empty($error)){
                var_dump($error);
            }
            $reader_errors = $EdiReader->errors();
            if(!empty($reader_errors)){
                var_dump($reader_errors);
            }            
            $EdiReader->resetErrors();
        }elseif($terminal == 'RIXCT'){
            
            if($MessageType == 'COARRI'){
                //2005 Date/time/period qualifier: code
                //‘203' Execution date
                $ecnt->ecnt_datetime = $EdiReader->readEdiSegmentDTM(203);     
                
                //TDT        8067 Mode of transport, coded: codes
                //                '1' maritime transport
                //                '8' inland water transport
                $ModeOfTransport = $EdiReader->readEdiDataValue(['TDT',[1=>20]],3,1);
                $LoadingLocationIdentification = $EdiReader->readEdiDataValue(['LOC',[1=>9]],2,0);
                $DischargingLocationIdentification = $EdiReader->readEdiDataValue(['LOC',[1=>11]],2,0);
                if($LoadingLocationIdentification == 'LVRIX'){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_VESSEL_LOAD;   
                    $ecnt->ecnt_ib_carrier = 'TRUCK';
                    //$ecnt->ecnt_ob_carrier = 'TRUCK'; 
                }elseif($DischargingLocationIdentification == 'LVRIX'){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_VESSEL_DISCHARGE; 
                    //$ecnt->ecnt_ib_carrier = 'TRUCK'; 
                    $ecnt->ecnt_ob_carrier = 'TRUCK';                    
                }else{
                    $error[] = 'Neatrada operation - vessel load/unload!'  
                        .'/Loading:'.$LoadingLocationIdentification
                        .'/Discharging:'.$DischargingLocationIdentification 
                            ;
                }     
                
                 //PARTY QUALIFIER 
                //CA Carrier
                //(3126) Party undertaking or arranging transport of goods between named points.
                $ecnt->ecnt_fwd = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CA']], 2,0);
                
                //8051 TRANSPORT STAGE QUALIFIER: 
                //  '20' (main carriage)                
                // Read: 8028 CONVEYANCE REFERENCE NUMBER: the vessel operator's loading voyage number
                $ecnt->ecnt_transport_id = $EdiReader->readEdiDataValue(['TDT', ['1' => 20]], 2);                
         
            }elseif($MessageType == 'CODECO'){
            
                $ecnt->ecnt_fwd = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CF']], 2);
                // 1001 Document name code 
                $DocumentNameCode = $EdiReader->readEdiDataValue('BGM', 1);
                if($DocumentNameCode == 34){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_IN;   
                }elseif($DocumentNameCode == 36){
                    $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_OUT;   
                }else{
                    $error[] = 'Neatrada operation - truck in/out';
                }            

              //8169 - fullemptyIndicatorCoded
                //To indicate the extent to which the equipment is full or empty.
                $FullEmpty = $EdiReader->readEdiDataValue('EQD', 6);
                if($FullEmpty == 4){
                    $ecnt->ecnt_statuss = EcntContainer::ECNT_STATUSS_EMPTY;
                }elseif($FullEmpty == 5){
                    $ecnt->ecnt_statuss = EcntContainer::ECNT_STATUSS_FULL;
                }else{
                    $error[] = 'Neatrada empty/full';
                }            

                //Effective from date/time
                //(2069) Date and/or time at which specified event or document becomes effective.
                $ecnt->ecnt_datetime = $EdiReader->readEdiSegmentDTM('181');

                //20 - Main-carriage transport
                //The primary stage in the movement of cargo from the point of origin to the intended destination.


                //LOC Place of loading
                // 9 - [3334] Seaport, airport, freight terminal, 
                //              rail station or other place at which the goods (cargo) 
                //              are loaded on to the means of transport being used for their carriage.
                //    TRUCK IN          
                //11 - Place of discharge
                //      [3392] Seaport, airport, freight terminal, rail station or other 
                //      place at which goods are unloaded from the means of transport 
                //      having been used for their carriage.
                // TRUCK OUT            
    //            $LocationFunctionPlaceLoading =  $EdiReader->readEdiDataValue(['LOC',[1=>9]],2);
    //            $LocationFunctionPlaceDischarge =  $EdiReader->readEdiDataValue(['LOC',[1=>11]],2);
    //            if(!empty($LocationFunctionPlaceLoading)){
    //                $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_IN;   
    //            }elseif(!empty($LocationFunctionPlaceDischarge)){
    //                $ecnt->ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_OUT;   
    //            }else{
    //                $error[] = 'Neatrada operation - truck in/out';
    //            }


                //id: 1131 - codeListQualifier     Identification of a code list.
                // TER - TERMINAL
                //$LocationFunctionPlaceLoading =  $EdiReader->readEdiDataValue(['LOC',[1=>165]],3,1);

                $ecnt->ecnt_transport_id = $EdiReader->readEdiDataValue(['TDT', ['1' => '1']], 8, 0);
                if(!empty($ecnt->ecnt_transport_id)){
                    $ecnt->ecnt_ib_carrier = 'TRUCK';
                }                
                
            }else{
                $error[] = 'Unknown message type:' . $MessageType;
            }


            $ecnt->ecnt_weight = $EdiReader->readEdiDataValue(['MEA', ['2' => 'G']], 3, 1);
            $ecnt->ecnt_booking = $EdiReader->readEdiDataValue(['RFF', ['1.0' => 'BN']], 1,1);
                    
            if(!$ecnt->save()){
                var_dump($ecnt->errors);
            }else{
                $ecnt->recalc();
            }
            if(!empty($error)){
                var_dump($error);
            }
            $reader_errors = $EdiReader->errors();
            if(!empty($reader_errors)){
                var_dump($reader_errors);
            }            
            $EdiReader->resetErrors();
            
        }
        
        
        $plain_data = array(
            'messageType' => $EdiReader->readEdiDataValue('BGM', 1), //36 - Gate Out 34 - Gate In
            'interchangeSender' => $EdiReader->readEdiDataValue('UNB', 2),
            //'dateTimePreparation' => $EdiReader->readEdiDataValue('UNB', 4, 0) . $EdiReader->readEdiDataValue('UNB', 4, 1),
            'dateTimePreparation' => $EdiReader->readUNBDateTimeOfPpreperation(),
            'messageReferenceNumber' => $EdiReader->readEdiDataValue('UNH', 1),
            'conveyanceReferenceNumber' => $EdiReader->readEdiDataValue(['TDT', ['1' => '20']], 2),
            'idOfTheMeansOfTransportVessel' => $EdiReader->readEdiDataValue(['TDT', ['1' => '20']], 8, 3),
            'portOfDischarge' => $EdiReader->readEdiDataValue(['LOC', ['1' => '11']], 2, 0),
            'arrivalDateTimeEstimated' => $EdiReader->readEdiSegmentDTM('132'),
            'arrivalDateTimeActual' => $EdiReader->readEdiSegmentDTM('178'),
            'departureDateTimeEstimated' => $EdiReader->readEdiSegmentDTM('133'),
            'carrier' => $EdiReader->readEdiDataValue(['NAD', ['1' => 'MS']], 2, 0),
            'goodsItemNumber' => $EdiReader->readEdiDataValue('GID', 1),
            'equipmentIdentification' => $EdiReader->readEdiDataValue('EQD', 2),
            //'equipmentEmpty' => $parser->readEdiDataValue($filter_EQD_EMPTY,3,4),
            'BookingreferenceNumber' => $EdiReader->readEdiDataValue(['RFF', ['1.0' => 'BN']], 1, 1),
            'RealiseReferenceNumber' => $EdiReader->readEdiDataValue(['RFF', ['1.0' => 'RE']], 1, 1),
            'PositioningDatetimeOfEquipment' => $EdiReader->readEdiSegmentDTM('181'),
            'ActivityLocation' => $EdiReader->readEdiDataValue(['LOC', ['1' => '165']], 2, 0),
            'ActivityLocationRelatedPlace' => $EdiReader->readEdiDataValue(['LOC', ['1' => '165']], 3, 0),
            'GrossWeight' => $EdiReader->readEdiDataValue(['MEA', ['2' => 'G']], 3, 0) . ' ' . $EdiReader->readEdiDataValue(['MEA', ['2' => 'G']], 3, 1),
            'TareWeight' => $EdiReader->readEdiDataValue(['MEA', ['2' => 'T']], 3, 0) . ' ' . $EdiReader->readEdiDataValue(['MEA', ['2' => 'T']], 3, 1),
            //'CarRegNumber' => $EdiReader->readEdiDataValue(['TDT', ['1' => '1']], 8, 0),
            'CarRegNumber' => $EdiReader->readTDTtransportIdentification(1),
        );

        //'PositioningDatetimeOfEquipment' => $EdiReader->readEdiSegmentDTM('7'),
        if(empty($plain_data['PositioningDatetimeOfEquipment'])){
            $plain_data['PositioningDatetimeOfEquipment'] = $EdiReader->readEdiSegmentDTM('7');
        }
        $reader_errors = $EdiReader->errors();
        if(!empty($reader_errors)){
            var_dump($reader_errors);
        }
        $ed = EdifactData::model()->findByAttributes(array('edifact_id' => $edifact->id));
        if(!$ed){
            $ed = new EdifactData();
        }
        $ed->attributes = $plain_data;
        $ed->edifact_id = $edifact->id;
        if(!$ed->save()){
            var_dump($ed->errors);
        }
    }

}
