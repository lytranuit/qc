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
            $obj = $SampleModel->create_object($data);
            $id = $SampleModel->insert($obj);

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
            // print_r($envs);

            $this->data['envs'] = $envs;
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
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $SampleModel = model("SampleModel");
        $SampleModel->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public function table()
    {
        $SampleModel = model("SampleModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $page = ($start / $limit) + 1;
        $where = $SampleModel;
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
}
