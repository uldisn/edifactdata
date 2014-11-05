<?php


class EtprTerminalPricesController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "edifactdata/etprTerminalPrices";  

public function filters()
{
    return array(
        'accessControl',
    );
}

public function accessRules()
{
     return array(
        array(
            'allow',
            'actions' => array('create', 'admin', 'view', 'update', 'editableSaver', 'delete','ajaxCreate'),
            'roles' => array('Edifactdata.EtprTerminalPrices.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Edifactdata.EtprTerminalPrices.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Edifactdata.EtprTerminalPrices.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Edifactdata.EtprTerminalPrices.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Edifactdata.EtprTerminalPrices.Delete'),
        ),
        array(
            'deny',
            'users' => array('*'),
        ),
    );
}

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = array('/' . $this->module->Id);
        }
        return true;
    }

    public function actionView($etpr_id, $ajax = false)
    {
        $model = $this->loadModel($etpr_id);
        if($ajax){
            $this->renderPartial('_view-relations_grids', 
                    array(
                        'modelMain' => $model,
                        'ajax' => $ajax,
                        )
                    );
        }else{
            $this->render('view', array('model' => $model,));
        }
    }

    public function actionCreate()
    {
        $model = new EtprTerminalPrices;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'etpr-terminal-prices-form');

        if (isset($_POST['EtprTerminalPrices'])) {
            $model->attributes = $_POST['EtprTerminalPrices'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'etpr_id' => $model->etpr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('etpr_id', $e->getMessage());
            }
        } elseif (isset($_GET['EtprTerminalPrices'])) {
            $model->attributes = $_GET['EtprTerminalPrices'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($etpr_id)
    {
        $model = $this->loadModel($etpr_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'etpr-terminal-prices-form');

        if (isset($_POST['EtprTerminalPrices'])) {
            $model->attributes = $_POST['EtprTerminalPrices'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'etpr_id' => $model->etpr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('etpr_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('EtprTerminalPrices'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new EtprTerminalPrices;
        $model->$field = $value;
        try {
            if ($model->save()) {
                return TRUE;
            }else{
                return var_export($model->getErrors());
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }
    
    public function actionDelete($etpr_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($etpr_id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(array('admin'));
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('EdifactDataModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin()
    {
        $model = new EtprTerminalPrices('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['EtprTerminalPrices'])) {
            $model->attributes = $_GET['EtprTerminalPrices'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id)
    {
        $m = EtprTerminalPrices::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('EdifactDataModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'etpr-terminal-prices-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
