<?php

// auto-loading
Yii::setPathOfAlias('EcntContainer', dirname(__FILE__));
Yii::import('EcntContainer.*');

class EcntContainer extends BaseEcntContainer
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
            parent::rules()
        /* , array(
          array('column1, column2', 'rule1'),
          array('column3', 'rule2'),
          ) */
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

    public function beforeSave()
    {
        
        //sameklee procesing record
        if(empty($this->ecnt_ecpr_id) 
                && $this->ecnt_operation != EcntContainer::ECNT_OPERATION_TRUCK_IN 
                && $this->ecnt_operation != EcntContainer::ECNT_OPERATION_VESSEL_DISCHARGE
                )
        {
            $sql = "
                SELECT 
                    ecpr_id 
                FROM
                    ecnt_container 
                    INNER JOIN ecpr_container_procesing 
                      ON ecnt_ecpr_id = ecpr_id 
                      AND ecpr_start_ecnt_id = ecnt_id 
                WHERE ecnt_container_nr = :container
                    AND ecpr_end_ecnt_id IS NULL 
                    AND ecnt_datetime < :datetime
                ";
            
            $rawData = Yii::app()->db->createCommand($sql);
            $container = $this->ecnt_container_nr;
            $datetime = $this->ecnt_datetime;
            $rawData->bindParam(":container", $container, PDO::PARAM_STR);                
            $rawData->bindParam(":datetime", $datetime, PDO::PARAM_STR);                
            $ecpr_id = $rawData->queryScalar();
            if($ecpr_id){
                $this->ecnt_ecpr_id = $ecpr_id;
            }
            
        }
        
        return parent::beforeSave();

    }    
    
    public function recalc()
    {
        //parent::afterSave();
        
        $must_save = false;
        
        //konteiner init record
        if(empty($this->ecnt_ecpr_id) 
                && empty($this->ecprContainerProcesings) 
                && (
                $this->ecnt_operation == EcntContainer::ECNT_OPERATION_TRUCK_IN 
                || $this->ecnt_operation == EcntContainer::ECNT_OPERATION_VESSEL_DISCHARGE
                )
                ){
            
            $ecpr = new EcprContainerProcesing();
            $ecpr->ecpr_start_ecnt_id = $this->ecnt_id;
            $ecpr->save();
            $this->ecnt_ecpr_id = $ecpr->ecpr_id;
            $must_save = true;
        }

        $action_amt = EtprTerminalPrices::calcActionAmt($this->ecnt_id);        
        if($action_amt['amt'] != $this->ecnt_action_amt){
            $this->ecnt_action_amt = $action_amt['amt'];
            $this->ecnt_action_calc_notes = $action_amt['amt_formul'];
            $must_save = true;
        }

        $time_amt = EtprTerminalPrices::calcTimeAmt($this);        
        if($time_amt['amt'] != $this->ecnt_time_amt){
            $this->ecnt_time_amt = $time_amt['amt'];
            $this->ecnt_time_calc_notes = $time_amt['amt_formul'];
            $must_save = true;
        }
        
        if($must_save){
            $this->save();
        }
        
        //konteinera final record
        if ($this->ecnt_operation == EcntContainer::ECNT_OPERATION_TRUCK_OUT 
                || $this->ecnt_operation == EcntContainer::ECNT_OPERATION_VESSEL_LOAD
        ) {
            if (!empty($this->ecnt_ecpr_id)) {
                $ecpr = $this->ecntEcpr;

                if (!empty($ecpr) && $ecpr->ecprStartEcnt->ecnt_datetime < $this->ecnt_datetime
                ) {
                    $ecpr->ecpr_end_ecnt_id = $this->ecnt_id;
                    $ecpr->save();
                }
            }
            
        }    
        

        
    }
    
}
