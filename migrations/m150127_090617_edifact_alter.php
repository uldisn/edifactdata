<?php

class m150127_090617_edifact_alter extends EDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `edifact`   
                CHANGE `message_ref_number` `message_ref_number` VARCHAR(40) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
                CHANGE `filename` `filename` VARCHAR(250) CHARSET latin1 COLLATE latin1_swedish_ci NULL;
");
	}

	public function down()
	{
		echo "m150127_090617_edifact_alter does not support migration down.\n";
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