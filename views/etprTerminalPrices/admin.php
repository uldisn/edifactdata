<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Etpr Terminal Prices'));
?>

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
             'visible'=>(Yii::app()->user->checkAccess('Edifactdata.EtprTerminalPrices.*') || Yii::app()->user->checkAccess('Edifactdata.EtprTerminalPrices.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Etpr Terminal Prices');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('EtprTerminalPrices.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'etpr-terminal-prices-grid',
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
                //char(10)
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_terminal',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_date_from',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_date_to',
                'editable' => array(
                    'type' => 'date',
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'etpr_operation',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                        'source' => $model->getEnumFieldLabels('etpr_operation'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('etpr_operation'),
                ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'etpr_container_status',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                        'source' => $model->getEnumFieldLabels('etpr_container_status'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('etpr_container_status'),
                ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'etpr_container_size',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                        'source' => $model->getEnumFieldLabels('etpr_container_size'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('etpr_container_size'),
                ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_day_from',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),

            array(
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_day_to',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                //decimal(6,2)
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_price',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(6,2)
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_imdg_price',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(2,1)
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_imdg_coefficient',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(2,1)
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_h68_2020_coefficient',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                //decimal(2,1)
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_hour_holiday_coefficient',
                'editable' => array(
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'etpr_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/edifactdata/etprTerminalPrices/editableSaver'),
                    //'placement' => 'right',
                )
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("etpr_id" => $data->etpr_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("etpr_id" => $data->etpr_id))',
                'deleteConfirmation'=>Yii::t('EdifactDataModule.crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);

Yii::endProfile('EtprTerminalPrices.view.grid');