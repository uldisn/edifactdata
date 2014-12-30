<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#ecnt-container-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'ecnt-container-form',
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
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_id')) != 'tooltip.ecnt_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'ecnt_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_terminal') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_terminal')) != 'tooltip.ecnt_terminal')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_terminal', array('size' => 10, 'maxlength' => 10));
                            echo $form->error($model,'ecnt_terminal')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_move_code') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_move_code')) != 'tooltip.ecnt_move_code')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'ecnt_move_code', $model->getEnumFieldLabels('ecnt_move_code'));
                            echo $form->error($model,'ecnt_move_code')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_container_nr') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_container_nr')) != 'tooltip.ecnt_container_nr')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_container_nr', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'ecnt_container_nr')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_datetime') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_datetime')) != 'tooltip.ecnt_datetime')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_datetime');
                            echo $form->error($model,'ecnt_datetime')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_operation') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_operation')) != 'tooltip.ecnt_operation')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'ecnt_operation', $model->getEnumFieldLabels('ecnt_operation'));
                            echo $form->error($model,'ecnt_operation')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_transport_id') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_transport_id')) != 'tooltip.ecnt_transport_id')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_transport_id', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'ecnt_transport_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_length') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_length')) != 'tooltip.ecnt_length')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'ecnt_length', $model->getEnumFieldLabels('ecnt_length'));
                            echo $form->error($model,'ecnt_length')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_iso_type') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_iso_type')) != 'tooltip.ecnt_iso_type')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_iso_type', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'ecnt_iso_type')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_weight') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_weight')) != 'tooltip.ecnt_weight')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_weight');
                            echo $form->error($model,'ecnt_weight')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_statuss') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_statuss')) != 'tooltip.ecnt_statuss')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'ecnt_statuss', $model->getEnumFieldLabels('ecnt_statuss'));
                            echo $form->error($model,'ecnt_statuss')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_eu_status') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_eu_status')) != 'tooltip.ecnt_eu_status')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'ecnt_eu_status', $model->getEnumFieldLabels('ecnt_eu_status'));
                            echo $form->error($model,'ecnt_eu_status')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_imo_code') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_imo_code')) != 'tooltip.ecnt_imo_code')?$t:'' ?>'>
                                <?php
                            echo $form->textField($model, 'ecnt_imo_code', array('size' => 50, 'maxlength' => 50));
                            echo $form->error($model,'ecnt_imo_code')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'ecnt_notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('EdifactDataModule.model', 'tooltip.ecnt_notes')) != 'tooltip.ecnt_notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'ecnt_notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'ecnt_notes')
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
