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

                'name' => 'messageType',
            ),
            array(
                'name' => 'interchangeSender',
            ),
            array(
                'name' => 'dateTimePreparation',
            ),
            array(
                //varchar(100)
                'name' => 'messageReferenceNumber',
            ),
            array(
                //varchar(100)
                'name' => 'conveyanceReferenceNumber',
            ),
            array(
                //varchar(100)
                'name' => 'idOfTheMeansOfTransportVessel',
            ),

            array(
                //char(10)
                'name' => 'portOfDischarge',
            ),
            array(

                'name' => 'arrivalDateTimeEstimated',
            ),
            array(
                'name' => 'arrivalDateTimeActual',
            ),
            array(
                'name' => 'departureDateTimeEstimated',
            ),
            array(
                //char(10)
                'name' => 'carrier',
            ),
            array(
                //char(20)
                'name' => 'equipmentIdentification',
            ),
            array(
                //varchar(100)
                'name' => 'BookingreferenceNumber',
            ),
            array(
                //varchar(100)
                'name' => 'RealiseReferenceNumber',
            ),
            array(
                'name' => 'PositioningDatetimeOfEquipment',
            ),
            array(
                //char(10)
                'name' => 'ActivityLocation',
            ),
            array(
                //char(20)
                'name' => 'ActivityLocationRelatedPlace',
            ),
            array(
                //varchar(20)
                'name' => 'GrossWeight',
            ),
            array(
                //varchar(20)
                'name' => 'TareWeight',
            ),
            array(
                //char(10)
                'name' => 'CarRegNumber',
            ),
            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EdifactData.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'FALSE'),
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