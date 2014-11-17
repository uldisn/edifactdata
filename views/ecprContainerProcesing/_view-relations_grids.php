<?php
if (!$ajax) {
    Yii::app()->clientScript->registerCss('rel_grid', ' 
            .rel-grid-view {margin-top:-60px;}
            .rel-grid-view div.summary {height: 60px;}
            ');
}
?>
<?php
if (!$ajax || $ajax == 'ecnt-container-grid') {
    Yii::beginProfile('ecnt_ecpr_id.view.grid');

    $grid_error = '';
    $grid_warning = '';
    ?>

    <div class="table-header">
        <?= Yii::t('EdifactDataModule.model', 'Container Moving') ?>
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
    if (!empty($modelMain->ecntContainers)) {
        $model = new EcntContainer();
        $model->ecnt_ecpr_id = $modelMain->primaryKey;

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
                    'name' => 'ecnt_message_type',
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
                    'name' => 'ecnt_iso_type',
                ),
                array(
                    'name' => 'ecnt_ib_carrier',
                ),
                array(
                    'name' => 'ecnt_ob_carrier',
                ),
                array(
                    'name' => 'ecnt_weight',
                    'htmlOptions' => array(
                        'class' => 'numeric-column',
                    ),
                ),
                array(
                    'name' => 'ecnt_line',
                ),
                array(
                    'name' => 'ecnt_fwd',
                ),
                array(
                    'name' => 'ecnt_booking',
                ),
                array(
                    'name' => 'ecnt_eu_status',
                    'filter' => $model->getEnumFieldLabels('ecnt_eu_status'),
                ),
                array(
                    //varchar(50)
                    'name' => 'ecnt_imo_code',
                ),
                array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'ecnt_notes',
                    'editable' => array(
                        'type' => 'textarea',
                        'url' => $this->createUrl('//edifactdata/ecntContainer/editableSaver'),
                    //'placement' => 'right',
                    ),
                    'footer' => 'Total:',
                    'footerHtmlOptions' => array('class' => 'total-row'),                    
                    
                ),
                array(
                    'name' => 'ecnt_action_amt',
                    'htmlOptions' => array(
                        'class' => 'numeric-column',
                    ),
                    'footer' => EcntContainer::getContainerActionAmtTotal($modelMain->ecpr_id),
                    'footerHtmlOptions' => array('class' => 'total-row numeric-column'),                    
                ),
                array(
                    'name' => 'ecnt_action_calc_notes',
                ),
                array(
                    'name' => 'ecnt_time_amt',
                    'htmlOptions' => array(
                        'class' => 'numeric-column',
                    ),
                    'footer' => EcntContainer::getContainerTimeAmtTotal($modelMain->ecpr_id),
                    'footerHtmlOptions' => array('class' => 'total-row numeric-column'),                    
                    
                ),
                array(
                    'name' => 'ecnt_time_calc_notes',
                ),
            )
                )
        );
    }
    Yii::endProfile('ecnt_ecpr_id.view.grid');
}