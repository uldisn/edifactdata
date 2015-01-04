<?php

class m150102_105506_ccmc_create extends EDbMigration
{
	public function up()
	{
         $this->execute("
           CREATE TABLE `ccmc_move_codes` (
  `ccmc_code` varchar(2) NOT NULL,
  `ccmc_short` varchar(100) DEFAULT NULL,
  `ccmc_long` varchar(255) DEFAULT NULL,
  `ccmc_css_class` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ccmc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

             
        ");
	
        
        
       
         $this->execute("
           insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('DE','Discharge empty','Empty container discharged from vessel','row_dischempty');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('DF','Discharge full','Full container discharged from vessel','row_dischfull');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('LD','Local devaning','Container dispatched for discharge','row_localdevaning');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('LV','Local vaning','Empty container dispatched for export loading','row_localvaning');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('TE','Terminal empty','Emply container returned to terminal','row_terminalempty');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('TF','Terminal full','Full container returned to terminal','row_terminalfull');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('VE','Vessel empty','Empty container loaded to vessel','row_vesselempty');
insert  into `ccmc_move_codes`(`ccmc_code`,`ccmc_short`,`ccmc_long`,`ccmc_css_class`) values ('VF','Vessel full','Full container loaded to vessel','row_vesselfull');


             
        ");
	}

	public function down()
	{
         $this->execute("
            DROP TABLE `ccmc_move_codes`;
             
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