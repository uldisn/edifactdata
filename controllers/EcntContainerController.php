<?php


class EcntContainerController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
   public $menu_route = "edifactdata/ecntContainer";  


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
            'roles' => array('Edifactdata.EcntContainer.*'),
        ),
        array(
            'allow',
            'actions' => array('create','ajaxCreate'),
            'roles' => array('Edifactdata.EcntContainer.Create'),
        ),
        array(
            'allow',
            'actions' => array('view', 'admin'), // let the user view the grid
            'roles' => array('Edifactdata.EcntContainer.View'),
        ),
        array(
            'allow',
            'actions' => array('update', 'editableSaver'),
            'roles' => array('Edifactdata.EcntContainer.Update'),
        ),
        array(
            'allow',
            'actions' => array('delete'),
            'roles' => array('Edifactdata.EcntContainer.Delete'),
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

    public function actionView($ecnt_id, $ajax = false)
    {
        $model = $this->loadModel($ecnt_id);
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
        $model = new EcntContainer;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'ecnt-container-form');

        if (isset($_POST['EcntContainer'])) {
            $model->attributes = $_POST['EcntContainer'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'ecnt_id' => $model->ecnt_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('ecnt_id', $e->getMessage());
            }
        } elseif (isset($_GET['EcntContainer'])) {
            $model->attributes = $_GET['EcntContainer'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($ecnt_id)
    {
        $model = $this->loadModel($ecnt_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'ecnt-container-form');

        if (isset($_POST['EcntContainer'])) {
            $model->attributes = $_POST['EcntContainer'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'ecnt_id' => $model->ecnt_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('ecnt_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('EcntContainer'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new EcntContainer;
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
    
    public function actionDelete($ecnt_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($ecnt_id)->delete();
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
        $model = new EcntContainer('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['EcntContainer'])) {
            $model->attributes = $_GET['EcntContainer'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id)
    {
        $m = EcntContainer::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ecnt-container-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
