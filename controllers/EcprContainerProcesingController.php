<?php


class EcprContainerProcesingController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "edifactdata/ecprContainerProcesing";      


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
            'roles' => array('Edifactdata.EcprContainerProcesing.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Edifactdata.EcprContainerProcesing.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Edifactdata.EcprContainerProcesing.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Edifactdata.EcprContainerProcesing.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Edifactdata.EcprContainerProcesing.Delete'),
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

    public function actionView($ecpr_id, $ajax = false)
    {
        $model = $this->loadModel($ecpr_id);
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
        $model = new EcprContainerProcesing;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'ecpr-container-procesing-form');

        if (isset($_POST['EcprContainerProcesing'])) {
            $model->attributes = $_POST['EcprContainerProcesing'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'ecpr_id' => $model->ecpr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('ecpr_id', $e->getMessage());
            }
        } elseif (isset($_GET['EcprContainerProcesing'])) {
            $model->attributes = $_GET['EcprContainerProcesing'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($ecpr_id)
    {
        $model = $this->loadModel($ecpr_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'ecpr-container-procesing-form');

        if (isset($_POST['EcprContainerProcesing'])) {
            $model->attributes = $_POST['EcprContainerProcesing'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'ecpr_id' => $model->ecpr_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('ecpr_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('EcprContainerProcesing'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new EcprContainerProcesing;
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
    
    public function actionDelete($ecpr_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($ecpr_id)->delete();
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
            throw new CHttpException(400, Yii::t('`crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin()
    {
        $model = new EcprContainerProcesing('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['EcprContainerProcesing'])) {
            $model->attributes = $_GET['EcprContainerProcesing'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id)
    {
        $m = EcprContainerProcesing::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('`crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ecpr-container-procesing-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
