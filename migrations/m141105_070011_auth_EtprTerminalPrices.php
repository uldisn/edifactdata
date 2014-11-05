<?php
 
class m141105_070011_auth_EtprTerminalPrices extends CDbMigration
{

    public function up()
    {
        $this->execute("
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EtprTerminalPrices.*','0','Edifactdata.EtprTerminalPrices',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EtprTerminalPrices.Create','0','Edifactdata.EtprTerminalPrices module create',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EtprTerminalPrices.View','0','Edifactdata.EtprTerminalPrices module view',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EtprTerminalPrices.Update','0','Edifactdata.EtprTerminalPrices module update',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EtprTerminalPrices.Delete','0','Edifactdata.EtprTerminalPrices module delete',NULL,'N;');
            INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES('Edifactdata.EtprTerminalPrices.Menu','0','Edifactdata.EtprTerminalPrices show menu',NULL,'N;');
                

        ");
    }

    public function down()
    {
        $this->execute("
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EtprTerminalPrices.*';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EtprTerminalPrices.Create';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EtprTerminalPrices.View';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EtprTerminalPrices.Update';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EtprTerminalPrices.Delete';
            DELETE FROM `authitem` WHERE `name`= 'Edifactdata.EtprTerminalPrices.Menu';

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


