<?php

class ContainerReader extends EDI\Reader {

    public function __construct($url = null) {
        parent::__construct($url);
    }

    public function readDateTimePreparation() {
        $dateTimePreparation = $this->readEdiDataValue('UNB', 4, 0) . $this->readEdiDataValue('UNB', 4, 1);
        if (empty($dateTimePreparation)) {
            $dateTimePreparation = $this->readEdiDataValue('UNB', 4);
        }

        return $dateTimePreparation;
    }

    public function readFullEmpty() {
        //8169 - fullemptyIndicatorCoded
        //To indicate the extent to which the equipment is full or empty.
        $FullEmpty = $this->readEdiDataValue('EQD', 6);
        if ($FullEmpty == 4) {
            return EcntContainer::ECNT_STATUSS_EMPTY;
        }
        if ($FullEmpty == 5) {
            return EcntContainer::ECNT_STATUSS_FULL;
        }

        $this->errors[] = 'Neatrada empty/full';
        return false;
    }

}
