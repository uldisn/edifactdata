<?php

class m141107_080656_alter_edifact extends EDbMigration
{
	public function up()
	{
         $this->execute("
                ALTER TABLE `edifact`   
                  CHANGE `terminal` `terminal` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL;
             ");
	}

	public function down()
	{
         $this->execute("
                ALTER TABLE `edifact`   
                  CHANGE `terminal` `terminal` CHAR(5) CHARSET latin1 COLLATE latin1_swedish_ci NULL;
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