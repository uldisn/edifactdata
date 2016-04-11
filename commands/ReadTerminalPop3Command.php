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
        echo 'START '. date("Y-m-d H:i:s") . PHP_EOL; 
        include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Parser.php';
        include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Reader.php';
        include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Analyser.php';

        if (empty($args)) {
            foreach (Yii::app()->params['terminal_pop3'] as $terminal => $pop3_settings) {
                echo 'Read terminal: ' . $terminal . PHP_EOL;
                $attacments = $this->readPop3Attachments($pop3_settings['host'], $pop3_settings['user'], $pop3_settings['password']);
                echo 'Found  ' . count($attacments) . ' attachments' . PHP_EOL;                
                if ($attacments) {
                    foreach ($attacments as $attachment){
                        //echo 'file: ' . $attachment['filename'] . PHP_EOL;
                        $this->saveAttachment($attachment['filename'], $attachment['data']);
                    }    
                }
                echo 'Finish Read terminal: ' . $terminal . PHP_EOL;
            }
            echo 'FINISH '. date("Y-m-d H:i:s") . PHP_EOL;             
            return true;
        }

        if ($args[0] == 'analyze') {

            $this->analyze($args[1]);
        }
        if ($args[0] == 'read_codes') {

            $this->codes_to_db();
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

        if ($args[0] == '7days') {
            $count = EcerErrors::mark7DaysNoMoving();
            echo '7days no moving: ' . $count . PHP_EOL;
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
        $inbox = $this->connectPop3($strHost, $strUser, $strPass);
        if ($inbox === false) {
            echo 'Can not create connection to POP3!' . PHP_EOL;
            return false;
        }



        $emails = imap_search($inbox, 'ALL');
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

        /* for every email... */
        echo 'Reademails' ;
        foreach ($emails as $email_number) {

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
                
                //validate file extension
                $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
                if($file_ext != 'edi'){
                    continue;
                }                

                $ra[] = array(
                    'filename' => $filename,
                    'data' => $attachment['attachment'],
                );
            }

        }

        /* close the connection */
        imap_close($inbox);
        return $ra;
    }

    public function saveAttachment($file_name, $data) {

        $f = explode(PHP_EOL, $data);
        $EdiReader = new EDI\Reader($f);

        //read & save data
        $terminal = $EdiReader->readEdiDataValue('UNB', 2);
        $message_ref_number = $EdiReader->readEdiDataValue('UNH', 1);        
        $prepare_date = $EdiReader->readEdiDataValue('UNB', 4, 0);
        $prepare_time = $EdiReader->readEdiDataValue('UNB', 4, 1);
        $prepare_datetime = preg_replace('#(\d\d)(\d\d)(\d\d)#', '20$1-$2-$3', $prepare_date)
                . ' '
                . preg_replace('#(\d\d)(\d\d)#', '$1:$2', $prepare_time);
                
        if(empty($terminal)){
            echo 'Error: Terminal empty'.PHP_EOL;
            echo $data;
            continue;
        }
         
        if(empty($message_ref_number)){
            echo 'Error: Numberl empty'.PHP_EOL;
            echo $data;
            continue;
        }                
        echo ' Terminal:' . $terminal.PHP_EOL;
        echo ' Number:' . $EdiReader->readEdiDataValue('UNH', 1).PHP_EOL;        
        
        $criteria = new CDbCriteria;
        $criteria
            ->compare('message_ref_number',$message_ref_number)
            ->compare('terminal',$terminal);

        
        if(Edifact::model()->find($criteria)){
            return false;
        }
        
        echo ' Save' . PHP_EOL;

        $edifact = new Edifact();
        $edifact->terminal = $terminal;
        $edifact->message_ref_number = $message_ref_number;
        $edifact->prep_datetime = $prepare_datetime;
        $edifact->filename = $file_name;
        $edifact->message = $data;
        if (!$edifact->save()) {
            var_dump($edifact->errors);
            return false;
        }
        $this->readEdiData($edifact->id);
        echo ' OK'.PHP_EOL;        
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
    
    
    public function codes_to_db() {


        $analyser = new EDI\Analyser();

        $codes_file = realpath(Yii::getPathOfAlias('edifact-parser')) . '/Mapping/D95B/codes.xml';
        $codes = $analyser->readCodes($codes_file);
        $codes = $codes['data_element'];
        while($da = array_shift($codes)){
            $data_id = $da['@attributes']['id'];
            echo $data_id. PHP_EOL;
            if(count($da['code']) == 1){
                $code = $da['code']['@attributes']['id'];
                $desc = $da['code']['@attributes']['desc'];
                $sql = "
                    INSERT INTO edi_codes (data_id, `code`, descriptions) 
                    VALUES
                    (".$data_id.", :code,:desc) 
                    ";
               
                $rawData = Yii::app()->db->createCommand($sql);
                $rawData->bindParam(":desc", $desc, PDO::PARAM_STR);                
                $rawData->bindParam(":code", $code, PDO::PARAM_STR);                
                $rawData->query();                
                echo '  ' . $code . ' - ' . $desc . PHP_EOL;
                
            }else{
                foreach($da['code'] as $code_element){
                    $code = $code_element['@attributes']['id'];
                    $desc = $code_element['@attributes']['desc'];
                    $sql = "
                        INSERT INTO edi_codes (data_id, `code`, descriptions) 
                        VALUES
                        (".$data_id.", :code,:desc) 
                        ";

                    $rawData = Yii::app()->db->createCommand($sql);
                    $rawData->bindParam(":desc", $desc, PDO::PARAM_STR);                
                    $rawData->bindParam(":code", $code, PDO::PARAM_STR);                
                    $rawData->query();                

                    
                    echo '  ' . $code . ' - ' . $desc . PHP_EOL;
                }
            }
            
        }
        //print_r($codes);
        

    }

    public function readEdiData($edi_id) {

        echo '$edi_id=' . $edi_id .PHP_EOL;
        
        $error = array();
    
       $edifact = Edifact::model()->FindByPk($edi_id);

        $parser = new EDI\Parser();
        $f = explode(PHP_EOL, $edifact->message);
        $parser->parse($f);
        
        $EdiReader = new ContainerReader($f);        

        $dateTimePreparation = $EdiReader->readDateTimePreparation();
        
        $terminal = $EdiReader->readEdiDataValue('UNB', 2);
        $MessageType = $EdiReader->readUNHmessageType();
        $MessageCode = $EdiReader->readEdiDataValue('BGM', 1);
        
        if($terminal == 'RIXBCT' || $terminal == 'LVRIXKRA'){
            
   
            if($MessageType == 'COARRI'){

                //TDT        8067 Mode of transport, coded: codes
                //                '1' maritime transport
                //                '8' inland water transport
                $ModeOfTransport = $EdiReader->readEdiDataValue(['TDT',[1=>20]],3,1);                
                
                $container_count = $EdiReader->readEdiDataValue('CNT', 1,1);
                
                if($container_count == 1){
                    $containers = [$EdiReader->getParsedFile()];
                }else{
                    $containers = $EdiReader->readGroups('NAD', 'EQD', 'NAD', 'CNT');  
                }
                                
                if($container_count != count($containers)){
                    $error[] = 'Mismatch contaier count. CNT='.$container_count.' groups='.count($containers);
                    EcntContainer::saveEdiData(array(),$EdiReader,$error,$edifact);
                    return false;
                }
                
                foreach($containers as $container){
                    $error = [];
                    $ecnt_data = [];
                    $EdiReader->resetErrors();

                    //PARTY QUALIFIER 
                    //CA Carrier
                    //(3126) Party undertaking or arranging transport of goods between named points.
                    $ecnt_data['ecnt_fwd'] = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CA']], 2,0);


                    //8051 TRANSPORT STAGE QUALIFIER: 
                    //  '20' (main carriage)                
                    // Read: 8028 CONVEYANCE REFERENCE NUMBER: the vessel operator's loading voyage number
                    $ecnt_data['ecnt_transport_id'] = $EdiReader->readEdiDataValue(['TDT', ['1' => 20]], 2);                

                    
                    //var_dump($container);
                    $ConEdiReader = new ContainerReader();
                    $ConEdiReader->setParsedFile($container);
                
                    $container_number = $ConEdiReader->readEdiDataValue('EQD', 2);

                    $ecnt_data['ecnt_edifact_id'] = $edifact->id;        
                    $ecnt_data['ecnt_container_nr'] = $container_number;        
                    $ecnt_data['ecnt_terminal'] = $terminal;
                    $ecnt_data['ecnt_message_type'] = $MessageType;                   
                    $ecnt_data['ecnt_iso_type'] = $ConEdiReader->readEdiDataValue('EQD', 3,0);
                    
                    //2005 Date/time/period qualifier: code
                    //‘203' Execution date
                    $ecnt_data['ecnt_datetime'] = $ConEdiReader->readEdiSegmentDTM(203);                

                    //$LoadingLocationIdentification = $EdiReader->readEdiDataValue(['LOC',[1=>9]],2,0);
                    //$DischargingLocationIdentification = $ConEdiReader->readEdiDataValue(['LOC',[1=>11]],2,0);
                    if($MessageCode == 270 ){
                        $ecnt_data['ecnt_operation'] = EcntContainer::ECNT_OPERATION_VESSEL_LOAD;   
                        $ecnt_data['ecnt_ib_carrier'] = 'TRUCK';

                    }elseif($MessageCode == 98){
                        $ecnt_data['ecnt_operation'] = EcntContainer::ECNT_OPERATION_VESSEL_DISCHARGE; 
                        $ecnt_data['ecnt_ob_carrier'] = 'TRUCK';                    
                    }else{
                        $error[] = 'Neatrada operation - vessel load/unload!'  
                            .'/Loading:'.$LoadingLocationIdentification
                            .'/Discharging:'.$DischargingLocationIdentification 
                            .'/MessageCode:'.$MessageCode 
                                ;
                    }     
                    
                    $ecnt_data['ecnt_weight'] = $ConEdiReader->readEdiDataValue(['MEA', ['2' => 'G']], 3, 1);        
                    $ecnt_data['ecnt_booking'] = $ConEdiReader->readEdiDataValue(['RFF', ['1.0' => 'BN']], 1,1);
                    $ecnt_data['ecnt_statuss'] = $ConEdiReader->readFullEmpty(); 
                    EcntContainer::saveEdiData($ecnt_data,$EdiReader,$error,$edifact);
                }
                return;

            }elseif($MessageType == 'CODECO'){
          
                //get count of containers
                $container_count = $EdiReader->readEdiDataValue('CNT', 1,1);

                //get container group detais
                if($container_count == 1){
                    $containers = [$EdiReader->getParsedFile()];
                }else{
                    $containers = $EdiReader->readGroups('NAD', 'EQD', 'TDT', 'CNT');  
                }
                                
                if($container_count != count($containers)){
                    $error[] = 'Mismatch contaier count. CNT='.$container_count.' groups='.count($containers);
                    EcntContainer::saveEdiData(array(),$EdiReader,$error,$edifact);
                    return false;
                }
                
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
                 $LocationFunctionKS =  $EdiReader->readEdiDataValue(['LOC',[1=>165]],2);
                 if(!empty($LocationFunctionPlaceLoading)){
                     $ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_IN;   
                 }elseif(!empty($LocationFunctionPlaceDischarge)){
                     $ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_OUT;   
                 }elseif(!empty($LocationFunctionKS)){
                     $ecnt_operation = EcntContainer::ECNT_OPERATION_TRUCK_OUT;   
                 }else{
                     $error[] = 'Neatrada operation - truck in/out';
                 }                

                //PARTY QUALIFIER 
                //CF Container operator/lessee
                // Party to whom the possession of specified property (e.g. container) has been conveyed for a period of time in return for rental payments.
                $ecnt_fwd = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CF']], 2);                 
                 
                //process all containers
                foreach($containers as $container){
                    $error = [];
                    $EdiReader->resetErrors();
                    
                    $ConEdiReader = new ContainerReader();
                    $ConEdiReader->setParsedFile($container);
                    
                    $ecnt_data = [];                    
                    $ecnt_data['ecnt_terminal'] = $terminal;
                    $ecnt_data['ecnt_container_nr'] = $ConEdiReader->readEdiDataValue('EQD', 2);        
                    $ecnt_data['ecnt_iso_type'] = $ConEdiReader->readEdiDataValue('EQD', 3,0);
                    $ecnt_data['ecnt_message_type'] = $MessageType;   
                    $ecnt_data['ecnt_operation'] = $ecnt_operation;   
                    $ecnt_data['ecnt_fwd'] = $ecnt_fwd;
                    
                    //2005 Date/time/period qualifier: code
                    // 7 - efective datetime
                    $ecnt_data['ecnt_datetime'] = $ConEdiReader->readEdiSegmentDTM(7);   

                    $ecnt_data['ecnt_transport_id'] = $ConEdiReader->readTDTtransportIdentification(1);
                    if(!empty($ecnt_data['ecnt_transport_id'])){
                        $ecnt_data['ecnt_ib_carrier'] = 'TRUCK';
                    }       
                    $ecnt_data['ecnt_statuss'] = $ConEdiReader->readFullEmpty();                       
                
                    EcntContainer::saveEdiData($ecnt_data,$EdiReader,$error,$edifact); 
                    
                }                
                
                return;
            }else{
                $error[] = 'Unknown message type:' . $MessageType;
                EcntContainer::saveEdiData(array(),$EdiReader,$error,$edifact);                
                return;
            }
            
        }elseif($terminal == 'RIXCT'){
            
            if($MessageType == 'COARRI'){
                $ecnt_data = [];
                $ecnt_data['ecnt_terminal'] = $terminal;
                $ecnt_data['ecnt_message_type'] = $MessageType;   
                $ecnt_data['ecnt_fwd'] = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CA']], 2,0);   
                $ecnt_data['ecnt_transport_id'] = $EdiReader->readEdiDataValue(['TDT', ['1' => 20]], 2);   
                $ecnt_data['ecnt_edifact_id'] = $edifact->id;    
                
                $ecnt_data['ecnt_container_nr'] = $EdiReader->readEdiDataValue('EQD', 2);        
                $ecnt_data['ecnt_iso_type'] = $EdiReader->readEdiDataValue('EQD', 3,0);

                $ecnt_data['ecnt_datetime'] = $EdiReader->readEdiSegmentDTM(203); 
                //2005 Date/time/period qualifier: code
                //‘203' Execution date
                $ecnt_data['ecnt_datetime'] = $EdiReader->readEdiSegmentDTM(203);     
                
                
                if($MessageCode == 270 ){
                    $ecnt_data['ecnt_operation'] = EcntContainer::ECNT_OPERATION_VESSEL_LOAD;   
                    $ecnt_data['ecnt_ib_carrier'] = 'TRUCK';

                }elseif($MessageCode == 98){
                    $ecnt_data['ecnt_operation'] = EcntContainer::ECNT_OPERATION_VESSEL_DISCHARGE; 
                    $ecnt_data['ecnt_ob_carrier'] = 'TRUCK';                    
                }else{
                    $error[] = 'Neatrada operation - vessel load/unload!'  
                        .'/Loading:'.$LoadingLocationIdentification
                        .'/Discharging:'.$DischargingLocationIdentification 
                        .'/MessageCode:'.$MessageCode 
                            ;
                }            
                
                $ecnt_data['ecnt_weight'] = $EdiReader->readEdiDataValue(['MEA', ['2' => 'G']], 3, 1);        
                $ecnt_data['ecnt_statuss'] = $EdiReader->readFullEmpty(); 
                EcntContainer::saveEdiData($ecnt_data,$EdiReader,$error,$edifact);  
                return true;
         
            }elseif($MessageType == 'CODECO'){
                
                $ecnt_data = [];
                $ecnt_data['ecnt_terminal'] = $terminal;  
                $ecnt_data['ecnt_message_type'] = $MessageType;   
                
                $ecnt_data['ecnt_container_nr'] = $EdiReader->readEdiDataValue('EQD', 2);        
                $ecnt_data['ecnt_iso_type'] = $EdiReader->readEdiDataValue('EQD', 3,0);
                
            
                $ecnt_data['ecnt_fwd'] = $EdiReader->readEdiDataValue(['NAD', ['1' => 'CF']], 2);
                // 1001 Document name code 
                $DocumentNameCode = $EdiReader->readEdiDataValue('BGM', 1);
                if($DocumentNameCode == 34){
                    $ecnt_data['ecnt_operation'] = EcntContainer::ECNT_OPERATION_TRUCK_IN;   
                }elseif($DocumentNameCode == 36){
                    $ecnt_data['ecnt_operation'] = EcntContainer::ECNT_OPERATION_TRUCK_OUT;   
                }else{
                    $error[] = 'Neatrada operation - truck in/out';
                }            

                $ecnt_data['ecnt_statuss'] = $EdiReader->readFullEmpty();

                //Effective from date/time
                $ecnt_data['ecnt_datetime'] = $EdiReader->readEdiSegmentDTM('181');

                $ecnt_data['ecnt_transport_id'] = $EdiReader->readEdiDataValue(['TDT', ['1' => '1']], 8, 0);
                if(!empty($ecnt_data['ecnt_transport_id'])){
                    $ecnt_data['ecnt_ib_carrier'] = 'TRUCK';
                }              
                
                $ecnt_data['ecnt_weight'] = $EdiReader->readEdiDataValue(['MEA', ['2' => 'AAE']], 3, 1);        
                $ecnt_data['ecnt_booking'] = $EdiReader->readEdiDataValue(['RFF', ['1.0' => 'BN']], 1,1);   
                EcntContainer::saveEdiData($ecnt_data,$EdiReader,$error,$edifact);  
                return true;                
                
            }else{
                $error[] = 'Unknown message type:' . $MessageType;
                EcntContainer::saveEdiData(array(),$EdiReader,$error,$edifact);  
                return true;
            }

        }
        
        $error[] = 'Unrecognised message';
        EcntContainer::saveEdiData(array(),$EdiReader,$error,$edifact); 

        return false;
        

    }

}
