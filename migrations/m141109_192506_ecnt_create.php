<?php

class m141109_192506_ecnt_create extends EDbMigration
{
	public function up()
	{
         $this->execute("
            CREATE TABLE `ecnt_container` (
              `ecnt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `ecnt_edifact_id` int(10) unsigned NOT NULL,
              `ecnt_terminal` varchar(10) NOT NULL,
              `ecnt_message_type` varchar(10) DEFAULT NULL,
              `ecnt_container_nr` varchar(50) DEFAULT NULL,
              `ecnt_datetime` datetime DEFAULT NULL,
              `ecnt_operation` enum('TRUCK_IN','TRUCK_OUT','VESSEL_LOAD','VESSEL_DISCHARGE') DEFAULT NULL,
              `ecnt_transport_id` varchar(50) DEFAULT NULL,
              `ecnt_length` enum('40','20') DEFAULT NULL,
              `ecnt_iso_type` varchar(50) DEFAULT NULL,
              `ecnt_ib_carrier` varchar(50) DEFAULT NULL,
              `ecnt_ob_carrier` varchar(50) DEFAULT NULL,
              `ecnt_weight` smallint(6) DEFAULT NULL COMMENT 'KG',
              `ecnt_statuss` enum('EMPTY','FULL') DEFAULT NULL,
              `ecnt_line` varchar(50) DEFAULT NULL,
              `ecnt_fwd` varchar(50) DEFAULT NULL,
              `ecnt_booking` varchar(50) DEFAULT NULL,
              `ecnt_eu_status` enum('C','N') DEFAULT NULL,
              `ecnt_imo_code` varchar(50) DEFAULT NULL,
              `ecnt_notes` text,
              PRIMARY KEY (`ecnt_id`),
              KEY `ecnt_edifact_id` (`ecnt_edifact_id`),
              CONSTRAINT `ecnt_container_ibfk_1` FOREIGN KEY (`ecnt_edifact_id`) REFERENCES `edifact` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
             
        ");
	}

	public function down()
	{
         $this->execute("
            DROP TABLE `ecnt_container`;
             
        ");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}