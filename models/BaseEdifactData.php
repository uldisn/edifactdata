<?php

/**
 * This is the model base class for the table "edifact_data".
 *
 * Columns in table "edifact_data" available as properties of the model:
 * @property string $id
 * @property string $edifact_id
 * @property integer $messageType
 * @property string $interchangeSender
 * @property string $dateTimePreparation
 * @property string $messageReferenceNumber
 * @property string $conveyanceReferenceNumber
 * @property string $idOfTheMeansOfTransportVessel
 * @property string $portOfDischarge
 * @property string $arrivalDateTimeEstimated
 * @property string $arrivalDateTimeActual
 * @property string $departureDateTimeEstimated
 * @property string $carrier
 * @property string $equipmentIdentification
 * @property string $BookingreferenceNumber
 * @property string $RealiseReferenceNumber
 * @property string $PositioningDatetimeOfEquipment
 * @property string $ActivityLocation
 * @property string $ActivityLocationRelatedPlace
 * @property string $GrossWeight
 * @property string $TareWeight
 * @property string $CarRegNumber
 *
 * Relations of table "edifact_data" available as properties of the model:
 * @property Edifact $edifact
 */
abstract class BaseEdifactData extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'edifact_data';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('edifact_id, messageType, dateTimePreparation, messageReferenceNumber', 'required'),
                array('interchangeSender, conveyanceReferenceNumber, idOfTheMeansOfTransportVessel, portOfDischarge, arrivalDateTimeEstimated, arrivalDateTimeActual, departureDateTimeEstimated, carrier, equipmentIdentification, BookingreferenceNumber, RealiseReferenceNumber, PositioningDatetimeOfEquipment, ActivityLocation, ActivityLocationRelatedPlace, GrossWeight, TareWeight, CarRegNumber', 'default', 'setOnEmpty' => true, 'value' => null),
                array('messageType', 'numerical', 'integerOnly' => true),
                array('edifact_id, interchangeSender, portOfDischarge, carrier, ActivityLocation, CarRegNumber', 'length', 'max' => 10),
                array('messageReferenceNumber, conveyanceReferenceNumber, idOfTheMeansOfTransportVessel, BookingreferenceNumber, RealiseReferenceNumber', 'length', 'max' => 100),
                array('equipmentIdentification, ActivityLocationRelatedPlace, GrossWeight, TareWeight', 'length', 'max' => 20),
                array('arrivalDateTimeEstimated, arrivalDateTimeActual, departureDateTimeEstimated, PositioningDatetimeOfEquipment', 'safe'),
                array('id, edifact_id, messageType, interchangeSender, dateTimePreparation, messageReferenceNumber, conveyanceReferenceNumber, idOfTheMeansOfTransportVessel, portOfDischarge, arrivalDateTimeEstimated, arrivalDateTimeActual, departureDateTimeEstimated, carrier, equipmentIdentification, BookingreferenceNumber, RealiseReferenceNumber, PositioningDatetimeOfEquipment, ActivityLocation, ActivityLocationRelatedPlace, GrossWeight, TareWeight, CarRegNumber', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->edifact_id;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
                'edifact' => array(self::BELONGS_TO, 'Edifact', 'edifact_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('EdifactDataModule.model', 'ID'),
            'edifact_id' => Yii::t('EdifactDataModule.model', 'Edifact'),
            'messageType' => Yii::t('EdifactDataModule.model', 'Message Type'),
            'interchangeSender' => Yii::t('EdifactDataModule.model', 'Interchange Sender'),
            'dateTimePreparation' => Yii::t('EdifactDataModule.model', 'Date Time Preparation'),
            'messageReferenceNumber' => Yii::t('EdifactDataModule.model', 'Message Reference Number'),
            'conveyanceReferenceNumber' => Yii::t('EdifactDataModule.model', 'Conveyance Reference Number'),
            'idOfTheMeansOfTransportVessel' => Yii::t('EdifactDataModule.model', 'Id Of The Means Of Transport Vessel'),
            'portOfDischarge' => Yii::t('EdifactDataModule.model', 'Port Of Discharge'),
            'arrivalDateTimeEstimated' => Yii::t('EdifactDataModule.model', 'Arrival Date Time Estimated'),
            'arrivalDateTimeActual' => Yii::t('EdifactDataModule.model', 'Arrival Date Time Actual'),
            'departureDateTimeEstimated' => Yii::t('EdifactDataModule.model', 'Departure Date Time Estimated'),
            'carrier' => Yii::t('EdifactDataModule.model', 'Carrier'),
            'equipmentIdentification' => Yii::t('EdifactDataModule.model', 'Equipment Identification'),
            'BookingreferenceNumber' => Yii::t('EdifactDataModule.model', 'Bookingreference Number'),
            'RealiseReferenceNumber' => Yii::t('EdifactDataModule.model', 'Realise Reference Number'),
            'PositioningDatetimeOfEquipment' => Yii::t('EdifactDataModule.model', 'Positioning Datetime Of Equipment'),
            'ActivityLocation' => Yii::t('EdifactDataModule.model', 'Activity Location'),
            'ActivityLocationRelatedPlace' => Yii::t('EdifactDataModule.model', 'Activity Location Related Place'),
            'GrossWeight' => Yii::t('EdifactDataModule.model', 'Gross Weight'),
            'TareWeight' => Yii::t('EdifactDataModule.model', 'Tare Weight'),
            'CarRegNumber' => Yii::t('EdifactDataModule.model', 'Car Reg Number'),
        );
    }

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.edifact_id', $this->edifact_id);
        $criteria->compare('t.messageType', $this->messageType);
        $criteria->compare('t.interchangeSender', $this->interchangeSender, true);
        $criteria->compare('t.dateTimePreparation', $this->dateTimePreparation, true);
        $criteria->compare('t.messageReferenceNumber', $this->messageReferenceNumber, true);
        $criteria->compare('t.conveyanceReferenceNumber', $this->conveyanceReferenceNumber, true);
        $criteria->compare('t.idOfTheMeansOfTransportVessel', $this->idOfTheMeansOfTransportVessel, true);
        $criteria->compare('t.portOfDischarge', $this->portOfDischarge, true);
        $criteria->compare('t.arrivalDateTimeEstimated', $this->arrivalDateTimeEstimated, true);
        $criteria->compare('t.arrivalDateTimeActual', $this->arrivalDateTimeActual, true);
        $criteria->compare('t.departureDateTimeEstimated', $this->departureDateTimeEstimated, true);
        $criteria->compare('t.carrier', $this->carrier, true);
        $criteria->compare('t.equipmentIdentification', $this->equipmentIdentification, true);
        $criteria->compare('t.BookingreferenceNumber', $this->BookingreferenceNumber, true);
        $criteria->compare('t.RealiseReferenceNumber', $this->RealiseReferenceNumber, true);
        $criteria->compare('t.PositioningDatetimeOfEquipment', $this->PositioningDatetimeOfEquipment, true);
        $criteria->compare('t.ActivityLocation', $this->ActivityLocation, true);
        $criteria->compare('t.ActivityLocationRelatedPlace', $this->ActivityLocationRelatedPlace, true);
        $criteria->compare('t.GrossWeight', $this->GrossWeight, true);
        $criteria->compare('t.TareWeight', $this->TareWeight, true);
        $criteria->compare('t.CarRegNumber', $this->CarRegNumber, true);


        return $criteria;

    }

}
