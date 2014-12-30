<div class="page-header position-relative">
    <h1>
        Report for Cyprus
    </h1>
</div>

<div class="row">
    <div class="span12">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'report-form',
            'htmlOptions' => array(
            ),
        ));
        ?>        

        <div class="control-group">
            <label for="form-field-1" class="control-label">Date</label>

            <div class="controls">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'report_date',
                    'language' => strstr(Yii::app()->language . '_', '_', true),
                    'htmlOptions' => array('size' => 10,),
                    'value' => $report_date,
                    'options' => array(
                        'showButtonPanel' => true,
                        'changeYear' => true,
                        'dateFormat' => 'yy.mm.dd',
                    ),
                        )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="form-field-1" class="control-label">Excelis</label>

            <div class="controls">
                <?php
                echo CHtml::checkbox('excel', false, array('id' => 'excel', 'class' => 'checkbox_class'));
                ?>
            </div>
        </div>
        <div class="form-actions">
<?php
$this->widget("bootstrap.widgets.TbButton", array(
    "label" => 'Create report',
    "icon" => "icon-ok bigger-110",
    //"size"=>"large",
    "type" => "primary",
    "htmlOptions" => array(
        "onclick" => "$('#report-form').submit();",
    ),
));
?>
        </div>            
            <?php $this->endWidget() ?>  

    </div>





<?php
if ($data) {
    ?>    
        <div class="span9" >
            <div id="padr-dienu-registrs-grid" class="grid-view">
                <table id="table_report" class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>CONTAINER_PREFIX</th>
                        <th>CONTAINER_NUM</th>
                        <th>MOVEMENT_LOCATION_CD</th>
                        <th>MOVEMENT_FACILITY_CD</th>
                        <th>STATUS_CD</th>
                        <th>MOVEMENT_DT	VESSEL_CD</th>
                        <th>VOYAGE_CD</th>
                        <th>LEG_CD</th>
                        <th>NEXT_LOCATION_CD</th>
                    </tr>
    <?php
    $terminal_alt_codes = Yii::app()->params['cyprus_data_export_options']['terminal_alt_codes'];
    $movment_times = Yii::app()->params['cyprus_data_export_options']['movment_times'];
    
    foreach ($data as $row) {
        
        ?>
                        <tr>
                            <td><?php echo substr($row->ecnt_container_nr, 0, 4) ?></td>
                            <td><?php echo substr($row->ecnt_container_nr, 5) ?></td>
                            <td>RIX</td>
                            <td><?php echo $terminal_alt_codes[$row->ecnt_terminal] ?></td>                    
                            <td><?php echo $row->ecnt_move_code ?></td>                    
                            <td><?php echo $report_date . ' ' . $movment_times[$row->ecnt_move_code] ?></td>                    
                            <td></td>                    
                            <td></td>                    
                            <td></td>                    
                        </tr>        
        <?
    }
    ?>    

                </table>


            </div><?php
}
?>
    </div>
</div>    