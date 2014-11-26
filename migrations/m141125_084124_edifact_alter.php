<?php

class m141125_084124_edifact_alter extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `edifact`   
              ADD COLUMN `status` ENUM('PROCESSED','NEW','ERROR') DEFAULT 'NEW'   NULL AFTER `create_datetime`,
              ADD COLUMN `error` TEXT NULL AFTER `status`,
              ADD COLUMN `bgm_1_id` SMALLINT NULL AFTER `error`;

        ");        
	}

	public function down()
	{
		echo "m141125_084124_edifact_alter does not support migration down.\n";
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