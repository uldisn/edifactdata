<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Containers'));

?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Containers');?>  
            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('EcprContainerProcesing.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'ecpr-container-procesing-grid',
        'dataProvider' => $model->searchExt(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                'name' => 'ecnt_terminal',
            ),
            array(
                'name' => 'ecnt_container_nr',
            ),
            array(
                'name' => 'ecnt_statuss',
            ),
            array(
                'name' => 'ecnt_length',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),                                
            ),
            array(
                'name' => 'ecnt_datetime',
            ),
            array(
                'name' => 'action_amt',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),                                
            ),
            array(
                'name' => 'time_amt',
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),                                
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.EcprContainerProcesing.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'FALSE'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("ecpr_id" => $data->ecpr_id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("ecpr_id" => $data->ecpr_id))',
                'deleteConfirmation'=>Yii::t('`crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('EcprContainerProcesing.view.grid'); ?>