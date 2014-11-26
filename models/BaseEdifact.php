<?php

/**
 * This is the model base class for the table "edifact".
 *
 * Columns in table "edifact" available as properties of the model:
 * @property string $id
 * @property string $terminal
 * @property string $prep_datetime
 * @property string $message_ref_number
 * @property string $filename
 * @property string $message
 * @property string $create_datetime
 * @property string $status
 * @property string $error
 * @property integer $bgm_1_id
 *
 * Relations of table "edifact" available as properties of the model:
 * @property EcntContainer[] $ecntContainers
 * @property EdifactData[] $edifactDatas
 */
abstract class BaseEdifact extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const STATUS_PROCESSED = 'PROCESSED';
    const STATUS_NEW = 'NEW';
    const STATUS_ERROR = 'ERROR';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'edifact';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('create_datetime', 'required'),
                array('terminal, prep_datetime, message_ref_number, filename, message, status, error, bgm_1_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('bgm_1_id', 'numerical', 'integerOnly' => true),
                array('terminal', 'length', 'max' => 10),
                array('message_ref_number, filename', 'length', 'max' => 20),
                array('prep_datetime, message, error', 'safe'),
                array('status', 'in', 'range' => array(self::STATUS_PROCESSED, self::STATUS_NEW, self::STATUS_ERROR)),
                array('id, terminal, prep_datetime, message_ref_number, filename, message, create_datetime, status, error, bgm_1_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->terminal;
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
                'ecntContainers' => array(self::HAS_MANY, 'EcntContainer', 'ecnt_edifact_id'),
                'edifactDatas' => array(self::HAS_MANY, 'EdifactData', 'edifact_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('EdifactDataModule.model', 'ID'),
            'terminal' => Yii::t('EdifactDataModule.model', 'Terminal'),
            'prep_datetime' => Yii::t('EdifactDataModule.model', 'Prep Datetime'),
            'message_ref_number' => Yii::t('EdifactDataModule.model', 'Message Ref Number'),
            'filename' => Yii::t('EdifactDataModule.model', 'Filename'),
            'message' => Yii::t('EdifactDataModule.model', 'Message'),
            'create_datetime' => Yii::t('EdifactDataModule.model', 'Create Datetime'),
            'status' => Yii::t('EdifactDataModule.model', 'Status'),
            'error' => Yii::t('EdifactDataModule.model', 'Error'),
            'bgm_1_id' => Yii::t('EdifactDataModule.model', 'Bgm 1'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'status' => array(
               self::STATUS_PROCESSED => Yii::t('EdifactDataModule.model', 'STATUS_PROCESSED'),
               self::STATUS_NEW => Yii::t('EdifactDataModule.model', 'STATUS_NEW'),
               self::STATUS_ERROR => Yii::t('EdifactDataModule.model', 'STATUS_ERROR'),
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

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.terminal', $this->terminal, true);
        $criteria->compare('t.prep_datetime', $this->prep_datetime, true);
        $criteria->compare('t.message_ref_number', $this->message_ref_number, true);
        $criteria->compare('t.filename', $this->filename, true);
        $criteria->compare('t.message', $this->message, true);
        $criteria->compare('t.create_datetime', $this->create_datetime, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.error', $this->error, true);
        $criteria->compare('t.bgm_1_id', $this->bgm_1_id);


        return $criteria;

    }

}
