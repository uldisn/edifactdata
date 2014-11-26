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
            'sort'=>array(
                'defaultOrder'=>'ecnt_datetime',
                ),

            
        ));
    }

    public function beforeSave()
    {
        
        //nosaka garumu
        if(!empty($this->ecnt_iso_type)){
            switch (substr($this->ecnt_iso_type,0,1)) {
                case '2':
                    $this->ecnt_length = EcntContainer::ECNT_LENGTH_20;
                    break;
                case '4':
                    $this->ecnt_length = EcntContainer::ECNT_LENGTH_40;
                    break;
                default:
                    $error[] = 'Nekorekts ISO TYPR:'.  $this->ecnt_iso_type;
                    break;
            }
        } 
        
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
    
    static function getContainerActionAmtTotal($ecpr_id){
        $sql = "
            SELECT 
                SUM(ecnt_action_amt) action_amt 
            FROM
                ecnt_container 
            WHERE ecnt_ecpr_id = :ecpr_id 
            ";
        
        $rawData = Yii::app()->db->createCommand($sql);
             
        $rawData->bindParam(":ecpr_id", $ecpr_id, PDO::PARAM_INT);      
        return $rawData->queryScalar();
    }    
    
    static function getContainerTimeAmtTotal($ecpr_id){
        $sql = "
            SELECT 
                SUM(ecnt_time_amt) action_amt 
            FROM
                ecnt_container 
            WHERE ecnt_ecpr_id = :ecpr_id 
            ";
        
        $rawData = Yii::app()->db->createCommand($sql);
             
        $rawData->bindParam(":ecpr_id", $ecpr_id, PDO::PARAM_INT);      
        return $rawData->queryScalar();
    }    
    
    static public function saveEdiData($ecnt_data,$EdiReader,$error,$edifact){
        $error = array_merge($error,$EdiReader->errors());

        $edifact->bgm_1_id = $EdiReader->readEdiDataValueReq('BGM', 1);
        
        $edifact->error = '';
        if(!empty($error)){
            $edifact->error = implode(PHP_EOL,$error);
            $edifact->status = Edifact::STATUS_ERROR;
            $edifact->save();
            return false;
        }        
        
        //create model
        $find_attributes = array(
            'ecnt_edifact_id' => $edifact->id,
            'ecnt_container_nr' => $ecnt_data['ecnt_container_nr'],
        );
        $ecnt = EcntContainer::model()->findByAttributes($find_attributes);
        if(!$ecnt){
            $ecnt_data['ecnt_edifact_id'] = $edifact->id;
            $ecnt = new EcntContainer();
        }  
       $ecnt->attributes = $ecnt_data;
       
        if(!$ecnt->save()){
            $edifact->error = print_r($ecnt->errors,true);
            $edifact->status = Edifact::STATUS_ERROR;
            $edifact->save();            
            return false;
        }    
        $ecnt->recalc();
        
        $edifact->error = '';
        $edifact->status = Edifact::STATUS_PROCESSED;
        $edifact->save();
        
        return true;
        
        
    }
    
}
