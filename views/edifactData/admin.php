<?php
$this->setPageTitle(
    Yii::t('EdifactDataModule.model', 'Edifact Datas')
    . ' - '
    . Yii::t('EdifactDataModule.crud', 'Manage')
);

$this->breadcrumbs[] = Yii::t('EdifactDataModule.model', 'Edifact Datas');

?>

<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('EdifactDataModule.crud','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             'visible'=>(Yii::app()->user->checkAccess('Edifactdata.EdifactData.*') || Yii::app()->user->checkAccess('Edifactdata.EdifactData.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Edifact Datas');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('EdifactData.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'edifact-data-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                'class' => 'CLinkColumn',
                'header' => '',
                'labelExpression' => '$data->itemLabel',
                'urlExpression' => 'Yii::app()->controller->createUrl("view", array("id" => $data["id"]))'
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'id',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'edifact_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    'source' => CHtml::listData(Edifact::model()->findAll(array('limit' => 1000)), 'id', 'itemLabel'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'messageType',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                //char(10)
                'class' => 'editable.EditableColumn',
                'name' => 'interchangeSender',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'dateTimePreparation',
                'editable' => array(
                    'type' => 'datetime',
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(100)
                'class' => 'editable.EditableColumn',
                'name' => 'messageReferenceNumber',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(100)
                'class' => 'editable.EditableColumn',
                'name' => 'conveyanceReferenceNumber',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(100)
                'class' => 'editable.EditableColumn',
                'name' => 'idOfTheMeansOfTransportVessel',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            /*
            array(
                //char(10)
                'class' => 'editable.EditableColumn',
                'name' => 'portOfDischarge',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'arrivalDateTimeEstimated',
                'editable' => array(
                    'type' => 'datetime',
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'arrivalDateTimeActual',
                'editable' => array(
                    'type' => 'datetime',
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'departureDateTimeEstimated',
                'editable' => array(
                    'type' => 'datetime',
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //char(10)
                'class' => 'editable.EditableColumn',
                'name' => 'carrier',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //char(20)
                'class' => 'editable.EditableColumn',
                'name' => 'equipmentIdentification',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(100)
                'class' => 'editable.EditableColumn',
                'name' => 'BookingreferenceNumber',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(100)
                'class' => 'editable.EditableColumn',
                'name' => 'RealiseReferenceNumber',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'PositioningDatetimeOfEquipment',
                'editable' => array(
                    'type' => 'datetime',
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //char(10)
                'class' => 'editable.EditableColumn',
                'name' => 'ActivityLocation',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //char(20)
                'class' => 'editable.EditableColumn',
                'name' => 'ActivityLocationRelatedPlace',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(20)
                'class' => 'editable.EditableColumn',
                'name' => 'GrossWeight',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(20)
                'class' => 'editable.EditableColumn',
                'name' => 'TareWeight',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //char(10)
                'class' => 'editable.EditableColumn',
                'name' => 'CarRegNumber',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            */

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EdifactData.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EdifactData.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
                'deleteConfirmation'=>Yii::t('EdifactDataModule.crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('EdifactData.view.grid'); ?>