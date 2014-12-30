<?php

class m141230_070528_ecnt_alter extends EDbMigration
{
	public function up()
	{
       $this->execute("
            ALTER TABLE `ecnt_container`   
                CHANGE `ecnt_edifact_id` `ecnt_edifact_id` INT(10) UNSIGNED NULL;

        ");        
	}

	public function down()
	{
		echo "m141230_070528_ecnt_alter does not support migration down.\n";
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