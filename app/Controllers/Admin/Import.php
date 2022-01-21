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

        //Đường dẫn file
        $file = APPPATH . '../assets/up/FILE THEO DÕI CHO CÁC KHOẢNG THỬ NGHIỆM LINH GUI ANH TRAN.xlsx';

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
                $env_name = $row[13];
                $note = $row[14];

                if ($name != $prev_name || $code_batch != $prev_code_batch) {
                    $prev_name = $name;
                    $prev_code_batch = $code_batch;
                    $array = array(
                        // 'other' => $explode,
                        'code' => $code,
                        'outline_number' => $outline_number,
                        'code_research' => $code_research,
                        'code_analysis' => $code_analysis,
                        'name' => $name,
                        'code_batch' => $code_batch,
                        'date_manufacture' => $date_manufacture,
                        'date_storage' => $date_storage
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
                    'type_time' => $type_time
                );
                // print_r($array);

                $SampleTimeModel->insert($array);
            }
        }
    }
}
