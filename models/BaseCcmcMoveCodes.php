<?php



/**
 * This is the model base class for the table "ccmc_move_codes".
 *

 */
abstract class BaseCcmcMoveCodes extends CActiveRecord
{
  
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ccmc_move_codes';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('ccmc_code', 'required'),
                array('ccmc_short, ccmc_long, ccmc_css_class', 'default', 'setOnEmpty' => true, 'value' => null),
                array('ccmc_code', 'length', 'max' => 2),
                array('ccmc_code, ccmc_short, ccmc_long, ccmc_css_class', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->ccmc_code;
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
               
                'ecntContainer' => array(self::HAS_MANY, 'EcntContainer', 'ccmc_code'),
            )
        );
       
    }

    public function attributeLabels()
    {
        return array(
            'ccmc_code' => Yii::t('EdifactDataModule.model', 'Code'),
            
        );
    }

   

   

    


}


