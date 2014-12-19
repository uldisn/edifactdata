<?php


class EcerErrorsController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "edifactdata/ecerErrors";  


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
            'roles' => array('Edifactdata.EcerErrors.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Edifactdata.EcerErrors.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Edifactdata.EcerErrors.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Edifactdata.EcerErrors.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Edifactdata.EcerErrors.Delete'),
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

    public function actionView($ecer_id, $ajax = false)
    {
        $model = $this->loadModel($ecer_id);
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
        $model = new EcerErrors;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'ecer-errors-form');

        if (isset($_POST['EcerErrors'])) {
            $model->attributes = $_POST['EcerErrors'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'ecer_id' => $model->ecer_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('ecer_id', $e->getMessage());
            }
        } elseif (isset($_GET['EcerErrors'])) {
            $model->attributes = $_GET['EcerErrors'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($ecer_id)
    {
        $model = $this->loadModel($ecer_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'ecer-errors-form');

        if (isset($_POST['EcerErrors'])) {
            $model->attributes = $_POST['EcerErrors'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'ecer_id' => $model->ecer_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('ecer_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('EcerErrors'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new EcerErrors;
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
    
    public function actionDelete($ecer_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($ecer_id)->delete();
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
        Yii::import("vendor.pentium10.yii-clear-filters-gridview.components.*");
        $model = new EcerErrors('search');
        if (intval(Yii::app()->request->getParam('clearFilters'))==1) {
            EButtonColumnWithClearFilters::clearFilters($this,$model);//where $this is the controller
        }    
        
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['EcerErrors'])) {
            $model->attributes = $_GET['EcerErrors'];
            $this->renderPartial('admin', array('model' => $model));
        }else{
            $this->render('admin', array('model' => $model));
        }    
    }

    public function loadModel($id)
    {
        $m = EcerErrors::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ecer-errors-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
