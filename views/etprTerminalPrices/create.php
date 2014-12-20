<?php
$this->setPageTitle(
    Yii::t('EdifactDataModule.model', 'Create Terminal Prices record')
);

$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(

    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.*") || Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("EdifactDataModule.crud","Cancel"),
                )
 ),true);
    
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-money"></i>
                <?php echo Yii::t('EdifactDataModule.model','Create Terminal Prices record');?>            
            </h1>
        </div>
    </div>
</div>

<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>Yii::t("EdifactDataModule.crud","Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('.crud-form form').submit();",
                       ),
                       "visible"=> (Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.*") || Yii::app()->user->checkAccess("Edifactdata.EtprTerminalPrices.View"))
                    )); 
                    ?>
                  
        </div>
    </div>
</div>