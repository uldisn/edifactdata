<?php

class m141116_123327_ecnt_alter extends EDbMigration
{
	public function up()
	{
        $this->execute("
            
/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `ecnt_container` 
	DROP FOREIGN KEY `ecnt_container_ibfk_1`  ;


/* Alter table in target */
ALTER TABLE `ecnt_container` 
	ADD COLUMN `ecnt_ecpr_id` int(10) unsigned   NULL after `ecnt_edifact_id` , 
	CHANGE `ecnt_terminal` `ecnt_terminal` varchar(10)  COLLATE utf8_general_ci NOT NULL after `ecnt_ecpr_id` , 
	CHANGE `ecnt_message_type` `ecnt_message_type` varchar(10)  COLLATE utf8_general_ci NULL after `ecnt_terminal` , 
	CHANGE `ecnt_container_nr` `ecnt_container_nr` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_message_type` , 
	CHANGE `ecnt_datetime` `ecnt_datetime` datetime   NULL after `ecnt_container_nr` , 
	CHANGE `ecnt_operation` `ecnt_operation` enum('TRUCK_IN','TRUCK_OUT','VESSEL_LOAD','VESSEL_DISCHARGE')  COLLATE utf8_general_ci NULL after `ecnt_datetime` , 
	CHANGE `ecnt_transport_id` `ecnt_transport_id` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_operation` , 
	CHANGE `ecnt_length` `ecnt_length` enum('40','20')  COLLATE utf8_general_ci NULL after `ecnt_transport_id` , 
	CHANGE `ecnt_iso_type` `ecnt_iso_type` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_length` , 
	CHANGE `ecnt_ib_carrier` `ecnt_ib_carrier` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_iso_type` , 
	CHANGE `ecnt_ob_carrier` `ecnt_ob_carrier` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_ib_carrier` , 
	CHANGE `ecnt_weight` `ecnt_weight` smallint(6)   NULL COMMENT 'KG' after `ecnt_ob_carrier` , 
	CHANGE `ecnt_statuss` `ecnt_statuss` enum('EMPTY','FULL')  COLLATE utf8_general_ci NULL after `ecnt_weight` , 
	CHANGE `ecnt_line` `ecnt_line` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_statuss` , 
	CHANGE `ecnt_fwd` `ecnt_fwd` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_line` , 
	CHANGE `ecnt_booking` `ecnt_booking` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_fwd` , 
	CHANGE `ecnt_eu_status` `ecnt_eu_status` enum('C','N')  COLLATE utf8_general_ci NULL after `ecnt_booking` , 
	CHANGE `ecnt_imo_code` `ecnt_imo_code` varchar(50)  COLLATE utf8_general_ci NULL after `ecnt_eu_status` , 
	CHANGE `ecnt_notes` `ecnt_notes` text  COLLATE utf8_general_ci NULL after `ecnt_imo_code` , 
	ADD COLUMN `ecnt_etpr_id` smallint(5) unsigned   NULL after `ecnt_notes` , 
	ADD COLUMN `ecnt_action_amt` decimal(8,2) unsigned   NULL after `ecnt_etpr_id` , 
	ADD COLUMN `ecnt_time_amt` decimal(8,2) unsigned   NULL after `ecnt_action_amt` , 
	ADD COLUMN `ecnt_action_calc_notes` text  COLLATE utf8_general_ci NULL after `ecnt_time_amt` , 
	ADD COLUMN `ecnt_time_calc_notes` text  COLLATE utf8_general_ci NULL after `ecnt_action_calc_notes` , 
	ADD KEY `ecnt_ecpr_id`(`ecnt_ecpr_id`) , 
	ADD KEY `ecnt_etpr_id`(`ecnt_etpr_id`) ;

/* Create table in target */
CREATE TABLE `ecpr_container_procesing`(
	`ecpr_id` int(10) unsigned NOT NULL  auto_increment , 
	`ecpr_start_ecnt_id` int(10) unsigned NOT NULL  , 
	`ecpr_end_ecnt_id` int(10) unsigned NULL  , 
	PRIMARY KEY (`ecpr_id`) , 
	KEY `ecpr_start_ecnt_id`(`ecpr_start_ecnt_id`) , 
	KEY `ecpr_end_ecnt_id`(`ecpr_end_ecnt_id`) , 
	CONSTRAINT `ecpr_container_procesing_ibfk_1` 
	FOREIGN KEY (`ecpr_start_ecnt_id`) REFERENCES `ecnt_container` (`ecnt_id`) , 
	CONSTRAINT `ecpr_container_procesing_ibfk_2` 
	FOREIGN KEY (`ecpr_end_ecnt_id`) REFERENCES `ecnt_container` (`ecnt_id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


ALTER TABLE `ecnt_container`
	ADD CONSTRAINT `ecnt_container_ibfk_2` 
	FOREIGN KEY (`ecnt_ecpr_id`) REFERENCES `ecpr_container_procesing` (`ecpr_id`) , 
	ADD CONSTRAINT `ecnt_container_ibfk_3` 
	FOREIGN KEY (`ecnt_etpr_id`) REFERENCES `etpr_terminal_prices` (`etpr_id`) ;

/* The foreign keys that were dropped are now re-created*/

ALTER TABLE `ecnt_container` 
	ADD CONSTRAINT `ecnt_container_ibfk_1` 
	FOREIGN KEY (`ecnt_edifact_id`) REFERENCES `edifact` (`id`) ;


            ");
	}

	public function down()
	{
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