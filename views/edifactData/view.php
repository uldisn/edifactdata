<?php
    $this->setPageTitle(
        Yii::t('EdifactDataModule.model', 'Edifact Data')
        . ' - '
        . Yii::t('EdifactDataModule.crud', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
$this->breadcrumbs[Yii::t('EdifactDataModule.model','Edifact Datas')] = array('admin');
$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id' => $model->{$model->tableSchema->primaryKey});
$this->breadcrumbs[] = Yii::t('EdifactDataModule.crud', 'View');
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("EdifactDataModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("Edifactdata.EdifactData.*") || Yii::app()->user->checkAccess("Edifactdata.EdifactData.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("EdifactDataModule.crud","Back"),
                )
 ),true);
    
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model','Edifact Data');?>                <small><?php echo$model->itemLabel?></small>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("EdifactDataModule.crud","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("EdifactDataModule.crud","Do you want to delete this item?")
                ),
                "visible"=> (Yii::app()->request->getParam("id")) && (Yii::app()->user->checkAccess("Edifactdata.EdifactData.*") || Yii::app()->user->checkAccess("Edifactdata.EdifactData.Delete"))
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span12">
        <h2>
            <?php echo Yii::t('EdifactDataModule.crud','Data')?>            <small>
                #<?php echo $model->id ?>            </small>
        </h2>

        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                
                array(
                    'name' => 'id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'id',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'edifact_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                            'source' => CHtml::listData(Edifact::model()->findAll(array('limit' => 1000)), 'id', 'itemLabel'),
                            'attribute' => 'edifact_id',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'messageType',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'messageType',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'interchangeSender',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'interchangeSender',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'dateTimePreparation',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                            'attribute' => 'dateTimePreparation',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'messageReferenceNumber',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'messageReferenceNumber',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'conveyanceReferenceNumber',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'conveyanceReferenceNumber',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'idOfTheMeansOfTransportVessel',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'idOfTheMeansOfTransportVessel',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'portOfDischarge',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'portOfDischarge',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'arrivalDateTimeEstimated',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                            'attribute' => 'arrivalDateTimeEstimated',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'arrivalDateTimeActual',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                            'attribute' => 'arrivalDateTimeActual',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'departureDateTimeEstimated',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                            'attribute' => 'departureDateTimeEstimated',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'carrier',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'carrier',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'equipmentIdentification',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'equipmentIdentification',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'BookingreferenceNumber',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'BookingreferenceNumber',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'RealiseReferenceNumber',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'RealiseReferenceNumber',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'PositioningDatetimeOfEquipment',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                            'attribute' => 'PositioningDatetimeOfEquipment',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'ActivityLocation',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'ActivityLocation',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'ActivityLocationRelatedPlace',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'ActivityLocationRelatedPlace',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'GrossWeight',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'GrossWeight',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'TareWeight',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'TareWeight',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'CarRegNumber',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'CarRegNumber',
                            'url' => $this->createUrl('/edifactdata/edifactData/editableSaver'),
                        ),
                        true
                    )
                ),
           ),
        )); ?>
    </div>

    </div>
    <div class="row">

    <div class="span12">
        <?php //$this->renderPartial('_view-relations_grids',array('modelMain' => $model, 'ajax' => false,)); ?>    
    </div>
</div>

<?php echo $cancel_buton; ?>