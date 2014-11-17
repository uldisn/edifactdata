<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Containers'));

?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Ecnt Containers');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('EcntContainer.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'ecnt-container-grid',
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
                //varchar(10)
                'name' => 'ecnt_terminal',
            ),
            array(
                //varchar(10)
                'name' => 'ecnt_message_type',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_container_nr',
            ),
            array(
                'name' => 'ecnt_datetime',
            ),
            array(
                'name' => 'ecnt_operation',
                'filter' => $model->getEnumFieldLabels('ecnt_operation'),
                ),
            array(
                //varchar(50)
                'name' => 'ecnt_transport_id',
            ),

            array(
                    'name' => 'ecnt_length',
                   'filter' => $model->getEnumFieldLabels('ecnt_length'),
                ),
            array(
                //varchar(50)
                'name' => 'ecnt_iso_type',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_ib_carrier',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_ob_carrier',
            ),
            array(
                'name' => 'ecnt_weight',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                    'name' => 'ecnt_statuss',
                   'filter' => $model->getEnumFieldLabels('ecnt_statuss'),
                ),
            array(
                //varchar(50)
                'name' => 'ecnt_line',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_fwd',
            ),
            array(
                //varchar(50)
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
                'name' => 'ecnt_action_amt',
                'type' => 'raw',
                'value' => 'CHtml::tag("span", array("data-toggle" => "tooltip","title"=>"=".$data->ecnt_action_calc_notes), $data->ecnt_action_amt)',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),                
            ),
            array(
                'name' => 'ecnt_time_amt',
                'type' => 'raw',
                'value' => 'CHtml::tag("span", array("data-toggle" => "tooltip","title"=>"=".$data->ecnt_time_calc_notes), $data->ecnt_time_amt)',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),                
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
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EcntContainer.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'FALSE'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("ecnt_id" => $data->ecnt_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("ecnt_id" => $data->ecnt_id))',
                'deleteConfirmation'=>Yii::t('EdifactDataModule.crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('EcntContainer.view.grid'); ?>