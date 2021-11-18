<?php

namespace App\Controllers\Admin;


class Env extends BaseController
{
    function __construct()
    {
        // $this->group = 'Status';
    }
    public function index()
    {
        return view($this->data['content'], $this->data);
    }
    public function get($id)
    {
        $EnvModel = model("EnvModel");
        $tin = $EnvModel->where(array('id' => $id))->asArray()->first();
        $EnvModel->relation($tin, array("time"));
        echo json_encode($tin);
    }
    public function add()
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {
            if (!in_groups(array('admin', 'editor'))) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
            }
            $EnvModel = model("EnvModel");
            $EnvTimeModel = model("EnvTimeModel");
            $data = $this->request->getPost();
            $obj = $EnvModel->create_object($data);
            $id = $EnvModel->insert($obj);

            if (isset($data['time'])) {
                foreach ($data['time'] as $key => $row) {
                    $array = array(
                        'time' => $row,
                        'type_time' => $data['type_time'][$key],
                        'based' => $data['based'][$key],
                        'env_id' => $id,
                    );

                    $obj = $EnvTimeModel->create_object($array);
                    $EnvTimeModel->insert($obj);
                }
            }

            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            //load_editor($this->data);
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    { /////// trang ca nhan
        if (isset($_POST['dangtin'])) {

            $EnvModel = model("EnvModel");
            $EnvTimeModel = model("EnvTimeModel");
            $data = $this->request->getPost();

            $obj_old = $EnvModel->where(array('id' => $id))->asArray()->first();
            $obj = $EnvModel->create_object($data);
            // print_r($obj);die();
            $EnvModel->update($id, $obj);


            $EnvTimeModel->where("env_id", $id)->delete();
            if (isset($data['time'])) {
                foreach ($data['time'] as $key => $row) {
                    $array = array(
                        'time' => $row,
                        'type_time' => $data['type_time'][$key],
                        'based' => $data['based'][$key],
                        'env_id' => $id,
                    );

                    $obj = $EnvTimeModel->create_object($array);
                    $EnvTimeModel->insert($obj);
                }
            }
            $description = "User " . user()->name . " updated a Env";
            $EnvModel->trail(1, 'update', $obj, $obj_old, $description);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $EnvModel = model("EnvModel");
            $tin = $EnvModel->where(array('id' => $id))->asObject()->first();
            $EnvModel->relation($tin, array("time"));
            // echo "<pre>";
            // print_r($tin);
            // die();
            $this->data['tin'] = $tin;
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    { /////// trang ca nhan
        $EnvModel = model("EnvModel");
        $EnvModel->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    public function table()
    {
        $EnvModel = model("EnvModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $page = ($start / $limit) + 1;
        $where = $EnvModel;
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
