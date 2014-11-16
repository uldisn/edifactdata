<?php
    $this->setPageTitle(Yii::t('EdifactDataModule.model', 'Edifact'));    
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("EdifactDataModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("Edifactdata.Edifact.*") || Yii::app()->user->checkAccess("Edifactdata.Edifact.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("EdifactDataModule.crud","Back"),
                )
 ),true);
    
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('EdifactDataModule.model','Edifact');?>
            </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="span6">

        <?php
        $this->widget(
            'TbAceDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                
                array(
                    'name' => 'id',
                ),
                array(
                    'name' => 'terminal',
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
           ),
        )); ?>
    </div>
    <div class="span6">
        <pre><?php echo $model->message;?></pre>
    </div>
</div>
<div class="space-12"></div>
<div class="row">

    <h3 class="header blue lighter smaller">
        EDI File Readable
    </h3>        
    <div class="span12">
        <pre>
<?php


$EdiParser = new EDI\Parser();
$f = explode(PHP_EOL, $model->message);
$parsed = $EdiParser->parse($f);

$analyser = new EDI\Analyser();
$analyser->edi_message = explode(PHP_EOL,$model->message);
$mapping_segments = realpath(Yii::getPathOfAlias('edifact-parser')) . '/Mapping/d95b/segments.xml';
$analyser->loadSegmentsXml($mapping_segments);
echo $analyser->process($parsed);
?>    
        </pre>
    </div>
</div>
<div class="space-12"></div>


