<?php

class m141218_183435_ecnt_add_move_code extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `ecnt_container`   
                ADD COLUMN `ecnt_move_code` ENUM('LV','TF','VF','VE','DF','DE','LD','TE') NULL AFTER `ecnt_message_type`;
            ALTER TABLE `ecnt_container`   
                ADD COLUMN `ecnt_error` ENUM('SQN','7DAYS') NULL AFTER `ecnt_time_calc_notes`;    
            CREATE TABLE `ecer_errors`(  
              `ecer_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
              `ecer_ecnt_id` INT UNSIGNED NOT NULL,
              `ecer_descr` TEXT NOT NULL,
              `ecer_status` ENUM('NEW','CLOSED') NOT NULL DEFAULT 'NEW',
              PRIMARY KEY (`ecer_id`),
              FOREIGN KEY (`ecer_ecnt_id`) REFERENCES `ecnt_container`(`ecnt_id`)
            ) ENGINE=INNODB CHARSET=utf8;                
            ALTER TABLE `ecer_errors`   
              ADD COLUMN `ecer_notes` TEXT NULL AFTER `ecer_descr`;
        ");
	}

	public function down()
	{
		echo "m141218_183435_ecnt_add_move_code does not support migration down.\n";
		return false;
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