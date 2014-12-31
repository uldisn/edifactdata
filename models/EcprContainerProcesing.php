<?php

// auto-loading
Yii::setPathOfAlias('EcprContainerProcesing', dirname(__FILE__));
Yii::import('EcprContainerProcesing.*');

class EcprContainerProcesing extends BaseEcprContainerProcesing
{
    
    public $ecnt_terminal;
    public $ecnt_container_nr;
    public $ecnt_datetime;
    public $ecnt_statuss;
    public $ecnt_length;
    public $action_amt;
    public $time_amt;
            

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
            parent::rules()
         , array(
                array('ecnt_terminal, ecnt_container_nr, ecnt_datetime,ecnt_statuss,ecnt_length,action_amt,time_amt', 'safe', 'on' => 'search'),
             ) 
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
    
    public function searchExt()
    {
        //$this->ccuc_status = self::CCUC_STATUS_PERSON;
        
        $criteria = new CDbCriteria;        
        $criteria->select = '
                t.*,
                ec_main.ecnt_terminal ,
                ec_main.ecnt_container_nr,
                ec_main.ecnt_datetime,
                ec_main.ecnt_statuss,
                ec_main.ecnt_length,
                sum(ec_amt.ecnt_action_amt) action_amt,
                sum(ec_amt.ecnt_time_amt) time_amt
                ';
        
        $criteria->join  = " 
                INNER JOIN ecnt_container ec_main
                    ON ecpr_start_ecnt_id = ec_main.ecnt_id 
                INNER JOIN ecnt_container ec_amt
                    ON ecpr_id = ec_amt.ecnt_ecpr_id 
            ";
        $criteria->group = 'ecpr_id  
                            ,ec_main.ecnt_terminal
                            ,ec_main.ecnt_container_nr
                            ,ec_main.ecnt_datetime
                            ,ec_main.ecnt_statuss
                            ,ec_main.ecnt_length                            
                        ';
        $criteria->compare('ec_main.ecnt_terminal',  $this->ecnt_terminal);
        $criteria->compare('ec_main.ecnt_container_nr',  $this->ecnt_container_nr,true);
        $criteria->compare('ec_main.ecnt_datetime',$this->ecnt_datetime,true);
        $criteria->compare('ec_main.ecnt_statuss',$this->ecnt_statuss);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }    
    
    

}
