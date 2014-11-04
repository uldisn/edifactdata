<?php
$this->setPageTitle(
        Yii::t('EdifactDataModule.model', 'Edifact Data')
        . ' - '
        . Yii::t('EdifactDataModule.crud', 'View')
        . ': '
        . $model->getItemLabel()
);
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("EdifactDataModule.crud","Cancel"),
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "visible" => (Yii::app()->user->checkAccess("Edifactdata.EdifactData.*") || Yii::app()->user->checkAccess("Edifactdata.EdifactData.View")),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("EdifactDataModule.crud", "Back"),
    )
        ), true);
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton; ?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Edifact Data'); ?>                <small><?php echo$model->itemLabel ?></small>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            $this->widget("bootstrap.widgets.TbButton", array(
                "label" => Yii::t("EdifactDataModule.crud", "Delete"),
                "type" => "danger",
                "icon" => "icon-trash icon-white",
                "size" => "large",
                "htmlOptions" => array(
                    "submit" => array("delete", "id" => $model->{$model->tableSchema->primaryKey}, "returnUrl" => (Yii::app()->request->getParam("returnUrl")) ? Yii::app()->request->getParam("returnUrl") : $this->createUrl("admin")),
                    "confirm" => Yii::t("EdifactDataModule.crud", "Do you want to delete this item?")
                ),
                "visible" => (Yii::app()->request->getParam("id")) && (Yii::app()->user->checkAccess("Edifactdata.EdifactData.*") || Yii::app()->user->checkAccess("Edifactdata.EdifactData.Delete"))
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span6">
<?php
$this->widget(
        'TbAceDetailView', array(
    'data' => $model,
    'label_width' => 240,
    'attributes' => array(
        array(
            'name' => 'edifact_id',
        ),
        array(
            'name' => 'messageType',
            'value' => $model->getmessageTypeLabel(),
        ),
        array(
            'name' => 'interchangeSender',
        ),
        array(
            'name' => 'dateTimePreparation',
        ),
        array(
            'name' => 'messageReferenceNumber',
        ),
        array(
            'name' => 'conveyanceReferenceNumber',
        ),
        array(
            'name' => 'idOfTheMeansOfTransportVessel',
        ),
        array(
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
            'name' => 'carrier',
        ),
        array(
            'name' => 'equipmentIdentification',
        ),
        array(
            'name' => 'BookingreferenceNumber',
        ),
        array(
            'name' => 'RealiseReferenceNumber',
        ),
        array(
            'name' => 'PositioningDatetimeOfEquipment',
        ),
        array(
            'name' => 'ActivityLocation',
        ),
        array(
            'name' => 'ActivityLocationRelatedPlace',
        ),
        array(
            'name' => 'GrossWeight',
        ),
        array(
            'name' => 'TareWeight',
        ),
        array(
            'name' => 'CarRegNumber',
        ),
    ),
));
?>
    </div>
    <div class="span6">
        <?php
        $this->widget(
                'TbAceDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'FileName',
                    'value' => $model->edifact->filename,
                ),
                array(
                    'label' => 'Data',
                    'type' => 'raw',
                    'value' => str_replace(PHP_EOL,'<BR>',$model->edifact->message),
                ),
            ),
        ));
        ?>
    </div>

</div>
<div class="row">

    <div class="span12">
        <?php //$this->renderPartial('_view-relations_grids',array('modelMain' => $model, 'ajax' => false,)); ?>    
    </div>
</div>

        <?php echo $cancel_buton; ?>