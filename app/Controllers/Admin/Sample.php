<?php

namespace App\Controllers\Admin;


class Sample extends BaseController
{
    function __construct()
    {
        // $this->group = 'Status';
    }
    public function index()
    {
        return view($this->data['content'], $this->data);
    }
    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            if (!in_groups(array('admin', 'editor'))) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
            }
            $SampleModel = model("SampleModel");
            $SampleTimeModel = model("SampleTimeModel");

            $data = $this->request->getPost();
            $factory_id = session()->factory_id;
            $data['factory_id'] = $factory_id;
            $obj = $SampleModel->create_object($data);
            $id = $SampleModel->insert($obj);

            $location_id = $data['location_id'];
            if (isset($data['time'])) {
                if (isset($data['time']['insert'])) {
                    foreach ($data['time']['insert']['name'] as $key => $row) {
                        $array = array(
                            'name' => $row,
                            'time' => $data['time']['insert']['time'][$key],
                            'type_time' => $data['time']['insert']['type_time'][$key],
                            'based' => $data['time']['insert']['based'][$key],
                            'date_theory' => $data['time']['insert']['date_theory'][$key],
                            'date_reality' => $data['time']['insert']['date_reality'][$key],
                            'note' => $data['time']['insert']['note'][$key],
                            'sample_id' => $id,
                            'factory_id' => $factory_id,
                            'location_id' => $location_id
                        );
                        $obj = $SampleTimeModel->create_object($array);
                        $SampleTimeModel->insert($obj);
                    }
                }
            }
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            //load_editor($this->data);

            $EnvModel = model("EnvModel");
            $envs = $EnvModel->asObject()->findAll();
            $EnvModel->relation($envs, array("time"));

            $this->data['envs'] = $envs;

            $LocationModel = model("LocationModel");
            $location = $LocationModel->where("factory_id", session()->factory_id)->asObject()->findAll();

            $this->data['location'] = $location;
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $SampleModel = model("SampleModel");
            $SampleTimeModel = model("SampleTimeModel");
            $data = $this->request->getPost();

            $obj_old = $SampleModel->where(array('id' => $id))->asArray()->first();
            $obj = $SampleModel->create_object($data);
            // print_r($obj);die();
            $SampleModel->update($id, $obj);

            $factory_id = session()->factory_id;
            $location_id = $data['location_id'];
            if (isset($data['time'])) {
                // echo "<pre>";
                // print_r($data['time']);
                // die();
                ///ADD
                if (isset($data['time']['insert'])) {
                    foreach ($data['time']['insert']['name'] as $key => $row) {
                        $array = array(
                            'name' => $row,
                            'time' => $data['time']['insert']['time'][$key],
                            'type_time' => $data['time']['insert']['type_time'][$key],
                            'based' => $data['time']['insert']['based'][$key],
                            'date_theory' => $data['time']['insert']['date_theory'][$key],
                            'date_reality' => $data['time']['insert']['date_reality'][$key],
                            'note' => $data['time']['insert']['note'][$key],
                            'sample_id' => $id,
                            'factory_id' => $factory_id,
                            'location_id' => $location_id
                        );
                        $obj = $SampleTimeModel->create_object($array);
                        $SampleTimeModel->insert($obj);
                    }
                }
                ///UPDATE
                if (isset($data['time']['update'])) {
                    foreach ($data['time']['update']['id'] as $key => $row) {
                        $array = array(
                            'name' => $data['time']['update']['name'][$key],
                            'time' => $data['time']['update']['time'][$key],
                            'type_time' => $data['time']['update']['type_time'][$key],
                            'based' => $data['time']['update']['based'][$key],
                            'date_theory' => $data['time']['update']['date_theory'][$key],
                            'date_reality' => $data['time']['update']['date_reality'][$key],
                            'note' => $data['time']['update']['note'][$key],
                            'sample_id' => $id,
                            'factory_id' => $factory_id,
                            'location_id' => $location_id
                        );
                        $obj = $SampleTimeModel->create_object($array);
                        $SampleTimeModel->update($row, $obj);
                    }
                }
                ///DELETE
                if (isset($data['time']['delete'])) {
                    foreach ($data['time']['delete'] as $id) {
                        $SampleTimeModel->delete($id);
                    }
                }
            }
            $description = "User " . user()->name . " updated a Sample";
            $SampleModel->trail(1, 'update', $obj, $obj_old, $description);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $SampleModel = model("SampleModel");
            $EnvModel = model("EnvModel");
            $tin = $SampleModel->where(array('id' => $id))->asObject()->first();

            $SampleModel->relation($tin, array("time"));
            $this->data['tin'] = $tin;



            $envs = $EnvModel->asObject()->findAll();
            $EnvModel->relation($envs, array("time"));
            // print_r($envs);

            $this->data['envs'] = $envs;

            $LocationModel = model("LocationModel");
            $location = $LocationModel->where("factory_id", session()->factory_id)->asObject()->findAll();

            $this->data['location'] = $location;
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $SampleModel = model("SampleModel");
        $SampleModel->delete($id);

        $SampleTimeModel = model("SampleTimeModel");
        $SampleTimeModel->where("sample_id", $id)->delete();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public function table()
    {
        $SampleModel = model("SampleModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $orders = $this->request->getVar('order');
        $page = ($start / $limit) + 1;
        $where = $SampleModel->where("factory_id", session()->factory_id);
        // echo "<pre>";
        // print_r($where);
        $totalData = $where->countAllResults(false);

        //echo "<pre>";
        //print_r($totalData);
        //die();
        $totalFiltered = $totalData;

        if (empty($search)) {
            // $where = $Document_model;
            // echo "1";die();
        } else {
            $where->like("name", $search);
            $totalFiltered = $where->countAllResults(false);
        }
        if (isset($orders)) {
            foreach ($orders as $order) {
                $data = $order['data'];
                $dir = $order['dir'];
                switch ($data) {
                    default:
                        $where->orderby($data, $dir);
                        break;
                    case 'status':
                        $where->orderby('status_id', $dir);
                        break;
                    case 'type':
                        $where->orderby('type_id', $dir);
                        break;
                }
            }
        }
        // $where = $Document_model;
        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);

        // echo "<pre>";
        // print_r($posts);
        // die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] =  '<a href="' . base_url("admin/" . $this->data['controller'] . "/edit/" . $post->id) . '"><i class="fas fa-pencil-alt mr-2"></i>' . $post->id . '</a>';
                $nestedData['name'] = '<a href="' . base_url("admin/" . $this->data['controller'] . "/edit/" . $post->id) . '">' . $post->name . '</a>';
                $nestedData['code'] = $post->code;
                $nestedData['code_research'] = $post->code_research;
                $nestedData['outline_number'] = $post->outline_number;
                $nestedData['code_batch'] = $post->code_batch;
                $nestedData['code_analysis'] = $post->code_analysis;

                $nestedData['date_manufacture'] = date("d/m/Y", strtotime($post->date_manufacture));
                $nestedData['date_storage'] = date("d/m/Y", strtotime($post->date_storage));

                $nestedData['action'] = "";
                if (in_groups(array('admin', 'editor')))
                    $nestedData['action'] = '<div class="btn-group"><a href="' . base_url("admin/" . $this->data['controller'] . "/remove/" . $post->id) . '" class="btn btn-danger btn-sm" title="Xóa tài liệu?" data-type="confirm">'
                        . '<i class="fas fa-trash-alt">'
                        . '</i>'
                        . '</a></div>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getVar('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    public function exportexcel()
    {
        $SampleModel = model("SampleModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $page = ($start / $limit) + 1;
        $where = $SampleModel;


        if (empty($search)) {
            // $where = $Document_model;
            // echo "1";die();
        } else {
            $where->like("name", $search);
        }

        // $where = $Document_model;
        $posts = $where->orderby("id", "ASC")->asObject()->findAll();
        $SampleModel->relation($posts, array("time", "location"));
        // echo "<pre>";
        // print_r($posts);
        // die();
        $file = APPPATH . '../assets/template/template.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        // echo "<pre>";
        // print_r($reader);
        // die();
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        if (!empty($posts)) {
            $rows = 2;
            $key = 0;
            foreach ($posts as $post) {
                $sheet->insertNewRowBefore($rows + 1, 1);
                $sheet->getStyle("A$rows:N$rows")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('858687');
                $rows++;
                if (isset($post->time)) {
                    $sheet->insertNewRowBefore($rows + 1, count($post->time));
                    foreach ($post->time as $time) {
                        $sheet->setCellValue('A' . $rows, ++$key);
                        $sheet->setCellValue('B' . $rows, $post->code);
                        $sheet->setCellValue('C' . $rows, $post->name);
                        $sheet->setCellValue('D' . $rows, $post->code_research);
                        $sheet->setCellValue('E' . $rows, $post->code);
                        $sheet->setCellValue('F' . $rows, $post->code_batch);
                        $sheet->setCellValue('G' . $rows, $post->code_analysis);
                        $sheet->setCellValue('H' . $rows, $post->date_manufacture != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($post->date_manufacture) : "");
                        $sheet->setCellValue('I' . $rows, $post->date_storage != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($post->date_storage) : "");
                        $sheet->setCellValue('J' . $rows, $time->time . " " . ($time->type_time == "M" ? "Tháng" : ($time->type_time == "d" ? "Ngày" : ($time->type_time == "w" ? "Tuần" : ($time->type_time == "y" ? "Năm" : "")))));
                        $sheet->setCellValue('K' . $rows, $time->date_theory != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($time->date_theory) : "");
                        $sheet->setCellValue('L' . $rows, $time->date_reality != "" ? \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($time->date_reality) : "");
                        $sheet->setCellValue('M' . $rows, $time->name);
                        $sheet->setCellValue('N' . $rows, $time->note);
                        $sheet->setCellValue('P' . $rows, isset($post->locaiton->name) ? $post->locaiton->name : "");

                        $sheet->getStyle('H' . $rows)->getNumberFormat()->setFormatCode("yyyy/mm/dd");
                        $sheet->getStyle('I' . $rows)->getNumberFormat()->setFormatCode("yyyy/mm/dd");
                        $sheet->getStyle('K' . $rows)->getNumberFormat()->setFormatCode("yyyy/mm/dd");
                        $sheet->getStyle('L' . $rows)->getNumberFormat()->setFormatCode("yyyy/mm/dd");

                        $rows++;
                    }
                }
            }
        }
        $sheet->getRowDimension(1)->setRowHeight(-1);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file = "assets/excel/" . time() . ".xlsx";
        $writer->save($file);
        echo json_encode(base_url($file));
    }
    public function take()
    {
        if (isset($_POST['dangtin'])) {

            $SampleTimeModel = model("SampleTimeModel");
            $data = $this->request->getPost();
            $sample_time_id  = $data['sample_time_id'];
            $sample_id  = $data['id'];
            unset($data['id']);
            if ($sample_time_id > 0) {

                $obj = $SampleTimeModel->create_object($data);
                $SampleTimeModel->update($sample_time_id, $obj);
                $description = "User " . user()->name . " take a Sample";
                $SampleTimeModel->trail(1, 'update', $obj, array(), $description);
                return redirect()->to(base_url('admin/' . $this->data['controller'] . "/edit/" . $sample_id));
            } else {
                return redirect()->to(base_url('admin/' . $this->data['controller']));
            }
        } else {
            $LocationModel = model("LocationModel");
            $location = $LocationModel->where("factory_id", session()->factory_id)->asObject()->findAll();

            $this->data['location'] = $location;
            return view($this->data['content'], $this->data);
        }
    }
    public function gettime($uuid)
    {
        $SampleModel = model("SampleModel");
        $SampleTimeModel = model("SampleTimeModel");
        $sample = $SampleModel->where('uuid', $uuid)->asArray()->first();
        if (!empty($sample)) {
            $id = $sample['id'];
            $time = $SampleTimeModel->where("sample_id = $id AND date_reality IS NULL AND CURDATE() BETWEEN DATE_SUB(date_theory, INTERVAL 7 DAY) AND DATE_ADD(date_theory, INTERVAL 7 DAY)")->asArray()->first();
            if (!empty($time)) {
                $sample['env_name'] = $time['name'];
                $sample['date_theory'] = $time['date_theory'];
                $sample['date_reality'] = date("Y-m-d");
                $sample['sample_time_id'] = $time['id'];
                $sample['time'] = $time['time'] . " " . ($time['type_time'] == "M" ? "Tháng" : ($time['type_time'] == "d" ? "Ngày" : ($time['type_time'] == "w" ? "Tuần" : ($time['type_time'] == "y" ? "Năm" : ""))));
                echo json_encode(array("success" => 1, "msg" => $sample));
            } else {
                echo json_encode(array("success" => 0, "msg" => "Đã lấy mẫu hoặc chưa đến hạn lấy mẫu"));
            }
            // return redirect()->to(base_url("admin/sample/edit/$sample->id"));
        } else {
            echo json_encode(array("success" => 0, "msg" => "Không tìm thấy mẫu!"));
        }
    }
}
