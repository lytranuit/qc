<?php

namespace App\Controllers\Admin;

use App\Libraries\Ciqrcode;

class Import extends BaseController
{
    public function __construct()
    {
        if (!in_groups(array('admin'))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
        }
    }
    public function index()
    {
        return view($this->data['content'], $this->data);
    }
    public function linhqc()
    {
        die();
        //Đường dẫn file
        $file = APPPATH . '../assets/up/FILE THEO DÕI CHO CÁC KHOẢNG THỬ NGHIỆM LINH gửi anh Trân.xlsx';

        /** Load $inputFileName to a Spreadsheet Object  **/
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        // print_r($spreadsheet);
        // die();
        //Tiến hành xác thực file
        $objFile = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        $objData = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        // $objData->setReadDataOnly(true);
        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($file);
        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();
        //Chọn trang cần truy xuất
        // $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // //Lấy ra số dòng cuối cùng
        // $Totalrow = $sheet->getHighestRow();
        // //Lấy ra tên cột cuối cùng
        // $LastColumn = $sheet->getHighestColumn();
        // //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
        // $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        $count_sheet = $objPHPExcel->getSheetCount();
        // print_r($count_sheet);
        // die();
        for ($k = 0; $k < $count_sheet; $k++) {

            $sheet = $objPHPExcel->setActiveSheetIndex($k);
            $sheet_name = $sheet->getTitle();
            // if (strpos($sheet_name, "#") == false) continue;
            // print_r($sheet_name);die();
            //Lấy ra số dòng cuối cùng
            $Totalrow = $sheet->getHighestRow();
            //Lấy ra tên cột cuối cùng
            $LastColumn = $sheet->getHighestColumn();
            //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
            $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

            //Tạo mảng chứa dữ liệu
            $data = [];

            //Tiến hành lặp qua từng ô dữ liệu
            //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
            $row = 2;
            for ($i = $row; $i <= $Totalrow; $i++) {
                //----Lặp cột
                for ($j = 0; $j < $TotalCol; $j++) {
                    // Tiến hành lấy giá trị của từng ô đổ vào mảng
                    $cell = $sheet->getCellByColumnAndRow($j, $i);

                    $data[$i -  $row][$j] = $cell->getValue();
                    ///CHUYEN RICH TEXT
                    if ($data[$i -  $row][$j] instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                        $data[$i -  $row][$j] = $data[$i -  $row][$j]->getPlainText();
                    }

                    ////CHUYEN DATE 
                    // if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell) && $data[$i - 1][$j] > 0) {
                    //     if (is_numeric($data[$i - 1][$j])) {
                    //         $data[$i - 1][$j] =  $cell->getFormattedValue();
                    //     }
                    // }
                }
            }


            // echo "<pre>";
            // echo $sheet_name . "<br>";
            // print_r($data);
            // die();
            $SampleModel = model("SampleModel");
            $SampleTimeModel = model("SampleTimeModel");
            $prev_name = "";
            $prev_code_batch = "";
            $prev_env_name = "";
            foreach ($data as $row) {

                $name = $row[3];
                if ($name == "") continue;
                // $row[1] = trim($row[1]);
                // $explode =  explode(".", $row[1]);
                // if (count($explode) < 2) continue;

                // $version = $row[2];
                $outline_number = $row[2];
                $code_research = $row[4];
                $code = $row[5];
                $code_batch = $row[6];
                $code_analysis = $row[7];
                if (is_numeric($row[8])) {
                    $date_manufacture = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[8]));
                } else {
                    $date_manufacture = NULL;
                }
                if (is_numeric($row[9])) {
                    $date_storage = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[9]));
                } else {
                    $date_storage = NULL;
                }
                $time_text = $row[10];

                if (is_numeric($row[11])) {
                    $date_theory = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[11]));
                } else {
                    $date_theory = NULL;
                }

                if (is_numeric($row[12])) {
                    $date_reality = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[12]));
                } else {
                    $date_reality = NULL;
                }
                $env_name = trim($row[13]);
                $note = $row[14];
                $location_id = null;
                $location = null;
                $type_id = null;
                switch ($env_name) {
                    case "lão hóa cấp tốc":
                        $location_id = 4;
                        $location = "Tủ E5063";
                        $type_id = 1;
                        break;
                    case "dài hạn (ASEAN)":
                        $location_id = 1;
                        $location = "Phòng QC-45";
                        $type_id = 3;
                        break;
                    case "dài hạn (25 ̊C-60RH)":
                        $location_id = 2;
                        $location = "Tủ E5061";
                        $type_id = 4;
                        break;
                    case "Trung gian":
                        $location_id = 3;
                        $location = "Tủ E5062";
                        $type_id = 2;
                        break;
                }
                $factory_id = 1;

                if ($name != $prev_name || $code_batch != $prev_code_batch) {
                    $prev_name = $name;
                    $prev_code_batch = $code_batch;
                    $prev_env_name = $env_name;
                    $array = array(
                        // 'other' => $explode,
                        'code' => $code,
                        'outline_number' => $outline_number,
                        'code_research' => $code_research,
                        'code_analysis' => $code_analysis,
                        'name' => $name,
                        'code_batch' => $code_batch,
                        'date_manufacture' => $date_manufacture,
                        'date_storage' => $date_storage,
                        'factory_id' => $factory_id,
                        // 'location' => $location
                    );
                    // print_r($array);
                    $id = $SampleModel->insert($array);
                }
                $time_array = explode(" ", $time_text);
                switch (strtolower($time_array[1])) {
                    case "tuần":
                        $type_time = "w";
                        $type_time_text = "week";
                        break;
                    case "ngày":
                        $type_time = "d";
                        $type_time_text = "days";
                        break;
                    default:
                        $type_time = "M";
                        $type_time_text = "months";
                        break;
                }
                $time = $time_array[0];
                $based = "date_storage";
                if ($date_storage != "") {
                    $date_test = date("Y-m-d", strtotime($date_manufacture . " +$time $type_time_text"));
                    if ($date_test == $date_theory) {
                        $based = "date_manufacture";
                    }
                }
                $array = array(
                    'name' => $env_name,
                    'note' => $note,
                    'date_theory' => $date_theory,
                    'date_reality' => $date_reality,
                    'based' => $based,
                    'time' => $time,
                    'sample_id' => $id,
                    'type_time' => $type_time,
                    'factory_id' => $factory_id,
                    'type_id' => $type_id,
                    'location' => $location
                );
                // print_r($array);

                $SampleTimeModel->insert($array);
            }
        }
    }

    public function qca()
    {
        die();
        //Đường dẫn file
        $file = APPPATH . '../assets/up/LICH LAY MAU DOD NONBETA MN1.xlsx';

        /** Load $inputFileName to a Spreadsheet Object  **/
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        // print_r($spreadsheet);
        // die();
        //Tiến hành xác thực file
        $objFile = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        $objData = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        // $objData->setReadDataOnly(true);
        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($file);
        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();
        //Chọn trang cần truy xuất
        // $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // //Lấy ra số dòng cuối cùng
        // $Totalrow = $sheet->getHighestRow();
        // //Lấy ra tên cột cuối cùng
        // $LastColumn = $sheet->getHighestColumn();
        // //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
        // $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        $count_sheet = $objPHPExcel->getSheetCount();
        // print_r($count_sheet);
        // die();
        for ($k = 0; $k < $count_sheet; $k++) {

            $sheet = $objPHPExcel->setActiveSheetIndex($k);
            $sheet_name = $sheet->getTitle();
            // if (strpos($sheet_name, "#") == false) continue;
            // print_r($sheet_name);die();
            //Lấy ra số dòng cuối cùng
            $Totalrow = $sheet->getHighestRow();
            //Lấy ra tên cột cuối cùng
            $LastColumn = $sheet->getHighestColumn();
            //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
            $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

            //Tạo mảng chứa dữ liệu
            $data = [];

            //Tiến hành lặp qua từng ô dữ liệu
            //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
            $row = 3;
            for ($i = $row; $i <= $Totalrow; $i++) {
                //----Lặp cột
                for ($j = 0; $j < $TotalCol; $j++) {
                    // Tiến hành lấy giá trị của từng ô đổ vào mảng
                    $cell = $sheet->getCellByColumnAndRow($j, $i);

                    $data[$i -  $row][$j] = $cell->getValue();
                    ///CHUYEN RICH TEXT
                    if ($data[$i -  $row][$j] instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                        $data[$i -  $row][$j] = $data[$i -  $row][$j]->getPlainText();
                    }

                    ////CHUYEN DATE 
                    // if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell) && $data[$i - 1][$j] > 0) {
                    //     if (is_numeric($data[$i - 1][$j])) {
                    //         $data[$i - 1][$j] =  $cell->getFormattedValue();
                    //     }
                    // }
                }
            }


            // echo "<pre>";
            // echo $sheet_name . "<br>";
            // print_r($data);
            // die();
            $SampleModel = model("SampleModel");
            $SampleTimeModel = model("SampleTimeModel");
            $prev_name = "";
            $prev_code_batch = "";
            $prev_location = "";
            foreach ($data as $row) {

                $name = $row[2];
                $name_time = $row[3];
                if ($name == "" || $name_time == "") continue;
                // echo  $name . "<br>";
                // echo strrpos($name, "(");
                // die();
                $name = substr($name, 0, strrpos($name, "(",));
                // $row[1] = trim($row[1]);
                // $explode =  explode(".", $row[1]);
                // if (count($explode) < 2) continue;

                // $version = $row[2];
                $outline_number = $row[6];
                $code_research = $row[4];
                $code_analysis = null;
                $code = $row[5];
                $note = $row[15];
                $location = $row[10];
                $time_text = $row[11];
                $factory_id = 3;




                $code_batch = $name_time;
                $explode = explode("_", $name_time);
                $type = null;
                if (count($explode) > 1) {
                    $code_batch = $explode[0];
                    $type = $explode[1];
                } else {
                    $explode = explode("-", $name_time);
                    if (count($explode) > 1) {
                        $code_batch = $explode[0];
                        $type = $explode[1];
                    }
                }
                if ($type == null) continue;

                $l2 = substr($type, 0, 2);
                $l1 = $type[0];
                $type_id = null;
                switch ($l2) {
                    case "DE":
                        $type_id = 4;
                        break;
                    case "LH":
                        $type_id = 1;
                        break;
                    case "HN":
                        $type_id = 3;
                        break;
                    default:
                        if ($l1 == "D") {
                            $type_id = 3;
                        }
                        break;
                }
                if ($type_id == null) continue;
                // if (is_numeric($row[8])) {
                //     $date_manufacture = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[8]));
                // } else {
                $date_manufacture = NULL;
                // }
                if (is_numeric($row[8])) {
                    $date_storage = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[8]));
                } else {
                    $date_storage = NULL;
                }

                if (is_numeric($row[12])) {
                    $date_theory = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[12]));
                } else {
                    $date_theory = NULL;
                }

                if (is_numeric($row[13])) {
                    $date_reality = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[13]));
                } else {
                    $date_reality = NULL;
                }


                if ($name != $prev_name || $code_batch != $prev_code_batch) {
                    $prev_name = $name;
                    $prev_code_batch = $code_batch;
                    $prev_location = $location;
                    $array = array(
                        // 'other' => $explode,
                        'code' => $code,
                        'outline_number' => $outline_number,
                        'code_research' => $code_research,
                        'code_analysis' => $code_analysis,
                        'name' => $name,
                        'code_batch' => $code_batch,
                        'date_manufacture' => $date_manufacture,
                        'date_storage' => $date_storage,
                        'factory_id' => $factory_id,
                    );
                    // print_r($array);
                    $id = $SampleModel->insert($array);
                }
                $time_array = explode(" ", $time_text);
                $time = null;
                if (count($time_array) > 1 && is_numeric($time_array[0])) {
                    $time = $time_array[0];
                } else {
                    continue;
                }
                $type_time = "M";
                $based = "date_storage";
                $array = array(
                    'name' => $name_time,
                    'note' => $note,
                    'date_theory' => $date_theory,
                    'date_reality' => $date_reality,
                    'based' => $based,
                    'time' => $time,
                    'sample_id' => $id,
                    'type_time' => $type_time,
                    'factory_id' => $factory_id,
                    'type_id' => $type_id,
                    'location' => $location
                );
                // print_r($array);

                $SampleTimeModel->insert($array);
            }
        }
    }
    public function qcb()
    {
        die();
        //Đường dẫn file
        $file = APPPATH . '../assets/up/qcb.xlsx';

        /** Load $inputFileName to a Spreadsheet Object  **/
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        // print_r($spreadsheet);
        // die();
        //Tiến hành xác thực file
        $objFile = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        $objData = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        // $objData->setReadDataOnly(true);
        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($file);
        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();
        //Chọn trang cần truy xuất
        // $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // //Lấy ra số dòng cuối cùng
        // $Totalrow = $sheet->getHighestRow();
        // //Lấy ra tên cột cuối cùng
        // $LastColumn = $sheet->getHighestColumn();
        // //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
        // $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        $count_sheet = $objPHPExcel->getSheetCount();
        // print_r($count_sheet);
        // die();
        for ($k = 0; $k < $count_sheet; $k++) {

            $sheet = $objPHPExcel->setActiveSheetIndex($k);
            $sheet_name = $sheet->getTitle();
            // if (strpos($sheet_name, "#") == false) continue;
            // print_r($sheet_name);die();
            //Lấy ra số dòng cuối cùng
            $Totalrow = $sheet->getHighestRow();
            //Lấy ra tên cột cuối cùng
            $LastColumn = $sheet->getHighestColumn();
            //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
            $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

            //Tạo mảng chứa dữ liệu
            $data = [];

            //Tiến hành lặp qua từng ô dữ liệu
            //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
            $row = 6;
            for ($i = $row; $i <= $Totalrow; $i++) {
                //----Lặp cột
                for ($j = 0; $j < $TotalCol; $j++) {
                    // Tiến hành lấy giá trị của từng ô đổ vào mảng
                    $cell = $sheet->getCellByColumnAndRow($j, $i);

                    $data[$i -  $row][$j] = $cell->getValue();
                    ///CHUYEN RICH TEXT
                    if ($data[$i -  $row][$j] instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                        $data[$i -  $row][$j] = $data[$i -  $row][$j]->getPlainText();
                    }
                    ////CHUYEN DATE 
                    // if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell) && $data[$i - 1][$j] > 0) {
                    //     if (is_numeric($data[$i - 1][$j])) {
                    //         $data[$i - 1][$j] =  $cell->getFormattedValue();
                    //     }
                    // }
                }
            }


            // echo "<pre>";
            // echo $sheet_name . "<br>";
            // print_r($data);
            // die();
            $SampleModel = model("SampleModel");
            $SampleTimeModel = model("SampleTimeModel");
            $prev_name = "";
            $prev_code_batch = "";
            $prev_type_id = "";
            foreach ($data as $row) {

                $name = $row[2];
                $name_time = $row[7];
                if ($name == "" || $name_time == "") continue;
                // $row[1] = trim($row[1]);
                // $explode =  explode(".", $row[1]);
                // if (count($explode) < 2) continue;

                // $version = $row[2];
                $outline_number = $row[5];
                if ($outline_number == '=IF(#REF!<>"",#REF!,"")')
                    $outline_number = "";
                $code_research = $row[3];
                $code_analysis = $row[11];
                $code = $row[4];
                $note = $row[15];
                $location = $row[10];
                $time_text = $row[12];
                $factory_id = 2;




                $code_batch = $name_time;
                $explode = explode("_", $name_time);
                $type = null;
                if (count($explode) > 1) {
                    $code_batch = $explode[0];
                    $type = $explode[1];
                } else {
                    $explode = explode("-", $name_time);
                    if (count($explode) > 1) {
                        $code_batch = $explode[0];
                        $type = $explode[1];
                    }
                }
                if ($type == null) continue;

                $l2 = substr($type, 0, 2);
                $l1 = $type[0];
                $type_id = null;
                switch ($l2) {
                    case "DE":
                        $type_id = 4;
                        break;
                    case "LH":
                        $type_id = 1;
                        break;
                    case "HN":
                        $type_id = 3;
                        break;
                    default:
                        if ($l1 == "D") {
                            $type_id = 3;
                        }
                        break;
                }
                if ($type_id == null) continue;
                // if (is_numeric($row[8])) {
                //     $date_manufacture = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[8]));
                // } else {
                $date_manufacture = NULL;
                // }
                if (is_numeric($row[8])) {
                    $date_storage = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[8]));
                } else {
                    $date_storage = NULL;
                }

                if (is_numeric($row[13])) {
                    $date_theory = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[13]));
                } else {
                    $date_theory = NULL;
                }

                if (is_numeric($row[14])) {
                    $date_reality = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[14]));
                } else {
                    $date_reality = NULL;
                }
                if ($date_storage == null) continue;

                if ($name != $prev_name || $code_batch != $prev_code_batch) {
                    $prev_name = $name;
                    $prev_code_batch = $code_batch;
                    $prev_type_id = $type_id;
                    $array = array(
                        // 'other' => $explode,
                        'code' => $code,
                        'outline_number' => $outline_number,
                        'code_research' => $code_research,
                        'code_analysis' => $code_analysis,
                        'name' => $name,
                        'code_batch' => $code_batch,
                        'date_manufacture' => $date_manufacture,
                        'date_storage' => $date_storage,
                        'factory_id' => $factory_id
                    );
                    // print_r($array);
                    $id = $SampleModel->insert($array);
                }
                $time_array = explode(" ", $time_text);
                $time = null;
                if (count($time_array) > 1 && is_numeric($time_array[0])) {
                    $time = $time_array[0];
                } else {
                    continue;
                }
                $type_time = "M";
                $based = "date_storage";
                $array = array(
                    'name' => $name_time,
                    'note' => $note,
                    'date_theory' => $date_theory,
                    'date_reality' => $date_reality,
                    'based' => $based,
                    'time' => $time,
                    'sample_id' => $id,
                    'type_time' => $type_time,
                    'factory_id' => $factory_id,
                    'type_id' => $type_id,
                    'location' => $location
                );
                // print_r($array);

                $SampleTimeModel->insert($array);
            }
        }
    }
    public function tramqcb()
    {
        die();
        //Đường dẫn file
        $file = APPPATH . '../assets/up/tong the qcb.xlsx';

        /** Load $inputFileName to a Spreadsheet Object  **/
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        // print_r($spreadsheet);
        // die();
        //Tiến hành xác thực file
        $objFile = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        $objData = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        // $objData->setReadDataOnly(true);
        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($file);
        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();
        //Chọn trang cần truy xuất
        // $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // //Lấy ra số dòng cuối cùng
        // $Totalrow = $sheet->getHighestRow();
        // //Lấy ra tên cột cuối cùng
        // $LastColumn = $sheet->getHighestColumn();
        // //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
        // $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        $count_sheet = $objPHPExcel->getSheetCount();
        // print_r($count_sheet);
        // die();
        for ($k = 0; $k < $count_sheet; $k++) {

            $sheet = $objPHPExcel->setActiveSheetIndex($k);
            $sheet_name = $sheet->getTitle();
            // if (strpos($sheet_name, "#") == false) continue;
            // print_r($sheet_name);die();
            //Lấy ra số dòng cuối cùng
            $Totalrow = $sheet->getHighestRow();
            //Lấy ra tên cột cuối cùng
            $LastColumn = $sheet->getHighestColumn();
            //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
            $TotalCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($LastColumn);

            //Tạo mảng chứa dữ liệu
            $data = [];

            //Tiến hành lặp qua từng ô dữ liệu
            //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
            $row = 2;
            for ($i = $row; $i <= $Totalrow; $i++) {
                //----Lặp cột
                for ($j = 0; $j < $TotalCol; $j++) {
                    // Tiến hành lấy giá trị của từng ô đổ vào mảng
                    $cell = $sheet->getCellByColumnAndRow($j, $i);

                    $data[$i -  $row][$j] = $cell->getValue();
                    ///CHUYEN RICH TEXT
                    if ($data[$i -  $row][$j] instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
                        $data[$i -  $row][$j] = $data[$i -  $row][$j]->getPlainText();
                    }

                    ////CHUYEN DATE 
                    // if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell) && $data[$i - 1][$j] > 0) {
                    //     if (is_numeric($data[$i - 1][$j])) {
                    //         $data[$i - 1][$j] =  $cell->getFormattedValue();
                    //     }
                    // }
                }
            }


            // echo "<pre>";
            // echo $sheet_name . "<br>";
            // print_r($data);
            // die();
            $SampleModel = model("SampleModel");
            $SampleTimeModel = model("SampleTimeModel");
            $SampleModel->where("factory_id", 2)->delete();
            $SampleTimeModel->where("factory_id", 2)->delete();
            $prev_name = "";
            $prev_code_batch = "";
            $prev_env_name = "";
            foreach ($data as $row) {

                $name = $row[2];
                if ($name == "") continue;
                // $row[1] = trim($row[1]);
                // $explode =  explode(".", $row[1]);
                // if (count($explode) < 2) continue;

                // $version = $row[2];
                $outline_number = $row[9];
                $code_research = $row[7];
                $code = $row[8];
                $code_batch = $row[4];
                $code_analysis = null;
                if (is_numeric($row[12])) {
                    $date_manufacture = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[12]));
                } else {
                    $date_manufacture = NULL;
                }
                if (is_numeric($row[11])) {
                    $date_storage = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[11]));
                } else {
                    $date_storage = NULL;
                }
                $time_text = $row[15];

                if (is_numeric($row[16])) {
                    $date_theory = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[16]));
                } else {
                    $date_theory = NULL;
                }

                // if (is_numeric($row[12])) {
                //     $date_reality = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row[12]));
                // } else {
                $date_reality = NULL;
                // }
                $env_code = $row[3];
                $env_name = trim($row[5]);
                $note = $row[17];
                $num_get = $row[6];
                $num_get = explode(" ", $num_get);
                $num_get = $num_get[0];
                $location =  $row[14];
                $type_id = null;
                switch ($env_name) {
                    case "Điều kiện lão hóa":
                        $type_id = 1;
                        break;
                    case "Dài hạn ASEAN":
                        $type_id = 3;
                        break;
                    case "Dài hạn EU":
                        $type_id = 4;
                        break;
                }
                $factory_id = 2;

                if ($name != $prev_name || $code_batch != $prev_code_batch) {
                    $prev_name = $name;
                    $prev_code_batch = $code_batch;
                    $prev_env_name = $env_name;
                    $array = array(
                        // 'other' => $explode,
                        'code' => $code,
                        'outline_number' => $outline_number,
                        'code_research' => $code_research,
                        'code_analysis' => $code_analysis,
                        'name' => $name,
                        'code_batch' => $code_batch,
                        'date_manufacture' => $date_manufacture,
                        'date_storage' => $date_storage,
                        'factory_id' => $factory_id,
                        // 'location' => $location
                    );
                    // print_r($array);
                    $id = $SampleModel->insert($array);
                }
                $time_array = explode(" ", $time_text);
                $type_time = "M";
                $type_time_text = "months";
                $time = $time_array[0];
                $based = "date_storage";
                if ($date_storage != "") {
                    $date_test = date("Y-m-d", strtotime($date_manufacture . " +$time $type_time_text"));
                    if ($date_test == $date_theory) {
                        $based = "date_manufacture";
                    }
                }
                $array = array(
                    'name' => $env_code,
                    'note' => $note,
                    'date_theory' => $date_theory,
                    'date_reality' => $date_reality,
                    'based' => $based,
                    'time' => $time,
                    'sample_id' => $id,
                    'type_time' => $type_time,
                    'factory_id' => $factory_id,
                    'type_id' => $type_id,
                    'num_get' => $num_get,
                    'location' => $location
                );
                // print_r($array);

                $SampleTimeModel->insert($array);
            }
        }
    }
    public function edit211222()
    {
        $SampleModel = model("SampleModel");
        $SampleTimeModel = model("SampleTimeModel");
        $db = db_connect();
        $query = $db->query("SELECT m1.*
        FROM sample_time m1 LEFT JOIN sample_time m2
         ON (m1.sample_id = m2.sample_id AND m1.type_id = m2.type_id AND m1.time < m2.time)
        WHERE m2.id IS NULL AND m1.type_id IN(3,4) AND m1.date_reality IS NULL AND m1.date_theory > NOW()");
        $results = $query->getResult();
        foreach ($results as $row) {
            $id = $row->id;
            $based = $row->based;
            $sample_id = $row->sample_id;
            $time = $row->time;
            $type_time = $row->type_time;
            if ($row->based == 'custom')
                continue;

            $sample = $SampleModel->where(array('id' => $sample_id))->asObject()->first();
            if (!$sample) {
                continue;
            }
            // var_dump($sample);
            // die();
            if ($based == 'date_manufacture') {
                $date = $sample->date_manufacture;
            } elseif ($based == 'date_storage') {
                $date = $sample->date_storage;
            }
            switch ($type_time) {
                case "w":
                    $type_time_text = "week";
                    break;
                case "d":
                    $type_time_text = "days";
                    break;
                default:
                    $type_time_text = "months";
                    break;
            }
            $date_test = date("Y-m-d", strtotime($date . " +$time $type_time_text"));
            $date_theory = date("Y-m-01", strtotime($date_test . " +1 months"));

            $SampleTimeModel->update($id, array('based' => 'custom', 'date_theory' => $date_theory));
        }
    }
}
