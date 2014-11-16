<?php
 
class m141116_143411_auth_Edifact extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.Edifact.*','0','Edifactdata.Edifact',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.Edifact.Create','0','Edifactdata.Edifact module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.Edifact.View','0','Edifactdata.Edifact module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.Edifact.Update','0','Edifactdata.Edifact module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.Edifact.Delete','0','Edifactdata.Edifact module delete',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.Edifact.Menu','0','Edifactdata.Edifact show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.Edifact.*';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.Edifact.Create';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.Edifact.View';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.Edifact.Update';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.Edifact.Delete';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.Edifact.Menu';

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


