<?php

// auto-loading
Yii::setPathOfAlias('EtprTerminalPrices', dirname(__FILE__));
Yii::import('EtprTerminalPrices.*');

class EtprTerminalPrices extends BaseEtprTerminalPrices
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
    
    public static function calcTimeAmt($ecnt){
        
        if(empty($ecnt->ecnt_ecpr_id)){
            return array(
                'amt' => 0,
                'amt_formul' => 'Nav identificets process',
            );            
        }
        
        $sql ="
            SELECT 
                DATEDIFF(DATE('".$ecnt->ecnt_datetime."'),DATE(ecnt_datetime)) + 1 days
            FROM
                ecnt_container 
            WHERE 
                ecnt_ecpr_id = ".$ecnt->ecnt_ecpr_id." 
                AND ecnt_datetime < '".$ecnt->ecnt_datetime."'
            ORDER BY 
                ecnt_datetime DESC
            LIMIT 1
        ";
        $days = Yii::app()->db->createCommand($sql)->queryScalar();
        if(!$days){
            return array(
                'amt' => 0,
                'amt_formul' => 'Neatrada',
            );
        }

        $sql = "
            SELECT 
              SUM(ROUND(etpr_price *
              CASE 
                WHEN etpr_day_to <= :days 
                    THEN etpr_day_to	
                WHEN etpr_day_from <= :days AND  etpr_day_to >= :days 
                    THEN :days - etpr_day_from + 1
                    ELSE 0
              END,2)) amt,
              GROUP_CONCAT(	
                  CASE 
                    WHEN etpr_day_to <= :days 
                        THEN CONCAT(etpr_day_to,'(days) x ',etpr_price,' EUR')	
                    WHEN etpr_day_from <= :days AND  etpr_day_to >= :days 
                        THEN  CONCAT(:days - etpr_day_from + 1,'(days) x ',etpr_price,' EUR')
                        ELSE '0'
                  END 
                  SEPARATOR  '+'
              ) amt_formul

            FROM
              ecnt_container 
              INNER JOIN etpr_terminal_prices 
                ON etpr_terminal = ecnt_terminal 
                AND etpr_date_from <= ecnt_datetime 
                AND ADDDATE(etpr_date_to, 1) > ecnt_datetime 
                AND etpr_container_status = ecnt_statuss 
                AND etpr_container_size = ecnt_length 
            WHERE etpr_operation = 'STORAGE' 
              AND ecnt_id = ".$ecnt->ecnt_id." 
        ";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":days", $days, PDO::PARAM_INT); 
        
        return $rawData->queryRow();        
        
    }
    
    public static function calcActionAmt($ecnt_id){
        
        $sql = "
              SELECT 
                etpr_price,
                ROUND(etpr_price * etpr_imdg_coefficient,2) imdg_price,
                ROUND(etpr_price * etpr_h68_2020_coefficient,2) h68_2020_price,
                ROUND(etpr_price * etpr_hour_holiday_coefficient,2) holiday_price,
                ecnt_datetime,
                etpr_operation
              FROM
                ecnt_container 
                INNER JOIN etpr_terminal_prices 
                  ON etpr_terminal = ecnt_terminal 
                  AND etpr_date_from <= ecnt_datetime 
                  AND ADDDATE(etpr_date_to, 1) > ecnt_datetime 
                  AND (
                    CASE
                      ecnt_operation 
                      WHEN 'TRUCK_IN' 
                      THEN 'LOADING' 
                      WHEN 'TRUCK_OUT' 
                      THEN 'LOADING' 
                    END = etpr_operation 
                    OR 
                    CASE
                      ecnt_operation 
                      WHEN 'TRUCK_IN' 
                      THEN 'LOADING_TRUCK' 
                      WHEN 'TRUCK_OUT' 
                      THEN 'LOADING_TRUCK' 
                    END = etpr_operation
                  ) 
                  AND etpr_container_status = ecnt_statuss 
                  AND etpr_container_size = ecnt_length 
              WHERE ecnt_id = :ecnt_id
";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":ecnt_id", $ecnt_id, PDO::PARAM_INT);                

        $data = $rawData->queryRow();

        if(!$data){
            return array(
                'amt' => 0,
                'amt_formul' => 'Error:Neatrada cenu',
            );
        }

        if(self::isHollidayHour($data['ecnt_datetime'])){
            return array(
                'amt' => $data['holiday_price'],
                'amt_formul' => $data['etpr_operation']. ' - Holliday',
            );            
        }
        
        if(self::isExtraHour($data['ecnt_datetime'])){
            return array(
                'amt' => $data['h68_2020_price'],
                'amt_formul' => $data['etpr_operation']. ' - Extra Hour',
            );            
            
        }

        return array(
                'amt' => $data['etpr_price'],
                'amt_formul' => $data['etpr_operation']. ' - Regular',
            );  
        
    }

    public static function isExtraHour($datetime){
        $dt = DateTime::CreateFromFormat("Y-m-d H:i:s", $datetime);
        $hour = $dt->format('H'); // '07'
        
        switch ((int)$hour) {
            case 6:
            case 7:
            case 20:
            case 21:
                return true;
                break;

            default:
                return false;
                break;
        }
        
    }

    public static function isHollidayHour($datetime){
        
        //validate, if calendar fully loadded
        $sql = "
            SELECT 
                cled_id
            FROM
              cled_calendar_exception_dates 
            WHERE cled_date = DATE(:dt) 
                OR  cled_date = ADDDATE(DATE(:dt), 1) 
                OR  cled_date = ADDDATE(DATE(:dt), -1)
        ";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":dt", $datetime, PDO::PARAM_STR);                
        $cled_data = $rawData->queryAll();
        
        //aizpildam esosho un nakamo gadu, ja nav 3 ierakstu
        if(count($cled_data) < 3){
            $cled = new CledCalendarExceptionDates();
            $cled->fillYear(date('Y'));
            $cled->fillYear(date('Y')+1);
        }
        
        /**
         * peec kalendara paskatās:
         *  - vai svētdiena un brīvdiens
         *  - ir svetkudiena
         *  - pirms no 23:00
         *  - pēc līdz 6:00
         */
        $sql = "
            SELECT MAX(
              CASE
                WHEN cled_type = 'Holliday' 
                AND WEEKDAY(cled_date) = 6 
                THEN 1 
                WHEN cled_type = 'Public Holliday' 
                THEN 1 
                ELSE 0 
              END) is_extra_date 
            FROM
              cled_calendar_exception_dates 
            WHERE cled_date = DATE(:dt) 
              OR cled_date = DATE(ADDDATE(:dt, INTERVAL 1 HOUR)) 
              OR cled_date = DATE(ADDDATE(:dt, INTERVAL - 6*60*60 - 1 SECOND))
        ";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":dt", $datetime, PDO::PARAM_STR);                

        return ($rawData->queryScalar() == 1);
        
    }
    
}
