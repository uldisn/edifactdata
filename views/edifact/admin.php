<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Edifacts'));
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <h1>
                <i class="icon-paperclip"></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Edifacts');?>            </h1>
        </div>
    </div>
</div>

<?php 

Yii::beginProfile('Edifact.view.grid'); 
$this->widget('TbGridView',
    array(
        'id' => 'edifact-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
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
                //char(20)
                'name' => 'message_ref_number',
            ),
            array(
                'name' => 'filename',
            ),
            array(
                'name' => 'create_datetime',
            ),
            array(
                'name' => 'status',
                'filter' => $model->getEnumFieldLabels('status'),
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("Edifactdata.Edifact.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'FALSE'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
                'deleteConfirmation'=>Yii::t('EdifactDataModule.crud','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('Edifact.view.grid'); ?>