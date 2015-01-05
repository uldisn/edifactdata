<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Containers Moving'));

Yii::app()->clientScript->registerScript('tooltip','$("span").tooltip();');

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
             'visible'=>(Yii::app()->user->checkAccess('Edifactdata.EcntContainer.*') || Yii::app()->user->checkAccess('Edifactdata.EcntContainer.Create'))
        ));  
        ?>
        </div>         
        <div class="btn-group">
            <h1>
                <i class="icon-exchange"></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Containers Moving');?>            
            </h1>
        </div>
    </div>
</div>

<?php 

Yii::beginProfile('EcntContainer.view.grid');
$this->widget('TbGridView',
    array(
        'id' => 'ecnt-container-grid',
        'dataProvider' => $model->searchAdmin(),
        'filter' => $model,
        'rowCssClassExpression' => '$data->ccmcMoveCode->ccmc_css_class',
        'template' => '{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'afterAjaxUpdate' => 'filter_EcntContainer_ecnt_datetime_init',
        'columns' => array(
            array(
                //varchar(10)
                'name' => 'ecnt_terminal',
            ),
            array(
                //varchar(50)
                'name' => 'ecnt_container_nr',
                'type' => 'raw', 
                'value' => 'Chtml::link($data->ecnt_container_nr , 
                    Yii::app()->controller->createUrl("admin", array("EcntContainer[ecnt_container_nr]" => $data->ecnt_container_nr) ) )'
            ),
            array(
                'name' => 'ecnt_datetime',
                'filter' => $this->widget('vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', 
                             array(
                                'model' => $model,
                                'attribute' => 'ecnt_datetime_range',
                                'options' => array(
                                    'ranges' => array('today','yesterday','this_week','last_week','this_month','last_month','this_year'),
                                ) 
                            ), TRUE ),  
                 'headerHtmlOptions'=>array('style' => 'width:100px;'),
            ),
            array(
                'name' => 'ecnt_operation',
                'filter' => $model->getEnumFieldLabels('ecnt_operation'),
                ),
            array(
                'name' => 'ecnt_move_code',
                'type' => 'raw', 
                'value' => 'Chtml::tag("span",array( "title" => $data->ccmcMoveCode->ccmc_long ),$data->getEnumColumnLabel("ecnt_move_code"))',
                'filter' => $model->getEnumFieldLabels('ecnt_move_code'),
                'headerHtmlOptions'=>array('style' => 'width:70px;'),
            ),            
            array(
                //varchar(50)
                'name' => 'ecnt_transport_id',
            ),

            array(
                    'name' => 'ecnt_iso_type',
                    'type' => 'raw',
                    'value' => 'isset($data->cctcTypeCode->cctc_css_class) ? Chtml::tag("span" , array("class" => $data->cctcTypeCode->cctc_css_class ), $data->ecnt_iso_type) : $data->ecnt_iso_type'
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
                     'headerHtmlOptions'=>array('style' => 'width:100px;'),
                ),
       //     array(
                //varchar(50)
       //         'name' => 'ecnt_line',
       //     ),
       //     array(
                //varchar(50)
       //         'name' => 'ecnt_fwd',
        //    ),
            array(
                //varchar(50)
                'name' => 'ecnt_booking',
            ),
      //      array(
      //              'name' => 'ecnt_eu_status',
      //             'filter' => $model->getEnumFieldLabels('ecnt_eu_status'),
      //          ),
      //      array(
      //          //varchar(50)
      //          'name' => 'ecnt_imo_code',
      //      ),
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
                'name'=>'error',
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

Yii::endProfile('EcntContainer.view.grid');

?>

