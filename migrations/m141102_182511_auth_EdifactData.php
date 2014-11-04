<?php
 
class m141102_182511_auth_EdifactData extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EdifactData.*','0','Edifactdata.EdifactData',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EdifactData.Create','0','Edifactdata.EdifactData module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EdifactData.View','0','Edifactdata.EdifactData module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EdifactData.Update','0','Edifactdata.EdifactData module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EdifactData.Delete','0','Edifactdata.EdifactData module delete',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EdifactData.Menu','0','Edifactdata.EdifactData show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EdifactData.*';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EdifactData.Create';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EdifactData.View';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EdifactData.Update';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EdifactData.Delete';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EdifactData.Menu';

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


