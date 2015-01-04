<?php

class m150102_105906_cctc_create extends EDbMigration
{
	public function up()
	{
         $this->execute("
           CREATE TABLE `cctc_type_codes` (
  `cctc_code` varchar(4) NOT NULL,
  `cctc_description` varchar(100) DEFAULT NULL,
  `cctc_css_class` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cctc_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


             
        ");
	
        
        
       
         $this->execute("
           insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('2200','20\' Dry Van','label label-large ');
insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('22G0','20\' Dry Van','label label-large ');
insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('22G1','20\' Dry Van','label label-large ');
insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('4200','40\' Dry Van','label label-large arrowed-right');
insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('4500','40\' High Cube','label label-large  arrowed-right label-info');
insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('45G0','40\' High Cube','label label-large  arrowed-right label-info');
insert  into `cctc_type_codes`(`cctc_code`,`cctc_description`,`cctc_css_class`) values ('45G1','40\' High Cube','label label-large  arrowed-right label-info');

             
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