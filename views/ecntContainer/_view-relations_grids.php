<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
}

if (!$ajax || $ajax == 'ecer-errors-grid') {
    Yii::beginProfile('ecer_ecnt_id.view.grid');

    $grid_error = '';
    $grid_warning = '';
    ?>

    <div class="table-header">
        <?= Yii::t('EdifactDataModule.model', 'Ecer Errors') ?>
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
    if (!empty($modelMain->ecerErrors)) {
        $model = new EcerErrors();
        $model->unsetAttributes();
        $model->ecer_ecnt_id = $modelMain->primaryKey;

        // render grid view

        $this->widget('TbGridView', array(
            'id' => 'ecer-errors-grid',
            'dataProvider' => $model->search(),
            'template' => '{summary}{items}',
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
            )
                )
        );
    }
    Yii::endProfile('ecer_ecnt_id.view.grid');
}


if (!$ajax || $ajax == 'ecnt-container-grid') {
    Yii::beginProfile('ecnt_edifact_id.view.grid');

    $grid_error = '';
    $grid_warning = '';
    ?>

    <div class="table-header">
        <?= Yii::t('EdifactDataModule.model', 'Ecnt Container') ?>
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

    $model = new EcntContainer();
    $model->unsetAttributes();
    $model->ecnt_container_nr = $modelMain->ecnt_container_nr;

    // render grid view

    $this->widget('TbGridView', array(
        'id' => 'ecnt-container-grid',
        'dataProvider' => $model->search(),
        'template' => '{summary}{items}',
        'summaryText' => '&nbsp;',
        'htmlOptions' => array(
            'class' => 'rel-grid-view'
        ),
        'columns' => array(
            array(
                'name' => 'ecnt_terminal',
            ),
            array(
                'name' => 'ecnt_move_code',
            ),
            array(
                'name' => 'ecnt_datetime',
            ),
            array(
                'name' => 'ecnt_operation',
            ),
            array(
                'name' => 'ecnt_transport_id',
            ),
            array(
                'name' => 'ecnt_statuss',
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'ecnt_notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('//edifactdata/ecntContainer/editableSaver'),
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
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("", array("ecnt_id" => $data->ecnt_id))',
                'viewButtonOptions' => array('data-toggle' => 'tooltip'),
            ),
        ),
            )
    );
    Yii::endProfile('ecnt_edifact_id.view.grid');
}     