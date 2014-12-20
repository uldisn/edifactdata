<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Price'));
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "visible" => (Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.*") || Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.View")),
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
                <i class="icon-money"></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Terminal Price'); ?>
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
                    "submit" => array("delete", "etpr_id" => $model->{$model->tableSchema->primaryKey}, "returnUrl" => (Yii::app()->request->getParam("returnUrl")) ? Yii::app()->request->getParam("returnUrl") : $this->createUrl("admin")),
                    "confirm" => Yii::t("EdifactDataModule.crud", "Do you want to delete this item?")
                ),
                "visible" => (Yii::app()->request->getParam("etpr_id")) && (Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.*") || Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.Delete"))
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span12">

<?php
$this->widget(
        'TbAceDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'etpr_id',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_id',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_terminal',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_terminal',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_date_from',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'type' => 'date',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                'attribute' => 'etpr_date_from',
                    //'placement' => 'right',
                    ), true
            )
        ),
        array(
            'name' => 'etpr_date_to',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'type' => 'date',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                'attribute' => 'etpr_date_to',
                    //'placement' => 'right',
                    ), true
            )
        ),
        array(
            'name' => 'etpr_operation',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'type' => 'select',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                'source' => $model->getEnumFieldLabels('etpr_operation'),
                'attribute' => 'etpr_operation',
                    //'placement' => 'right',
                    ), true
            )
        ),
        array(
            'name' => 'etpr_container_status',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'type' => 'select',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                'source' => $model->getEnumFieldLabels('etpr_container_status'),
                'attribute' => 'etpr_container_status',
                    //'placement' => 'right',
                    ), true
            )
        ),
        array(
            'name' => 'etpr_container_size',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'type' => 'select',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                'source' => $model->getEnumFieldLabels('etpr_container_size'),
                'attribute' => 'etpr_container_size',
                    //'placement' => 'right',
                    ), true
            )
        ),
        array(
            'name' => 'etpr_day_from',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_day_from',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_day_to',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_day_to',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_price',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_price',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_imdg_price',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_imdg_price',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_imdg_coefficient',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_imdg_coefficient',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_h68_2020_coefficient',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_h68_2020_coefficient',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_hour_holiday_coefficient',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_hour_holiday_coefficient',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
        array(
            'name' => 'etpr_notes',
            'type' => 'raw',
            'value' => $this->widget(
                    'EditableField', array(
                'model' => $model,
                'attribute' => 'etpr_notes',
                'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    ), true
            )
        ),
    ),
));
?>
    </div>

</div>
<br>
        <?php
        $cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
            "icon" => "chevron-left",
            "size" => "large",
            "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
            "visible" => (Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.*") || Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.View")),
            "htmlOptions" => array(
                "class" => "search-button",
                "data-toggle" => "tooltip",
                "title" => Yii::t("EdifactDataModule.crud", "Back"),
            )
                ), true);

        echo $cancel_buton;
        