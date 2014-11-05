<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#etpr-terminal-prices-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'etpr-terminal-prices-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span12">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_id')) != 'tooltip.etpr_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'etpr_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_terminal') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_terminal')) != 'tooltip.etpr_terminal')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_terminal', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'etpr_terminal')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_date_from') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_date_from')) != 'tooltip.etpr_date_from')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'etpr_date_from',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => array('size' => 10),
                                 'options' => array(
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ),
                                 )
                             );
                    ;
                            echo $form->error($model,'etpr_date_from')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_date_to') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_date_to')) != 'tooltip.etpr_date_to')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'etpr_date_to',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => array('size' => 10),
                                 'options' => array(
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ),
                                 )
                             );
                    ;
                            echo $form->error($model,'etpr_date_to')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_operation') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_operation')) != 'tooltip.etpr_operation')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'etpr_operation', $model->getEnumFieldLabels('etpr_operation'));
                            echo $form->error($model,'etpr_operation')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_container_status') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_container_status')) != 'tooltip.etpr_container_status')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'etpr_container_status', $model->getEnumFieldLabels('etpr_container_status'));
                            echo $form->error($model,'etpr_container_status')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_container_size') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_container_size')) != 'tooltip.etpr_container_size')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'etpr_container_size', $model->getEnumFieldLabels('etpr_container_size'));
                            echo $form->error($model,'etpr_container_size')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_day_from') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_day_from')) != 'tooltip.etpr_day_from')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_day_from');
                            echo $form->error($model,'etpr_day_from')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_day_to') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_day_to')) != 'tooltip.etpr_day_to')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_day_to');
                            echo $form->error($model,'etpr_day_to')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_price') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_price')) != 'tooltip.etpr_price')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_price', array('size' => 7, 'maxlength' => 7));
                            echo $form->error($model,'etpr_price')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_imdg_price') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_imdg_price')) != 'tooltip.etpr_imdg_price')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_imdg_price', array('size' => 7, 'maxlength' => 7));
                            echo $form->error($model,'etpr_imdg_price')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_imdg_coefficient') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_imdg_coefficient')) != 'tooltip.etpr_imdg_coefficient')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_imdg_coefficient', array('size' => 4, 'maxlength' => 4));
                            echo $form->error($model,'etpr_imdg_coefficient')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_h68_2020_coefficient') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_h68_2020_coefficient')) != 'tooltip.etpr_h68_2020_coefficient')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_h68_2020_coefficient', array('size' => 4, 'maxlength' => 4));
                            echo $form->error($model,'etpr_h68_2020_coefficient')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_hour_holiday_coefficient') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_hour_holiday_coefficient')) != 'tooltip.etpr_hour_holiday_coefficient')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'etpr_hour_holiday_coefficient', array('size' => 4, 'maxlength' => 4));
                            echo $form->error($model,'etpr_hour_holiday_coefficient')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'etpr_notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.etpr_notes')) != 'tooltip.etpr_notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'etpr_notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'etpr_notes')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                
            </div>
        </div>
        <!-- main inputs -->

            </div>
    <div class="row">
        
    </div>

    <p class="alert">
        
        <?php 
            echo Yii::t('EdifactDataModule.crud','Fields with <span class="required">*</span> are required.');
                
            /**
             * @todo: We need the buttons inside the form, when a user hits <enter>
             */                
            echo ' '.CHtml::submitButton(Yii::t('EdifactDataModule.crud', 'Save'), array(
                'class' => 'btn btn-primary',
                'style'=>'visibility: hidden;'                
            ));
                
        ?>
    </p>


    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
