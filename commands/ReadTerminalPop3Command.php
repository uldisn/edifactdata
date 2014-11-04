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

        if (empty($args)) {
            include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Parser.php';

            foreach (Yii::app()->params['terminal_pop3'] as $terminal => $pop3_settings) {
                echo 'Read terminal: ' . $terminal . PHP_EOL;
                $attacments = $this->readPop3Attachments($pop3_settings['host'], $pop3_settings['user'], $pop3_settings['password']);
                if ($attacments) {
                    foreach ($attacments as $attachment)
                        $this->saveAttachment($attachment['filename'], $attachment['data']);
                }
                echo 'Finish Read terminal: ' . $terminal . PHP_EOL;
            }
            return true;
        }

        if ($args[0] = 'analyze') {
            include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Analyser.php';
            include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Parser.php';
            $this->analyze($args[1]);
        }
        if ($args[0] = 'read') {
            include_once realpath(Yii::getPathOfAlias('edifact-parser')) . '/Parser.php';
            $this->readEdiData($args[1]);
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

        $EdiParser = new EDI\Parser();

        $f = explode(PHP_EOL, $data);
        $EdiParser->parse($f);

        //save data
        $prepare_date = $EdiParser->readEdiDataValue('UNB', 4, 0);
        $prepare_time = $EdiParser->readEdiDataValue('UNB', 4, 1);
        $prepare_datetime = preg_replace('#(\d\d)(\d\d)(\d\d)#', '20$1-$2-$3', $prepare_date)
                . ' '
                . preg_replace('#(\d\d)(\d\d)#', '$1:$2', $prepare_time);

        $edifact = new Edifact();
        $edifact->terminal = $EdiParser->readEdiDataValue('UNB', 2);
        $edifact->message_ref_number = $EdiParser->readEdiDataValue('UNH', 1);
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
        $analyser->edi_message = $edifact->message;
        $mapping_segments = realpath(Yii::getPathOfAlias('edifact-parser')) . '/Mapping/d95b/segments.xml';
        $analyser->loadSegmentsXml($mapping_segments);
        $text = $analyser->process($parsed);

        $save_file_path = Yii::app()->params['edi_analyzer']['result_path'] . '/edi_analyze_' . $edi_id . '.txt';

        file_put_contents($save_file_path, $text);
    }

    public function readEdiData($edi_id) {
        
       $edifact = Edifact::model()->FindByPk($edi_id);

        $parser = new EDI\Parser();
        $f = explode(PHP_EOL, $edifact->message);
        $parser->parse($f);

        $plain_data = array(
            'messageType' => $parser->readEdiDataValue('BGM', 1), //36 - Gate Out 34 - Gate In
            'interchangeSender' => $parser->readEdiDataValue('UNB', 2),
            'dateTimePreparation' => $parser->readEdiDataValue('UNB', 4, 0) . $parser->readEdiDataValue('UNB', 4, 1),
            'messageReferenceNumber' => $parser->readEdiDataValue('UNH', 1),
            'conveyanceReferenceNumber' => $parser->readEdiDataValue(['TDT', ['1' => '20']], 2),
            'vessel' => $parser->readEdiDataValue(['TDT', ['1' => '20']], 8, 3),
            'portOfDischarge' => $parser->readEdiDataValue(['LOC', ['1' => '11']], 2, 0),
            'arrivalDateTimeEstimated' => $parser->readEdiSegmentDTM('132'),
            'arrivalDateTimeActual' => $parser->readEdiSegmentDTM('178'),
            'departureDateTimeEstimated' => $parser->readEdiSegmentDTM('133'),
            'carrier' => $parser->readEdiDataValue(['NAD', ['1' => 'MS']], 2, 0),
            'goodsItemNumber' => $parser->readEdiDataValue('GID', 1),
            'equipmentIdentification' => $parser->readEdiDataValue('EQD', 2),
            //'equipmentEmpty' => $parser->readEdiDataValue($filter_EQD_EMPTY,3,4),
            'BookingreferenceNumber' => $parser->readEdiDataValue(['RFF', ['1.0' => 'BN']], 1, 1),
            'RealiseReferenceNumber' => $parser->readEdiDataValue(['RFF', ['1.0' => 'RE']], 1, 1),
            'PositioningDatetimeOfEquipment' => $parser->readEdiSegmentDTM('181'),
            'ActivityLocation' => $parser->readEdiDataValue(['LOC', ['1' => '165']], 2, 0),
            'ActivityLocationRelatedPlace' => $parser->readEdiDataValue(['LOC', ['1' => '165']], 3, 0),
            'GrossWeight' => $parser->readEdiDataValue(['MEA', ['2' => 'G']], 3, 0) . ' ' . $parser->readEdiDataValue(['MEA', ['2' => 'G']], 3, 1),
            'TareWeight' => $parser->readEdiDataValue(['MEA', ['2' => 'T']], 3, 0) . ' ' . $parser->readEdiDataValue(['MEA', ['2' => 'T']], 3, 1),
            'CarRegNumber' => $parser->readEdiDataValue(['TDT', ['1' => '1']], 8, 0),
        );

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
