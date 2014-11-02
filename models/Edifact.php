<?php

// auto-loading
Yii::setPathOfAlias('Edifact', dirname(__FILE__));
Yii::import('Edifact.*');

class Edifact extends BaseEdifact
{

    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
        return parent::getItemLabel();
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            array()
        );
    }

    public function rules()
    {
        return array_merge(
            
          array(
            array('create_datetime','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
            array('message_ref_number', 'unique', 'criteria'=>array(
                'condition'=>'`terminal`=:terminal',
                'params'=>array(':terminal'=>$this->terminal)
                )
                ),              
          
          ),parent::rules() 
        );
    }

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
}
