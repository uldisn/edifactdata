<?php

/**
 * This is the model base class for the table "ecnt_container".
 *
 * Columns in table "ecnt_container" available as properties of the model:
 * @property string $ecnt_id
 * @property string $ecnt_edifact_id
 * @property string $ecnt_terminal
 * @property string $ecnt_message_type
 * @property string $ecnt_container_nr
 * @property string $ecnt_datetime
 * @property string $ecnt_operation
 * @property string $ecnt_transport_id
 * @property string $ecnt_length
 * @property string $ecnt_iso_type
 * @property string $ecnt_ib_carrier
 * @property string $ecnt_ob_carrier
 * @property integer $ecnt_weight
 * @property string $ecnt_statuss
 * @property string $ecnt_line
 * @property string $ecnt_fwd
 * @property string $ecnt_booking
 * @property string $ecnt_eu_status
 * @property string $ecnt_imo_code
 * @property string $ecnt_notes
 *
 * Relations of table "ecnt_container" available as properties of the model:
 * @property Edifact $ecntEdifact
 */
abstract class BaseEcntContainer extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const ECNT_OPERATION_TRUCK_IN = 'TRUCK_IN';
    const ECNT_OPERATION_TRUCK_OUT = 'TRUCK_OUT';
    const ECNT_OPERATION_VESSEL_LOAD = 'VESSEL_LOAD';
    const ECNT_OPERATION_VESSEL_DISCHARGE = 'VESSEL_DISCHARGE';
    const ECNT_LENGTH_40 = '40';
    const ECNT_LENGTH_20 = '20';
    const ECNT_STATUSS_EMPTY = 'EMPTY';
    const ECNT_STATUSS_FULL = 'FULL';
    const ECNT_EU_STATUS_C = 'C';
    const ECNT_EU_STATUS_N = 'N';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ecnt_container';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('ecnt_edifact_id, ecnt_terminal', 'required'),
                array('ecnt_message_type, ecnt_container_nr, ecnt_datetime, ecnt_operation, ecnt_transport_id, ecnt_length, ecnt_iso_type, ecnt_ib_carrier, ecnt_ob_carrier, ecnt_weight, ecnt_statuss, ecnt_line, ecnt_fwd, ecnt_booking, ecnt_eu_status, ecnt_imo_code, ecnt_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('ecnt_weight', 'numerical', 'integerOnly' => true),
                array('ecnt_edifact_id, ecnt_terminal, ecnt_message_type', 'length', 'max' => 10),
                array('ecnt_container_nr, ecnt_transport_id, ecnt_iso_type, ecnt_ib_carrier, ecnt_ob_carrier, ecnt_line, ecnt_fwd, ecnt_booking, ecnt_imo_code', 'length', 'max' => 50),
                array('ecnt_datetime, ecnt_notes', 'safe'),
                array('ecnt_operation', 'in', 'range' => array(self::ECNT_OPERATION_TRUCK_IN, self::ECNT_OPERATION_TRUCK_OUT, self::ECNT_OPERATION_VESSEL_LOAD, self::ECNT_OPERATION_VESSEL_DISCHARGE)),
                array('ecnt_length', 'in', 'range' => array(self::ECNT_LENGTH_40, self::ECNT_LENGTH_20)),
                array('ecnt_statuss', 'in', 'range' => array(self::ECNT_STATUSS_EMPTY, self::ECNT_STATUSS_FULL)),
                array('ecnt_eu_status', 'in', 'range' => array(self::ECNT_EU_STATUS_C, self::ECNT_EU_STATUS_N)),
                array('ecnt_id, ecnt_edifact_id, ecnt_terminal, ecnt_message_type, ecnt_container_nr, ecnt_datetime, ecnt_operation, ecnt_transport_id, ecnt_length, ecnt_iso_type, ecnt_ib_carrier, ecnt_ob_carrier, ecnt_weight, ecnt_statuss, ecnt_line, ecnt_fwd, ecnt_booking, ecnt_eu_status, ecnt_imo_code, ecnt_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->ecnt_edifact_id;
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
                'ecntEdifact' => array(self::BELONGS_TO, 'Edifact', 'ecnt_edifact_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'ecnt_id' => Yii::t('EdifactDataModule.model', 'Ecnt'),
            'ecnt_edifact_id' => Yii::t('EdifactDataModule.model', 'Ecnt Edifact'),
            'ecnt_terminal' => Yii::t('EdifactDataModule.model', 'Ecnt Terminal'),
            'ecnt_message_type' => Yii::t('EdifactDataModule.model', 'Ecnt Message Type'),
            'ecnt_container_nr' => Yii::t('EdifactDataModule.model', 'Ecnt Container Nr'),
            'ecnt_datetime' => Yii::t('EdifactDataModule.model', 'Ecnt Datetime'),
            'ecnt_operation' => Yii::t('EdifactDataModule.model', 'Ecnt Operation'),
            'ecnt_transport_id' => Yii::t('EdifactDataModule.model', 'Ecnt Transport'),
            'ecnt_length' => Yii::t('EdifactDataModule.model', 'Ecnt Length'),
            'ecnt_iso_type' => Yii::t('EdifactDataModule.model', 'Ecnt Iso Type'),
            'ecnt_ib_carrier' => Yii::t('EdifactDataModule.model', 'Ecnt Ib Carrier'),
            'ecnt_ob_carrier' => Yii::t('EdifactDataModule.model', 'Ecnt Ob Carrier'),
            'ecnt_weight' => Yii::t('EdifactDataModule.model', 'Ecnt Weight'),
            'ecnt_statuss' => Yii::t('EdifactDataModule.model', 'Ecnt Statuss'),
            'ecnt_line' => Yii::t('EdifactDataModule.model', 'Ecnt Line'),
            'ecnt_fwd' => Yii::t('EdifactDataModule.model', 'Ecnt Fwd'),
            'ecnt_booking' => Yii::t('EdifactDataModule.model', 'Ecnt Booking'),
            'ecnt_eu_status' => Yii::t('EdifactDataModule.model', 'Ecnt Eu Status'),
            'ecnt_imo_code' => Yii::t('EdifactDataModule.model', 'Ecnt Imo Code'),
            'ecnt_notes' => Yii::t('EdifactDataModule.model', 'Ecnt Notes'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'ecnt_operation' => array(
               self::ECNT_OPERATION_TRUCK_IN => Yii::t('EdifactDataModule.model', 'ECNT_OPERATION_TRUCK_IN'),
               self::ECNT_OPERATION_TRUCK_OUT => Yii::t('EdifactDataModule.model', 'ECNT_OPERATION_TRUCK_OUT'),
               self::ECNT_OPERATION_VESSEL_LOAD => Yii::t('EdifactDataModule.model', 'ECNT_OPERATION_VESSEL_LOAD'),
               self::ECNT_OPERATION_VESSEL_DISCHARGE => Yii::t('EdifactDataModule.model', 'ECNT_OPERATION_VESSEL_DISCHARGE'),
           ),
           'ecnt_length' => array(
               self::ECNT_LENGTH_40 => Yii::t('EdifactDataModule.model', 'ECNT_LENGTH_40'),
               self::ECNT_LENGTH_20 => Yii::t('EdifactDataModule.model', 'ECNT_LENGTH_20'),
           ),
           'ecnt_statuss' => array(
               self::ECNT_STATUSS_EMPTY => Yii::t('EdifactDataModule.model', 'ECNT_STATUSS_EMPTY'),
               self::ECNT_STATUSS_FULL => Yii::t('EdifactDataModule.model', 'ECNT_STATUSS_FULL'),
           ),
           'ecnt_eu_status' => array(
               self::ECNT_EU_STATUS_C => Yii::t('EdifactDataModule.model', 'ECNT_EU_STATUS_C'),
               self::ECNT_EU_STATUS_N => Yii::t('EdifactDataModule.model', 'ECNT_EU_STATUS_N'),
           ),
            );
        return $this->enum_labels;
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }

    public function getEnumColumnLabel($column){
        return $this->getEnumLabel($column,$this->$column);
    }
    

    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.ecnt_id', $this->ecnt_id, true);
        $criteria->compare('t.ecnt_edifact_id', $this->ecnt_edifact_id);
        $criteria->compare('t.ecnt_terminal', $this->ecnt_terminal, true);
        $criteria->compare('t.ecnt_message_type', $this->ecnt_message_type, true);
        $criteria->compare('t.ecnt_container_nr', $this->ecnt_container_nr, true);
        $criteria->compare('t.ecnt_datetime', $this->ecnt_datetime, true);
        $criteria->compare('t.ecnt_operation', $this->ecnt_operation);
        $criteria->compare('t.ecnt_transport_id', $this->ecnt_transport_id, true);
        $criteria->compare('t.ecnt_length', $this->ecnt_length);
        $criteria->compare('t.ecnt_iso_type', $this->ecnt_iso_type, true);
        $criteria->compare('t.ecnt_ib_carrier', $this->ecnt_ib_carrier, true);
        $criteria->compare('t.ecnt_ob_carrier', $this->ecnt_ob_carrier, true);
        $criteria->compare('t.ecnt_weight', $this->ecnt_weight);
        $criteria->compare('t.ecnt_statuss', $this->ecnt_statuss);
        $criteria->compare('t.ecnt_line', $this->ecnt_line, true);
        $criteria->compare('t.ecnt_fwd', $this->ecnt_fwd, true);
        $criteria->compare('t.ecnt_booking', $this->ecnt_booking, true);
        $criteria->compare('t.ecnt_eu_status', $this->ecnt_eu_status);
        $criteria->compare('t.ecnt_imo_code', $this->ecnt_imo_code, true);
        $criteria->compare('t.ecnt_notes', $this->ecnt_notes, true);


        return $criteria;

    }

}
