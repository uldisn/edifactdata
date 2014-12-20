<?php
    $this->setPageTitle(Yii::t('EdifactDataModule.model', 'Container'));    
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("`crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("Edifactdata.EcprContainerProcesing.*") || Yii::app()->user->checkAccess("Edifactdata.EcprContainerProcesing.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("`crud","Back"),
                )
 ),true);
    
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-th-large"></i>
                <?php echo Yii::t('EdifactDataModule.model','Container');?>                
                <small><?php echo$model->itemLabel?></small>
            </h1>
        </div>

    </div>
</div>



<div class="row">
    <div class="span3">


        <?php
        $this->widget(
            'TbAceDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                
                array(
                    'name' => 'ecpr_id',
                ),

                array(
                    'name' => 'ecpr_start_ecnt_id',
                ),

                array(
                    'name' => 'ecpr_end_ecnt_id',
                ),
                array(
                    'label' => 'Terminal',
                    'value' => $model->ecprStartEcnt->ecnt_terminal,
                ),
                array(
                    'label' => 'Container',
                    'value' => $model->ecprStartEcnt->ecnt_container_nr,
                ),
                array(
                    'label' => 'Container',
                    'value' => $model->ecprStartEcnt->ecnt_datetime,
                ),
                array(
                    'label' => 'Statuss',
                    'value' => $model->ecprStartEcnt->ecnt_statuss,
                ),
                array(
                    'label' => 'Length',
                    'value' => $model->ecprStartEcnt->ecnt_length,
                ),
                   
  
           ),
        )); ?>
    </div>
</div>
<div class="space"></div>
<div class="row">

    <div class="span12">
        <?php $this->renderPartial('_view-relations_grids',array('modelMain' => $model, 'ajax' => false,)); ?>    
    </div>
</div>

<?php echo $cancel_buton; ?>