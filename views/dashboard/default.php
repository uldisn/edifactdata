<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Dashboard'));
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <h1>
                <i class="icon-dashboard"></i>
<?php echo Yii::t('EdifactDataModule.model', 'Dashboard'); ?>            </h1>
        </div>
    </div>
</div>
<?php
Yii::beginProfile('edifact.view.grid');

$grid_error = '';
$grid_warning = '';
?>

<div class="table-header">
    <i class="icon-warning-sign"></i>
<?= Yii::t('EdifactDataModule.model', 'EDI files reading errors') ?>
</div>

<?php
if (!empty($grid_error)) {
    ?>
    <div class="alert alert-error"><?php echo $grid_error ?></div>
    <?php
}

if (!empty($grid_warning)) {
    ?>
    <div class="alert alert-warning"><?php echo $grid_warning ?></div>
    <?php
}
//if (!empty($modelMain->ecerErrors)) {
// render grid view
$model = Edifact::model();
$model->status = Edifact::STATUS_ERROR;
$this->widget('TbGridView', array(
    'id' => 'ecer-errors-grid',
    'dataProvider' => $model->search(),
    'template' => '{summary}{items}{pager}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),
    'columns' => array(
            array(
                //char(10)
                'name' => 'terminal',
            ),
            array(
                'name' => 'bgm_1_id',
            ),
            array(
                'name' => 'prep_datetime',
            ),
            array(
                'name' => 'message_ref_number',
            ),
            array(
                'name' => 'filename',
            ),
            array(
                'name' => 'create_datetime',
            ),
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'TRUE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'FALSE'),
            ),
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("edifact/view", array("id" => $data->id))',
            'viewButtonOptions' => array('data-toggle' => 'tooltip'),
        ),
    )
        )
);


Yii::endProfile('edifact.view.grid');

Yii::beginProfile('ecer_ecnt_id.view.grid');

$grid_error = '';
$grid_warning = '';
?>

<div class="table-header">
    <i class="icon-warning-sign"></i>
<?= Yii::t('EdifactDataModule.model', 'Non-standard moving of containers') ?>
</div>

<?php
if (!empty($grid_error)) {
    ?>
    <div class="alert alert-error"><?php echo $grid_error ?></div>
    <?php
}

if (!empty($grid_warning)) {
    ?>
    <div class="alert alert-warning"><?php echo $grid_warning ?></div>
    <?php
}
//if (!empty($modelMain->ecerErrors)) {
// render grid view
$model = EcerErrors::model();
$this->widget('TbGridView', array(
    'id' => 'ecer-errors-grid',
    'dataProvider' => $model->search($criteria_ecer_error),
    'template' => '{summary}{items}{pager}',
      'rowCssClassExpression' => '$data->ecerEcnt->ccmcMoveCode->ccmc_css_class',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),
    'columns' => array(
        array(
            'name' => 'ecer_descr',
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ecer_notes',
            'editable' => array(
                'type' => 'textarea',
                'url' => $this->createUrl('//edifactdata/ecerErrors/editableSaver'),
            //'placement' => 'right',
            )
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ecer_status',
            'editable' => array(
                'type' => 'select',
                'url' => $this->createUrl('//edifactdata/ecerErrors/editableSaver'),
                'source' => $model->getEnumFieldLabels('ecer_status'),
            //'placement' => 'right',
            ),
            'filter' => $model->getEnumFieldLabels('ecer_status'),
        ),
        array('name' => 'ecnt_terminal'),
        array('name' => 'ecnt_move_code'),
        array('name' => 'ecnt_container_nr'),
        array('name' => 'ecnt_datetime'),
        array('name' => 'ecnt_operation'),
        array('name' => 'ecnt_transport_id'),
        array('name' => 'ecnt_iso_type'),
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'TRUE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'FALSE'),
            ),
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("ecntContainer/view", array("ecnt_id" => $data->ecer_ecnt_id))',
            'viewButtonOptions' => array('data-toggle' => 'tooltip'),
        ),
    )
        )
);
//}

Yii::endProfile('ecer_ecnt_id.view.grid');


Yii::beginProfile('ecer_ecnt_id2.view.grid');

$grid_error = '';
$grid_warning = '';
?>

<div class="table-header">
    <i class="icon-warning-sign"></i>
<?= Yii::t('EdifactDataModule.model', 'More 7 days hold containers') ?>
</div>

    <?php
    if (!empty($grid_error)) {
        ?>
    <div class="alert alert-error"><?php echo $grid_error ?></div>
    <?php
}

if (!empty($grid_warning)) {
    ?>
    <div class="alert alert-warning"><?php echo $grid_warning ?></div>
    <?php
}
//if (!empty($modelMain->ecerErrors)) {
// render grid view
$model = EcerErrors::model();
$this->widget('TbGridView', array(
    'id' => 'ecer-errors-grid2',
    'dataProvider' => $model->search($criteria_ecer_7days),
    'template' => '{summary}{items}{pager}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),
    'columns' => array(
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ecer_notes',
            'editable' => array(
                'type' => 'textarea',
                'url' => $this->createUrl('//edifactdata/ecerErrors/editableSaver'),
            //'placement' => 'right',
            )
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'ecer_status',
            'editable' => array(
                'type' => 'select',
                'url' => $this->createUrl('//edifactdata/ecerErrors/editableSaver'),
                'source' => $model->getEnumFieldLabels('ecer_status'),
            //'placement' => 'right',
            ),
            'filter' => $model->getEnumFieldLabels('ecer_status'),
        ),
        array('name' => 'ecnt_terminal'),
        array('name' => 'ecnt_move_code'),
        array('name' => 'ecnt_container_nr'),
        array('name' => 'ecnt_datetime'),
        array('name' => 'ecnt_operation'),
        array('name' => 'ecnt_transport_id'),
        array('name' => 'ecnt_iso_type'),
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'TRUE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'FALSE'),
            ),
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("ecntContainer/view", array("ecnt_id" => $data->ecer_ecnt_id))',
            'viewButtonOptions' => array('data-toggle' => 'tooltip'),
        ),        
    )
        )
);
//}
Yii::endProfile('ecer_ecnt_id2.view.grid');


Yii::beginProfile('ecnt.view.grid');

$grid_error = '';
$grid_warning = '';
?>

<div class="table-header">
    <i class="icon-th-large"></i>
<?= Yii::t('EdifactDataModule.model', 'Empty containers') ?>
</div>

    <?php
    if (!empty($grid_error)) {
        ?>
    <div class="alert alert-error"><?php echo $grid_error ?></div>
    <?php
}

if (!empty($grid_warning)) {
    ?>
    <div class="alert alert-warning"><?php echo $grid_warning ?></div>
    <?php
}

$model = EcntContainer::model();
$this->widget('TbGridView', array(
    'id' => 'ecnt-grid',
    'dataProvider' => $model->searchEmpty(),
    'template' => '{summary}{items}{pager}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),
    'columns' => array(
            array(
                //varchar(10)
                'name' => 'ecnt_terminal',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_container_nr',
            ),
            array(
                'name' => 'ecnt_datetime',
            ),
            array(
                'name' => 'ecnt_move_code',
                'value' => '$data->getEnumColumnLabel("ecnt_move_code")',
            ),            
            array(
                    'name' => 'ecnt_iso_type',
                     'type' => 'raw',
                     'value' => 'isset($data->cctcTypeCode->cctc_css_class) ? Chtml::tag("span" , array("class" => $data->cctcTypeCode->cctc_css_class ), $data->ecnt_iso_type) : $data->ecnt_iso_type'
                ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'ecnt_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                    //'placement' => 'right',
                )
            ),            
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'TRUE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'FALSE'),
            ),
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("ecntContainer/view", array("ecnt_id" => $data->ecnt_id))',
            'viewButtonOptions' => array('data-toggle' => 'tooltip'),
        ),        
    )
        )
);

Yii::endProfile('ecnt.view.grid');

Yii::beginProfile('ecnt_on_the_way.view.grid');

$grid_error = '';
$grid_warning = '';
?>

<div class="table-header">
    <i class="icon-road"></i>
<?= Yii::t('EdifactDataModule.model', 'On The Way') ?>
</div>

    <?php
    if (!empty($grid_error)) {
        ?>
    <div class="alert alert-error"><?php echo $grid_error ?></div>
    <?php
}

if (!empty($grid_warning)) {
    ?>
    <div class="alert alert-warning"><?php echo $grid_warning ?></div>
    <?php
}
//if (!empty($modelMain->ecerErrors)) {
// render grid view
$model = EcntContainer::model();
$this->widget('TbGridView', array(
    'id' => 'ecnt-way-grid',
    'dataProvider' => $model->searchOnTheWay(),
    'template' => '{summary}{items}',
    'summaryText' => '&nbsp;',
    'htmlOptions' => array(
        'class' => 'rel-grid-view'
    ),
    'columns' => array(
            array(
                //varchar(10)
                'name' => 'ecnt_terminal',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_transport_id',
            ),        
            array(
                //varchar(50)
                'name' => 'ecnt_container_nr',
            ),
            array(
                'name' => 'ecnt_datetime',
            ),
            array(
                'name' => 'ecnt_move_code',
                'value' => '$data->getEnumColumnLabel("ecnt_move_code")',
            ),            
            array(
                'name' => 'ecnt_iso_type',
                ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'ecnt_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                    //'placement' => 'right',
                )
            ),            
        array(
            'class' => 'TbButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'TRUE'),
                'update' => array('visible' => 'FALSE'),
                'delete' => array('visible' => 'FALSE'),
            ),
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("ecntContainer/view", array("ecnt_id" => $data->ecnt_id))',
            'viewButtonOptions' => array('data-toggle' => 'tooltip'),
        ),        
    )
        )
);
//}
Yii::endProfile('ecnt_on_the_way.view.grid');