<?php

// auto-loading
Yii::setPathOfAlias('EcerErrors', dirname(__FILE__));
Yii::import('EcerErrors.*');

class EcerErrors extends BaseEcerErrors
{

    public $ecnt_terminal;
    public $ecnt_move_code;
    public $ecnt_container_nr;
    public $ecnt_datetime;
    public $ecnt_operation;
    public $ecnt_transport_id;
    public $ecnt_length;
    public $ecnt_iso_type;
    
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

    public function getTerminalClass(){
        switch ($this->ecnt_terminal) {
            case 'RIXCT':
                return 'label label-warning';
            case 'RIXBCT':
                return 'label label-important';
                break;

            default:
                return 'label label-inverse';
                break;
        }
    }
    
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),  EcntContainer::model()->attributeLabels());
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
        
        $criteria->select = "
            t.*,
            ec.ecnt_terminal,
            ec.ecnt_move_code,
            ec.ecnt_container_nr,
            ec.ecnt_datetime,
            ec.ecnt_operation,
            ec.ecnt_transport_id,
            ec.ecnt_length,
            ec.ecnt_iso_type
            ";
        $criteria->join = "INNER JOIN ecnt_container ec ON ecer_ecnt_id = ecnt_id";

        
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
        ));
    }
    
    public static function registreError($ecnt_id,$descr){
        
        /**
         * parbauda, vai jau nav pievienota kljuda
         */
        $search_attributes = [
            'ecer_ecnt_id' => $ecnt_id,
            'ecer_descr' => $descr,
        ];
        
        if(EcerErrors::model()->findByAttributes($search_attributes)){
            return false;
        }
        
        $ecer = new EcerErrors();
        $ecer->ecer_ecnt_id = $ecnt_id;
        $ecer->ecer_descr = $descr;
        return $ecer->save();
        
    }
    
    /**
     * mark containers, what no moving more 7 days, except of loading on vessel
     * @return int - marked containers
     */
    public static function mark7DaysNoMoving(){
        
        $sql = "
            SELECT 
              ec1.ecnt_id 
            FROM
              ecnt_container ec1 
              LEFT OUTER JOIN ecnt_container ec2 
                ON ec1.ecnt_container_nr = ec2.ecnt_container_nr 
                AND ec1.ecnt_datetime < ec2.ecnt_datetime 
            WHERE NOT ec1.ecnt_move_code IN ('VF', 'VE') 
              AND ec2.ecnt_id IS NULL 
              AND ec1.ecnt_datetime < ADDDATE(NOW(), - 7)
        ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $count = 0;
        foreach($data as $row){
            if(self::registreError($row['ecnt_id'],'7days')){
                $count ++;
            }
        }

        return $count;
        
    }

}
