<?php

/**
 * Dimension tipa atskaite par iepildīšanām
 * @todo jāpāriet uz ajaxu
 */
class ReportController extends Controller {
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "person_atv/report";

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array(
                    'Day',
                ),
                'roles' => array('Gramatvedis', 'NodPrieksnieks',),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionDay() {
        
        $this->menu_route = "edifactdata/Report/Day";        

        $report_date = Yii::app()->request->getPost('report_date');
        $excel = Yii::app()->request->getPost('excel');
        
        if (!$report_date) {
            $report_date = date('Y.m.d');
        }

        $data = EcntContainer::reportDay($report_date);        
                
        if(empty($excel)){
            $this->render(
                    'day', array(
                        'report_date' => $report_date,
                        'data' => $data,
                            )
            );
        }else{
            $this->render(
                    'day_xls', array(
                        'report_date' => $report_date,
                        'data' => $data,
                            )
            );            
        }
    }

    public function actionTabeleMenesis($year = false, $month = false) {
        
        $this->menu_route = "person_atv/report/tabeleMenesis";

        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }

        $data = PadrDienuRegistrs::reportTabeleMenesis($year, $month);

        $this->render(
                'tabele_menesis', array(
            'year' => $year,
            'month' => $month,
            'data' => $data,
                )
        );
    }

    public function actionTabeleGadsPaNed($year = false) {
        
        $this->menu_route = "person_atv/Report/tabeleGadsPaNed";

        if (!$year) {
            $year = date('Y');
        }

        $data = PadrDienuRegistrs::reportTabeleGadsPaNed($year);

        $this->render(
                'tabele_gads_pa_ned', array(
            'year' => $year,
            'data' => $data,
                )
        );
    }
    
}
