<?php

Yii::import('vendor.phpoffice..phpexcel.Classes.PHPExcel');
$styleTitle = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);


$fillWeekend = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'argb' => 'FFFFFF00', //yelow
        ),
    ),
);
$fillHolliday = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'argb' => 'FFD14432',
        ),
    ),
);

$styleHeader = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$styleHeaderColumn = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$styleDay = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$styleDayText = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$styleDayTotal = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);



$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("KL Shipping")
//->setLastModifiedBy("Maarten Balliauw")
        ->setTitle('Container movings on ' . $report_date);

;


//headers
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'CONTAINER_PREFIX')
        ->setCellValue('B1', 'CONTAINER_NUM')
        ->setCellValue('C1', 'MOVEMENT_LOCATION_CD')
        ->setCellValue('D1', 'MOVEMENT_FACILITY_CD')
        ->setCellValue('E1', 'STATUS_CD')
        ->setCellValue('F1', 'MOVEMENT_DT')
        ->setCellValue('G1', 'VESSEL_CD')
        ->setCellValue('H1', 'VOYAGE_CD')
        ->setCellValue('I1', 'LEG_CD')
        ->setCellValue('J1', 'NEXT_LOCATION_CD');
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleHeader);

$terminal_alt_codes = Yii::app()->params['cyprus_data_export_options']['terminal_alt_codes'];
$movment_times = Yii::app()->params['cyprus_data_export_options']['movment_times'];
$rn = 1;
while ($row = array_shift($data)) {
    $rn ++;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $rn, substr($row->ecnt_container_nr, 0, 4))
            ->setCellValue('B' . $rn, substr($row->ecnt_container_nr, 4))
            ->setCellValue('C' . $rn, 'LVRIX')
            ->setCellValue('D' . $rn, $terminal_alt_codes[$row->ecnt_terminal])
            ->setCellValue('E' . $rn, $row->ecnt_move_code)
            ->setCellValue('F' . $rn, $report_date . ' ' . $movment_times[$row->ecnt_move_code]);
}


//out to browser
$file_name = 'latvia_' . str_replace('.','',$report_date) . '.xls';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $file_name . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
