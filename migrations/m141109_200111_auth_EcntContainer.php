<?php
 
class m141109_200111_auth_EcntContainer extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcntContainer.*','0','Edifactdata.EcntContainer',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcntContainer.Create','0','Edifactdata.EcntContainer module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcntContainer.View','0','Edifactdata.EcntContainer module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcntContainer.Update','0','Edifactdata.EcntContainer module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcntContainer.Delete','0','Edifactdata.EcntContainer module delete',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EcntContainer.Menu','0','Edifactdata.EcntContainer show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcntContainer.*';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcntContainer.Create';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcntContainer.View';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcntContainer.Update';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcntContainer.Delete';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EcntContainer.Menu';

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


