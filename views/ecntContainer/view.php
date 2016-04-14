<?php
$this->setPageTitle(Yii::t('EdifactDataModule.model', 'Container moving'));
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    "icon" => "chevron-left",
    "size" => "large",
    "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
    "visible" => (Yii::app()->user->checkAccess("Edifactdata.EcntContainer.*") || Yii::app()->user->checkAccess("Edifactdata.EcntContainer.View")),
    "htmlOptions" => array(
        "class" => "search-button",
        "data-toggle" => "tooltip",
        "title" => Yii::t("EdifactDataModule.crud", "Back"),
    )
        ), true);
?>

<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton; ?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-exchange"></i>
                <?php echo Yii::t('EdifactDataModule.model', 'Container moving'); ?>                
                <small><?php echo$model->ecnt_container_nr ?></small>
            </h1>
        </div>
    </div>
</div>



<div class="row">
    <div class="span3">
        <?php
        $this->widget(
                'TbAceDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'ecnt_edifact_id',
                ),
                array(
                    'name' => 'ecnt_terminal',
                ),
                array(
                    'name' => 'ecnt_message_type',
                ),
                array(
                    'name' => 'ecnt_move_code',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                            'source' => $model->getEnumFieldLabels('ecnt_move_code'),
                            'attribute' => 'ecnt_move_code',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_container_nr',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'ecnt_container_nr',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_datetime',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                            'attribute' => 'ecnt_datetime',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_operation',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                            'source' => $model->getEnumFieldLabels('ecnt_operation'),
                            'attribute' => 'ecnt_operation',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_transport_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'ecnt_transport_id',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_length',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                            'source' => $model->getEnumFieldLabels('ecnt_length'),
                            'attribute' => 'ecnt_length',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_iso_type',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'ecnt_iso_type',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_ib_carrier',
                ),
                array(
                    'name' => 'ecnt_ob_carrier',
                ),
                array(
                    'name' => 'ecnt_weight',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'ecnt_weight',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                        ),
                        true
                    )
                ),
                array(
                    'name' => 'ecnt_statuss',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                            'source' => $model->getEnumFieldLabels('ecnt_statuss'),
                            'attribute' => 'ecnt_statuss',
                            //'placement' => 'right',
                        ),
                        true
                    )
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
                ),
                array(
                    'name' => 'ecnt_imo_code',
                ),
                array(
                    'name' => 'ecnt_action_amt',
                ),
                array(
                    'name' => 'ecnt_action_calc_notes',
                ),
                array(
                    'name' => 'ecnt_time_amt',
                ),
                array(
                    'name' => 'ecnt_time_calc_notes',
                ),
                array(
                    'name' => 'ecnt_notes',
                    'type' => 'raw',
                    'value' => $this->widget(
                            'EditableField', array(
                        'model' => $model,
                        'attribute' => 'ecnt_notes',
                        'url' => $this->createUrl('/edifactdata/ecntContainer/editableSaver'),
                            ), true
                    )
                ),
            ),
        ));
        ?>
    </div>
    <div class="span9">

        <?php
        $this->renderPartial('_view-relations_grids', array('modelMain' => $model, 'ajax' => false,));
        if (!empty($model->ecnt_edifact_id)) {
            ?>          
            <h3 class="header blue lighter smaller">
                <i class="icon-list-alt smaller-90"></i>
                EDI File
            </h3>        
            <?php
            $this->widget(
                    'TbAceDetailView', array(
                'data' => $model,
                'attributes' => array(
                    array(
                        'label' => 'FileName',
                        'value' => $model->ecntEdifact->filename,
                    ),
                    array(
                        'label' => 'Data',
                        'type' => 'raw',
                        'value' => str_replace(PHP_EOL, '<BR>', $model->ecntEdifact->message),
                    ),
                ),
            ));
        }
        ?>
    </div>

</div>
<?php
if (!empty($model->ecnt_edifact_id)) {
    ?>
    <div class="space-12"></div>
    <div class="row">

        <h3 class="header blue lighter smaller">
            EDI File Readable
        </h3>        
        <div class="span12">
            <pre>
                <?php
                $edifact = Edifact::model()->FindByPk($model->ecntEdifact->id);

                $EdiParser = new EDI\Parser();
                $f = explode(PHP_EOL, $edifact->message);
                $parsed = $EdiParser->parse($f);

                $analyser = new EDI\Analyser();
                $analyser->edi_message = $edifact->message;
                $mapping_segments = realpath(Yii::getPathOfAlias('edifact-data')) . '/D95B/segments.xml';
                $analyser->loadSegmentsXml($mapping_segments);
                echo $analyser->process($parsed);
                ?>    
            </pre>
        </div>
    </div>
    <?php
}
?>
<div class="space-12"></div>


<?php
echo
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
"icon" => "chevron-left",
 "size" => "large",
 "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
 "visible" => (Yii::app()->user->checkAccess("Edifactdata.EcntContainer.*") || Yii::app()->user->checkAccess("Edifactdata.EcntContainer.View")),
 "htmlOptions" => array(
"class" => "search-button",
 "data-toggle" => "tooltip",
 "title" => Yii::t("EdifactDataModule.crud", "Back"),
)
), true);

$cancel_buton;
