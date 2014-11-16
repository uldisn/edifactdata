<?php

/**
 * This is the model base class for the table "etpr_terminal_prices".
 *
 * Columns in table "etpr_terminal_prices" available as properties of the model:
 * @property integer $etpr_id
 * @property string $etpr_terminal
 * @property string $etpr_date_from
 * @property string $etpr_date_to
 * @property string $etpr_operation
 * @property string $etpr_container_status
 * @property string $etpr_container_size
 * @property integer $etpr_day_from
 * @property integer $etpr_day_to
 * @property string $etpr_price
 * @property string $etpr_imdg_price
 * @property string $etpr_imdg_coefficient
 * @property string $etpr_h68_2020_coefficient
 * @property string $etpr_hour_holiday_coefficient
 * @property string $etpr_notes
 *
 * Relations of table "etpr_terminal_prices" available as properties of the model:
 * @property EcntContainer[] $ecntContainers
 */
abstract class BaseEtprTerminalPrices extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const ETPR_OPERATION_LOADING = 'LOADING';
    const ETPR_OPERATION_STORAGE = 'STORAGE';
    const ETPR_OPERATION_LOADING_TRUCK = 'LOADING_TRUCK';
    const ETPR_OPERATION_LOADING_RW = 'LOADING_RW';
    const ETPR_OPERATION_MOVING_LT_STORAGE = 'MOVING_LT_STORAGE';
    const ETPR_OPERATION_MOVING_SS_PLACE = 'MOVING_SS_PLACE';
    const ETPR_CONTAINER_STATUS_FULL = 'FULL';
    const ETPR_CONTAINER_STATUS_EMPTY = 'EMPTY';
    const ETPR_CONTAINER_SIZE_20 = '20';
    const ETPR_CONTAINER_SIZE_40 = '40';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'etpr_terminal_prices';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('etpr_terminal, etpr_date_from, etpr_date_to, etpr_operation, etpr_container_status, etpr_price', 'required'),
                array('etpr_container_size, etpr_day_from, etpr_day_to, etpr_imdg_price, etpr_imdg_coefficient, etpr_h68_2020_coefficient, etpr_hour_holiday_coefficient, etpr_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('etpr_day_from, etpr_day_to', 'numerical', 'integerOnly' => true),
                array('etpr_price, etpr_imdg_price, etpr_imdg_coefficient, etpr_h68_2020_coefficient, etpr_hour_holiday_coefficient', 'type','type'=>'float'),
                array('etpr_terminal', 'length', 'max' => 10),
                array('etpr_price, etpr_imdg_price', 'length', 'max' => 7),
                array('etpr_imdg_coefficient, etpr_h68_2020_coefficient, etpr_hour_holiday_coefficient', 'length', 'max' => 4),
                array('etpr_notes', 'safe'),
                array('etpr_operation', 'in', 'range' => array(self::ETPR_OPERATION_LOADING, self::ETPR_OPERATION_STORAGE, self::ETPR_OPERATION_LOADING_TRUCK, self::ETPR_OPERATION_LOADING_RW, self::ETPR_OPERATION_MOVING_LT_STORAGE, self::ETPR_OPERATION_MOVING_SS_PLACE)),
                array('etpr_container_status', 'in', 'range' => array(self::ETPR_CONTAINER_STATUS_FULL, self::ETPR_CONTAINER_STATUS_EMPTY)),
                array('etpr_container_size', 'in', 'range' => array(self::ETPR_CONTAINER_SIZE_20, self::ETPR_CONTAINER_SIZE_40)),
                array('etpr_id, etpr_terminal, etpr_date_from, etpr_date_to, etpr_operation, etpr_container_status, etpr_container_size, etpr_day_from, etpr_day_to, etpr_price, etpr_imdg_price, etpr_imdg_coefficient, etpr_h68_2020_coefficient, etpr_hour_holiday_coefficient, etpr_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->etpr_terminal;
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
                'ecntContainers' => array(self::HAS_MANY, 'EcntContainer', 'ecnt_etpr_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'etpr_id' => Yii::t('EdifactDataModule.model', 'Etpr'),
            'etpr_terminal' => Yii::t('EdifactDataModule.model', 'Etpr Terminal'),
            'etpr_date_from' => Yii::t('EdifactDataModule.model', 'Etpr Date From'),
            'etpr_date_to' => Yii::t('EdifactDataModule.model', 'Etpr Date To'),
            'etpr_operation' => Yii::t('EdifactDataModule.model', 'Etpr Operation'),
            'etpr_container_status' => Yii::t('EdifactDataModule.model', 'Etpr Container Status'),
            'etpr_container_size' => Yii::t('EdifactDataModule.model', 'Etpr Container Size'),
            'etpr_day_from' => Yii::t('EdifactDataModule.model', 'Etpr Day From'),
            'etpr_day_to' => Yii::t('EdifactDataModule.model', 'Etpr Day To'),
            'etpr_price' => Yii::t('EdifactDataModule.model', 'Etpr Price'),
            'etpr_imdg_price' => Yii::t('EdifactDataModule.model', 'Etpr Imdg Price'),
            'etpr_imdg_coefficient' => Yii::t('EdifactDataModule.model', 'Etpr Imdg Coefficient'),
            'etpr_h68_2020_coefficient' => Yii::t('EdifactDataModule.model', 'Etpr H68 2020 Coefficient'),
            'etpr_hour_holiday_coefficient' => Yii::t('EdifactDataModule.model', 'Etpr Hour Holiday Coefficient'),
            'etpr_notes' => Yii::t('EdifactDataModule.model', 'Etpr Notes'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'etpr_operation' => array(
               self::ETPR_OPERATION_LOADING => Yii::t('EdifactDataModule.model', 'ETPR_OPERATION_LOADING'),
               self::ETPR_OPERATION_STORAGE => Yii::t('EdifactDataModule.model', 'ETPR_OPERATION_STORAGE'),
               self::ETPR_OPERATION_LOADING_TRUCK => Yii::t('EdifactDataModule.model', 'ETPR_OPERATION_LOADING_TRUCK'),
               self::ETPR_OPERATION_LOADING_RW => Yii::t('EdifactDataModule.model', 'ETPR_OPERATION_LOADING_RW'),
               self::ETPR_OPERATION_MOVING_LT_STORAGE => Yii::t('EdifactDataModule.model', 'ETPR_OPERATION_MOVING_LT_STORAGE'),
               self::ETPR_OPERATION_MOVING_SS_PLACE => Yii::t('EdifactDataModule.model', 'ETPR_OPERATION_MOVING_SS_PLACE'),
           ),
           'etpr_container_status' => array(
               self::ETPR_CONTAINER_STATUS_FULL => Yii::t('EdifactDataModule.model', 'ETPR_CONTAINER_STATUS_FULL'),
               self::ETPR_CONTAINER_STATUS_EMPTY => Yii::t('EdifactDataModule.model', 'ETPR_CONTAINER_STATUS_EMPTY'),
           ),
           'etpr_container_size' => array(
               self::ETPR_CONTAINER_SIZE_20 => Yii::t('EdifactDataModule.model', 'ETPR_CONTAINER_SIZE_20'),
               self::ETPR_CONTAINER_SIZE_40 => Yii::t('EdifactDataModule.model', 'ETPR_CONTAINER_SIZE_40'),
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

        $criteria->compare('t.etpr_id', $this->etpr_id);
        $criteria->compare('t.etpr_terminal', $this->etpr_terminal, true);
        $criteria->compare('t.etpr_date_from', $this->etpr_date_from, true);
        $criteria->compare('t.etpr_date_to', $this->etpr_date_to, true);
        $criteria->compare('t.etpr_operation', $this->etpr_operation);
        $criteria->compare('t.etpr_container_status', $this->etpr_container_status);
        $criteria->compare('t.etpr_container_size', $this->etpr_container_size);
        $criteria->compare('t.etpr_day_from', $this->etpr_day_from);
        $criteria->compare('t.etpr_day_to', $this->etpr_day_to);
        $criteria->compare('t.etpr_price', $this->etpr_price, true);
        $criteria->compare('t.etpr_imdg_price', $this->etpr_imdg_price, true);
        $criteria->compare('t.etpr_imdg_coefficient', $this->etpr_imdg_coefficient, true);
        $criteria->compare('t.etpr_h68_2020_coefficient', $this->etpr_h68_2020_coefficient, true);
        $criteria->compare('t.etpr_hour_holiday_coefficient', $this->etpr_hour_holiday_coefficient, true);
        $criteria->compare('t.etpr_notes', $this->etpr_notes, true);


        return $criteria;

    }

}
