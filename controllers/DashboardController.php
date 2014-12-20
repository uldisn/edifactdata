<?php

class DashboardController extends Controller {

    public $defaultAction = "default";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "dashboard/default";

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('default'),
                'roles' => array('Dashboard.*'),
            ),
        );
    }

    public function actionDefault() {
        
        $criteria_ecer_error = new CDbCriteria;
        $criteria_ecer_error->compare('t.ecer_status',  EcerErrors::ECER_STATUS_NEW);
        $criteria_ecer_error->addCondition("ecer_descr != '7days'");

        $criteria_ecer_7days = new CDbCriteria;
        $criteria_ecer_7days->compare('t.ecer_status',  EcerErrors::ECER_STATUS_NEW);        
        $criteria_ecer_7days->addCondition("ecer_descr = '7days'");
        
        $this->render('default', array(
            'criteria_ecer_error' => $criteria_ecer_error,
            'criteria_ecer_7days' => $criteria_ecer_7days,
            ));
    }

}
