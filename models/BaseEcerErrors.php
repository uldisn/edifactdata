<?php

/**
 * This is the model base class for the table "ecer_errors".
 *
 * Columns in table "ecer_errors" available as properties of the model:
 * @property string $ecer_id
 * @property string $ecer_ecnt_id
 * @property string $ecer_descr
 * @property string $ecer_notes
 * @property string $ecer_status
 *
 * Relations of table "ecer_errors" available as properties of the model:
 * @property EcntContainer $ecerEcnt
 */
abstract class BaseEcerErrors extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const ECER_STATUS_NEW = 'NEW';
    const ECER_STATUS_CLOSED = 'CLOSED';
    
    var $enum_labels = false;  

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ecer_errors';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('ecer_ecnt_id, ecer_descr', 'required'),
                array('ecer_notes, ecer_status', 'default', 'setOnEmpty' => true, 'value' => null),
                array('ecer_ecnt_id', 'length', 'max' => 10),
                array('ecer_notes', 'safe'),
                array('ecer_status', 'in', 'range' => array(self::ECER_STATUS_NEW, self::ECER_STATUS_CLOSED)),
                array('ecer_id, ecer_ecnt_id, ecer_descr, ecer_notes, ecer_status', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->ecer_ecnt_id;
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
                'ecerEcnt' => array(self::BELONGS_TO, 'EcntContainer', 'ecer_ecnt_id'),
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'ecer_id' => Yii::t('EdifactDataModule.model', 'Ecer'),
            'ecer_ecnt_id' => Yii::t('EdifactDataModule.model', 'Ecer Ecnt'),
            'ecer_descr' => Yii::t('EdifactDataModule.model', 'Ecer Descr'),
            'ecer_notes' => Yii::t('EdifactDataModule.model', 'Ecer Notes'),
            'ecer_status' => Yii::t('EdifactDataModule.model', 'Ecer Status'),
        );
    }

    public function enumLabels()
    {
        if($this->enum_labels){
            return $this->enum_labels;
        }    
        $this->enum_labels =  array(
           'ecer_status' => array(
               self::ECER_STATUS_NEW => Yii::t('EdifactDataModule.model', 'ECER_STATUS_NEW'),
               self::ECER_STATUS_CLOSED => Yii::t('EdifactDataModule.model', 'ECER_STATUS_CLOSED'),
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

        $criteria->compare('t.ecer_id', $this->ecer_id, true);
        $criteria->compare('t.ecer_ecnt_id', $this->ecer_ecnt_id);
        $criteria->compare('t.ecer_descr', $this->ecer_descr, true);
        $criteria->compare('t.ecer_notes', $this->ecer_notes, true);
        $criteria->compare('t.ecer_status', $this->ecer_status);


        return $criteria;

    }

}
