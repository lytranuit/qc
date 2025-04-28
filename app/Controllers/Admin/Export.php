<?php

namespace App\Controllers\Admin;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Export extends BaseController
{
    function __construct()
    {
        // $this->group = 'Status';
    }
    public function month()
    {
        return view($this->data['content'], $this->data);
    }
    public function year()
    {
        return view($this->data['content'], $this->data);
    }
    public function index()
    {
        $SampleModel = model("SampleModel");
        $this->data['samples'] = $SampleModel->where("factory_id", session()->factory_id)->findAll();
        return view($this->data['content'], $this->data);
    }
    public function exportmonth()
    {
        $SampleModel = model("SampleModel", false);
        $SampleTimeModel = model("SampleTimeModel", false);

        $monthyear = isset($_POST['monthyear']) ? $_POST['monthyear'] : "";
        $explode = explode("-", $monthyear);
        $year = isset($explode[0]) ? $explode[0] : 0;
        $month = isset($explode[1]) ? $explode[1] : 0;

        $where = $SampleTimeModel->where("factory_id", session()->factory_id)->where("MONTH(date_theory)", $month)->where("YEAR(date_theory)", $year);


        $posts = $where->orderby("date_theory", "ASC")->asObject()->findAll();
        $SampleTimeModel->relation($posts, array("sample"));
        // echo "<pre>";
        // print_r($posts);
        // die();
        usort($posts, function ($a, $b) {
            // So sánh theo date_theory trước
            $dateComparison = strcmp($a->date_theory, $b->date_theory);
            if ($dateComparison === 0) {
                // Nếu date_theory giống nhau, so sánh theo sample->code
                $codeComparison = strcmp($a->sample->code, $b->sample->code);
                if ($codeComparison === 0) {
                    // Nếu sample->code giống nhau, so sánh theo sample->code_batch
                    $codeBatchComparison = strcmp($a->sample->code_batch, $b->sample->code_batch);
                    if ($codeBatchComparison === 0) {
                        // Nếu sample->code_batch giống nhau, so sánh theo type_id
                        return strcmp($a->type_id, $b->type_id);
                    }
                    return $codeBatchComparison;
                }
                return $codeComparison;
            }
            return $dateComparison;
        });
        $file = APPPATH . '../assets/template/month_1.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        // echo "<pre>";
        // print_r($reader);
        // die();
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
        $objRichText2->createText("KẾ HOẠCH NGHIÊN CỨU ĐỘ ỔN ĐỊNH HÀNG THÁNG - [" . $month . "/" . $year . "]\n");
        $payable = $objRichText2->createTextRun("MONTHLY PLANNING FOR STABILITY STUDY - [" . $month . "/" . $year . "]");
        $payable->getFont()->setItalic(true);
        $payable->getFont()->setBold(false);
        $payable->getFont()->setName("Times New Roman");
        $payable->getFont()->setSize("12");
        $sheet->getCell("C1")->setValue($objRichText2);

        if (!empty($posts)) {
            $rows = 5;
            $key = 0;
            $sheet->insertNewRowBefore($rows + 1, count($posts));
            foreach ($posts as $post) {
                // $sheet->getStyle("A$rows:N$rows")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('858687');
                $env_name = "";
                $time_name = "";

                $sample = $post->sample;
                if (!isset($sample->name))
                    continue;
                switch ($post->type_id) {
                    case 1:
                        $env_name = "40°C ± 2°C / 75% ± 5% RH";
                        break;
                    case 2:
                        $env_name = "30°C ± 2°C / 65% ± 5% RH";
                        break;
                    case 3:
                        $env_name = "30°C ± 2°C / 75% ± 5% RH";
                        break;
                    case 4:
                        $env_name = "30°C ± 2°C / 65% ± 5% RH";
                        break;
                    case 5:
                        $env_name = "25°C ± 2°C / 60% ± 5% RH";
                        break;
                }
                switch ($post->type_time) {
                    case "M":
                        $time_name = $post->time;
                        break;
                    case "w":
                        $time_name = $post->time . " Tuần";
                        break;
                    case "d":
                        $time_name = $post->time . " Ngày";
                        break;
                    case "y":
                        $time_name = $post->time . " Năm";
                        break;
                }
                $weeks = $this->convertToWeeks($post->time, $post->type_time);
                $chechlech = "<7";
                if ($weeks > 4 && $weeks < 6) {
                    $chechlech = 7;
                } elseif ($weeks > 6 && $weeks < 40) {
                    $chechlech = 14;
                } elseif ($weeks > 40) {
                    $chechlech = 28;
                }

                $sheet->setCellValueExplicit('A' . $rows, ++$key, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('B' . $rows, $sample->name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('C' . $rows, $sample->code_batch, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('D' . $rows, $sample->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('E' . $rows, $sample->outline_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValue('F' . $rows, $sample->date_storage != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($sample->date_storage) : "");

                $sheet->setCellValue('G' . $rows, $env_name);
                $sheet->setCellValue('H' . $rows, $time_name);
                $sheet->setCellValue('I' . $rows, $post->date_theory != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($post->date_theory) : "");
                $sheet->setCellValue('J' . $rows, $chechlech);
                $sheet->setCellValue('K' . $rows, $post->date_reality != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($post->date_reality) : "");

                $sheet->setCellValue('L' . $rows, $post->note);
                $sheet->setCellValue('M' . $rows, "NA");
                $note = "";

                $sheet->getStyle('I' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                $sheet->getStyle('K' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                $sheet->getStyle('F' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");

                $sheet->getRowDimension($rows)->setRowHeight(-1);
                $rows++;
            }
        }
        // $sheet->getRowDimension(1)->setRowHeight(-1);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $name = time() . ".xlsx";
        $file = "assets/excel/$name";
        $writer->save($file);
        // header("Cache-Control: public"); // needed for internet explorer
        // // header("Content-Type: application/zip");
        // header("Content-Transfer-Encoding: Binary");
        // header("Content-Length:" . filesize($file));
        // header("Content-Disposition: attachment; filename=$name");
        // readfile($file);
        // die();
        echo json_encode(base_url($file));
    }
    public function exportyear()
    {
        ini_set('memory_limit', '1000M');
        $SampleModel = model("SampleModel", false);
        $SampleTimeModel = model("SampleTimeModel", false);

        $year = isset($_POST['year']) ? $_POST['year'] : 0;

        $where = $SampleTimeModel->where("factory_id", session()->factory_id)->where("YEAR(date_theory)", $year);


        $posts = $where->orderby("type_id", "ASC")->orderby("time", "ASC")->orderby("date_theory", "ASC")->asObject()->findAll();
        $SampleTimeModel->relation($posts, array("sample"));
        // echo "<pre>";
        // print_r($posts);
        // die();
        ///group
        // $r = $this->groupBy($posts, function ($item) {
        //     return $item->type_id;
        // });
        // echo "<pre>";
        // print_r($r);
        // die();
        $data_type = array();
        foreach ($posts as $post) {
            if (!array_key_exists($post->type_id, $data_type)) {
                $data_type[$post->type_id] = array();
            }
            if (!array_key_exists($post->time . "-" . $post->type_time,  $data_type[$post->type_id])) {
                $data_type[$post->type_id][$post->time . "-" . $post->type_time] = 0;
            }
            $data_type[$post->type_id][$post->time . "-" . $post->type_time]++;
        }
        // echo "<pre>";
        // print_r($data_type);
        // die();
        $file = APPPATH . '../assets/template/year2.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        // echo "<pre>";
        // print_r($reader);
        // die();
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
        $objRichText2->createText("KẾ HOẠCH NGHIÊN CỨU ĐỘ ỔN ĐỊNH HẰNG NĂM - NĂM " . $year . "\n");
        $payable = $objRichText2->createTextRun("ANNUAL PLAN FOR STABILITY STUDY - YEAR " . $year);
        $payable->getFont()->setItalic(true);
        $payable->getFont()->setBold(true);
        $payable->getFont()->setName("Times New Roman");
        $payable->getFont()->setSize("12");
        $sheet->getCell("C1")->setValue($objRichText2);
        ///HEADER
        $column = 6;
        foreach ($data_type as $key => $type) {
            $max = count($type);
            // echo $max . "<br>";
            $column_name = Coordinate::stringFromColumnIndex($column);
            // echo $column_name . "<br>";
            $num_column = $max * 4;
            // echo $column_name_end . "<br>";
            $sheet->insertNewColumnBefore($column_name, $num_column);


            $column_name_end = Coordinate::stringFromColumnIndex($column + $num_column - 1);
            $sheet->mergeCells($column_name . "4:" . $column_name_end . "4");
            switch ($key) {
                case 1:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Lão hóa\n");
                    $payable = $objRichText2->createTextRun("Accelerated\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("40°C ± 2°C/75% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;
                case 2:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Trung gian\n");
                    $payable = $objRichText2->createTextRun("Intermediate\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("30°C ± 2°C/65% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;

                case 3:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Dài hạn (ASEAN)\n");
                    $payable = $objRichText2->createTextRun("Long time (ASEAN)\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("30°C ± 2°C/75% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;

                case 4:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Dài hạn (EU)\n");
                    $payable = $objRichText2->createTextRun("Long time (EU)\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("25°C ± 2°C/60% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;
            }

            $start_column = $column;
            foreach ($type as $key1 => $t) {
                $explode = explode("-", $key1);
                $time = $explode[0];
                $type_time = $explode[1];
                switch ($type_time) {
                    case "M":
                        $time_name = $time . " Tháng";
                        $time_name_en = $time . " Months";
                        break;
                    case "w":
                        $time_name = $time . " Tuần";
                        $time_name_en = $time . " Weeks";
                        break;
                    case "d":
                        $time_name = $time . " Ngày";
                        $time_name_en = $time . " Days";
                        break;
                    case "y":
                        $time_name = $time . " Năm";
                        $time_name_en = $time . " Years";
                        break;
                }
                $data_type[$key][$key1] = $start_column;
                $column_name_1 = Coordinate::stringFromColumnIndex($start_column);
                $column_name_end_1 = Coordinate::stringFromColumnIndex($start_column + 4 - 1);
                $sheet->mergeCells($column_name_1 . "5:" . $column_name_end_1 . "5");

                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("$time_name\n");
                $payable = $objRichText2->createTextRun($time_name_en);
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(false);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_1 . "5")->setValue($objRichText2);


                $start_column_1 = $start_column;

                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Vị trí lưu mẫu\n");
                $payable = $objRichText2->createTextRun("Stored location");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(false);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;

                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Ngày lấy mẫu\n");
                $payable = $objRichText2->createTextRun("Sampling date");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(false);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;



                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Số lượng lấy\n");
                $payable = $objRichText2->createTextRun("Sample quantity");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(false);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;

                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Chỉ tiêu\n");
                $payable = $objRichText2->createTextRun("Tests");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(false);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;


                $start_column = $start_column + 4;
            }



            $column = $column + $num_column;
        }

        $column_name_3 = Coordinate::stringFromColumnIndex($column - 1);
        $sheet->mergeCells("F3:" . $column_name_3 . "3");
        $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
        $objRichText2->createText("Điều kiện nghiên cứu / ");
        $payable = $objRichText2->createTextRun("Study condition");
        $payable->getFont()->setItalic(true);
        $payable->getFont()->setBold(true);
        $payable->getFont()->setName("Times New Roman");
        $payable->getFont()->setSize("10");

        $sheet->getCell("F3")->setValue($objRichText2);


        $r = $this->groupBy($posts, function ($item) {
            return $item->sample_id;
        });
        $r = array_values($r);
        // echo "<pre>";
        // print_r($r);
        // die();
        if (!empty($r)) {
            $rows = 7;
            $sheet->insertNewRowBefore($rows + 1, count($r));
            $key = 0;

            foreach ($r as $post) {

                $sample = $post[0]->sample;
                if (!isset($sample->name))
                    continue;
                $sheet->setCellValueExplicit('A' . $rows, ++$key, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('B' . $rows, $sample->name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('C' . $rows, $sample->code_batch, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('D' . $rows, $sample->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('E' . $rows, $sample->outline_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                // $sheet->setCellValue('F' . $rows, $sample->date_storage != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($sample->date_storage) : "");
                // $sheet->getStyle('F' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");

                foreach ($post as $time) {
                    $column = $data_type[$time->type_id][$time->time . "-" . $time->type_time];
                    // echo $column . "<br>";
                    // break;


                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValueExplicit($column_name . $rows, $time->location, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $column++;

                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($column_name . $rows, $time->date_theory != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($time->date_theory) : "");
                    $sheet->getStyle($column_name . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                    $column++;

                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($column_name . $rows, $time->num_get);
                    $column++;

                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValueExplicit($column_name . $rows, $time->note, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $column++;
                }


                $sheet->getRowDimension($rows)->setRowHeight(-1);
                $rows++;
                // break;
            }
        }
        // die();

        // foreach ($sheet->getColumnIterator() as $column) {
        //     $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        // }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $name = time() . ".xlsx";
        $file = "assets/excel/$name";
        $writer->save($file);
        // header("Cache-Control: public"); // needed for internet explorer
        // // header("Content-Type: application/zip");
        // header("Content-Transfer-Encoding: Binary");
        // header("Content-Length:" . filesize($file));
        // header("Content-Disposition: attachment; filename=$name");
        // readfile($file);
        // die();
        echo json_encode(base_url($file));
    }

    public function export()
    {
        ini_set('memory_limit', '1000M');
        $SampleTimeModel = model("SampleTimeModel", false);
        $where = $SampleTimeModel->where("factory_id", session()->factory_id);

        $types = isset($_POST['types']) ? $_POST['types'] : [];
        $samples = isset($_POST['samples']) ? $_POST['samples'] : [];
        if (!empty($types)) {
            $where = $where->whereIn('type_id', $types);
        }
        if (!empty($samples)) {
            $where = $where->whereIn('sample_id', $samples);
        }
        $posts = $where->orderby("type_id", "ASC")->orderby("time", "ASC")->orderby("date_theory", "ASC")->asObject()->findAll();
        $SampleTimeModel->relation($posts, array("sample"));
        // echo "<pre>";
        // print_r($posts);
        // die();
        ///group
        // $r = $this->groupBy($posts, function ($item) {
        //     return $item->type_id;
        // });
        // echo "<pre>";
        // print_r($r);
        // die();
        $data_type = array();
        foreach ($posts as $post) {
            if (!array_key_exists($post->type_id, $data_type)) {
                $data_type[$post->type_id] = array();
            }
            if (!array_key_exists($post->time . "-" . $post->type_time,  $data_type[$post->type_id])) {
                $data_type[$post->type_id][$post->time . "-" . $post->type_time] = 0;
            }
            $data_type[$post->type_id][$post->time . "-" . $post->type_time]++;
        }
        // echo "<pre>";
        // print_r($data_type);
        // die();
        $file = APPPATH . '../assets/template/tongthe.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        // echo "<pre>";
        // print_r($reader);
        // die();
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
        $objRichText2->createText("KẾ HOẠCH NGHIÊN CỨU ĐỘ ỔN ĐỊNH TỔNG THỂ\n");
        $payable = $objRichText2->createTextRun("GENERAL PLANNING FOR STABILITY STUDY");
        $payable->getFont()->setItalic(true);
        $payable->getFont()->setBold(true);
        $payable->getFont()->setName("Times New Roman");
        $payable->getFont()->setSize("14");
        $sheet->getCell("A2")->setValue($objRichText2);
        ///HEADER
        $column = 10;
        foreach ($data_type as $key => $type) {
            $max = count($type);
            // echo $max . "<br>";
            $column_name = Coordinate::stringFromColumnIndex($column);
            // echo $column_name . "<br>";
            $num_column = $max * 4;
            // echo $column_name_end . "<br>";
            $sheet->insertNewColumnBefore($column_name, $num_column);


            $column_name_end = Coordinate::stringFromColumnIndex($column + $num_column - 1);
            $sheet->mergeCells($column_name . "4:" . $column_name_end . "4");
            switch ($key) {
                case 1:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Lão hóa\n");
                    $payable = $objRichText2->createTextRun("Accelerated\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("40°C ± 2°C/75% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;
                case 2:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Trung gian\n");
                    $payable = $objRichText2->createTextRun("Intermediate\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("30°C ± 2°C/65% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;

                case 3:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Dài hạn (ASEAN)\n");
                    $payable = $objRichText2->createTextRun("Long time (ASEAN)\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("30°C ± 2°C/75% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;

                case 4:
                    $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $objRichText2->createText("Dài hạn (EU)\n");
                    $payable = $objRichText2->createTextRun("Long time (EU)\n");
                    $payable->getFont()->setItalic(true);
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");

                    $payable = $objRichText2->createTextRun("25°C ± 2°C/60% ± 5% RH");
                    $payable->getFont()->setBold(true);
                    $payable->getFont()->setName("Times New Roman");
                    $payable->getFont()->setSize("10");
                    $sheet->getCell($column_name . "4")->setValue($objRichText2);
                    break;
            }

            $start_column = $column;
            foreach ($type as $key1 => $t) {
                $explode = explode("-", $key1);
                $time = $explode[0];
                $type_time = $explode[1];
                switch ($type_time) {
                    case "M":
                        $time_name = $time . " Tháng";
                        $time_name_en = $time . " Months";
                        break;
                    case "ư":
                        $time_name = $time . " Tuần";
                        $time_name_en = $time . " Weeks";
                        break;
                    case "d":
                        $time_name = $time . " Ngày";
                        $time_name_en = $time . " Days";
                        break;
                    case "y":
                        $time_name = $time . " Năm";
                        $time_name_en = $time . " Years";
                        break;
                }
                $data_type[$key][$key1] = $start_column;
                $column_name_1 = Coordinate::stringFromColumnIndex($start_column);
                $column_name_end_1 = Coordinate::stringFromColumnIndex($start_column + 4 - 1);
                $sheet->mergeCells($column_name_1 . "5:" . $column_name_end_1 . "5");

                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("$time_name\n");
                $payable = $objRichText2->createTextRun($time_name_en);
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(true);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_1 . "5")->setValue($objRichText2);


                $start_column_1 = $start_column;
                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Ngày lấy mẫu\n");
                $payable = $objRichText2->createTextRun("Sampling date");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(true);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;
                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Vị trí lưu mẫu\n");
                $payable = $objRichText2->createTextRun("Stored location");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(true);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;
                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Số mẫu cần lấy\n");
                $payable = $objRichText2->createTextRun("Sample quantity");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(true);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;
                $column_name_2 = Coordinate::stringFromColumnIndex($start_column_1);
                $objRichText2 = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $objRichText2->createText("Chỉ tiêu\n");
                $payable = $objRichText2->createTextRun("Tests");
                $payable->getFont()->setItalic(true);
                $payable->getFont()->setBold(true);
                $payable->getFont()->setName("Times New Roman");
                $payable->getFont()->setSize("10");
                $sheet->getCell($column_name_2 . "6")->setValue($objRichText2);
                $start_column_1++;


                $start_column = $start_column + 4;
            }



            $column = $column + $num_column;
        }

        $r = $this->groupBy($posts, function ($item) {
            return $item->sample_id;
        });
        $r = array_values($r);
        // echo "<pre>";
        // print_r($r);
        // die();
        if (!empty($r)) {
            $rows = 7;
            $sheet->insertNewRowBefore($rows + 1, count($r));
            $key = 0;

            foreach ($r as $post) {

                $sample = $post[0]->sample;
                if (!isset($sample->name))
                    continue;
                $sheet->setCellValueExplicit('A' . $rows, ++$key, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('B' . $rows, $sample->outline_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('C' . $rows, $sample->name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('D' . $rows, $sample->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValueExplicit('E' . $rows, $sample->code_batch, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $sheet->setCellValue('F' . $rows, $sample->date_manufacture != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($sample->date_manufacture) : "");
                $sheet->getStyle('F' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                $sheet->setCellValue('G' . $rows, $sample->date_storage != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($sample->date_storage) : "");
                $sheet->getStyle('G' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                $max_date = 0;
                $count = 0;
                foreach ($post as $time) {
                    if ($time->date_theory > $max_date)
                        $max_date = $time->date_theory;
                    $count += ($time->num_get ? (int) $time->num_get : 0);
                    $column = $data_type[$time->type_id][$time->time . "-" . $time->type_time];
                    // echo $column . "<br>";
                    // break;
                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($column_name . $rows, $time->date_theory != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($time->date_theory) : "");
                    $sheet->getStyle($column_name . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                    $column++;

                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValueExplicit($column_name . $rows, $time->location, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $column++;

                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($column_name . $rows, $time->num_get);
                    $column++;

                    $column_name = Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValueExplicit($column_name . $rows, $time->note, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $column++;
                }

                $sheet->setCellValue("H" . $rows, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($max_date));
                $sheet->getStyle('H' . $rows)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
                $sheet->setCellValue("I" . $rows, $count);

                $sheet->getRowDimension($rows)->setRowHeight(-1);
                $rows++;
                // break;
            }
        }
        // die();

        // foreach ($sheet->getColumnIterator() as $column) {
        //     $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        // }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $name = time() . ".xlsx";
        $file = "assets/excel/$name";
        $writer->save($file);
        // header("Cache-Control: public"); // needed for internet explorer
        // // header("Content-Type: application/zip");
        // header("Content-Transfer-Encoding: Binary");
        // header("Content-Length:" . filesize($file));
        // header("Content-Disposition: attachment; filename=$name");
        // readfile($file);
        // die();
        echo json_encode(base_url($file));
    }
    function groupBy($arr, $criteria): array
    {
        return array_reduce($arr, function ($accumulator, $item) use ($criteria) {
            $key = (is_callable($criteria)) ? $criteria($item) : $item[$criteria];
            if (!array_key_exists($key, $accumulator)) {
                $accumulator[$key] = [];
            }

            array_push($accumulator[$key], $item);
            return $accumulator;
        }, []);
    }
    function convertToWeeks($n, $type)
    {
        // Quy đổi về số ngày từ loại đơn vị
        switch ($type) {
            case 'w': // Tuần
                $days = $n * 7;
                break;
            case 'M': // Tháng
                $days = $n * 30.44; // Trung bình 1 tháng có 30.44 ngày
                break;
            case 'y': // Năm
                $days = $n * 365.25; // Trung bình 1 năm có 365.25 ngày (tính cả năm nhuận)
                break;
            case 'd': // Ngày
                $days = $n;
                break;
            default:
                $days = $n;
                break;
        }

        // Chuyển đổi từ ngày sang tuần
        $weeks = $days / 7;

        return $weeks;
    }
}
