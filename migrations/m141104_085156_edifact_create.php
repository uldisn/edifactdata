<?php

class m141104_085156_edifact_create extends EDbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE `edifact` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `terminal` char(5) DEFAULT NULL,
              `prep_datetime` datetime DEFAULT NULL,
              `message_ref_number` char(20) DEFAULT NULL,
              `filename` char(20) DEFAULT NULL,
              `message` text,
              `create_datetime` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
            
            CREATE TABLE `edifact_data` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `edifact_id` int(10) unsigned NOT NULL,
              `messageType` smallint(6) NOT NULL,
              `interchangeSender` char(10) DEFAULT NULL,
              `dateTimePreparation` datetime NOT NULL,
              `messageReferenceNumber` varchar(100) NOT NULL,
              `conveyanceReferenceNumber` varchar(100) DEFAULT NULL,
              `idOfTheMeansOfTransportVessel` varchar(100) DEFAULT NULL,
              `portOfDischarge` char(10) DEFAULT NULL,
              `arrivalDateTimeEstimated` datetime DEFAULT NULL,
              `arrivalDateTimeActual` datetime DEFAULT NULL,
              `departureDateTimeEstimated` datetime DEFAULT NULL,
              `carrier` char(10) DEFAULT NULL,
              `equipmentIdentification` char(20) DEFAULT NULL,
              `BookingreferenceNumber` varchar(100) DEFAULT NULL,
              `RealiseReferenceNumber` varchar(100) DEFAULT NULL,
              `PositioningDatetimeOfEquipment` datetime DEFAULT NULL,
              `ActivityLocation` char(10) DEFAULT NULL,
              `ActivityLocationRelatedPlace` char(20) DEFAULT NULL,
              `GrossWeight` varchar(20) DEFAULT NULL,
              `TareWeight` varchar(20) DEFAULT NULL,
              `CarRegNumber` char(10) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `edifact_id` (`edifact_id`),
              CONSTRAINT `edifact_data_ibfk_1` FOREIGN KEY (`edifact_id`) REFERENCES `edifact` (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1

        ");
	}

	public function down()
	{
        $this->execute("
            DROP TABLE `edifact_data`;
            DROP TABLE `edifact`;
        ");
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