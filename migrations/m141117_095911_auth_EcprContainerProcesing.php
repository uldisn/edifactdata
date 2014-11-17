<?php
 
class m141117_095911_auth_EcprContainerProcesing extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcprContainerProcesing.*','0','Edifactdata.EcprContainerProcesing',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcprContainerProcesing.Create','0','Edifactdata.EcprContainerProcesing module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcprContainerProcesing.View','0','Edifactdata.EcprContainerProcesing module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcprContainerProcesing.Update','0','Edifactdata.EcprContainerProcesing module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcprContainerProcesing.Delete','0','Edifactdata.EcprContainerProcesing module delete',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcprContainerProcesing.Menu','0','Edifactdata.EcprContainerProcesing show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcprContainerProcesing.*';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcprContainerProcesing.Create';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcprContainerProcesing.View';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcprContainerProcesing.Update';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcprContainerProcesing.Delete';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcprContainerProcesing.Menu';

        ");
    }

    public function safeUp()
    {
        $this->up();
    }

    public function safeDown()
    {
        $this->down();
    }
}


