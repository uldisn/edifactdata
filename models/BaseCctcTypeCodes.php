<?php



/**
 * This is the model base class for the table "cctc_type_codes".
 *

 */
abstract class BaseCctcTypeCodes extends CActiveRecord
{
  
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'cctc_type_codes';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('cctc_code', 'required'),
                array('cctc_description, cctc_css_class', 'default', 'setOnEmpty' => true, 'value' => null),
                array('cctc_code', 'length', 'max' => 4),
                array('cctc_code, cctc_desctiption, cctc_css_class', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->cctc_code;
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
               
                'ecntContainer' => array(self::HAS_MANY, 'EcntContainer', 'cctc_code'),
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




