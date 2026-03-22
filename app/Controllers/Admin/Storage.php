<?php

namespace App\Controllers\Admin;


class Storage extends BaseController
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
    {
        if (isset($_POST['dangtin'])) {
            if (!in_groups(array('admin', 'editor'))) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
            }
            $StorageModel = model("StorageModel");
            $data = $this->request->getPost();
            $data['factory_id'] = session()->factory_id;
            $obj = $StorageModel->create_object($data);
            $StorageModel->insert($obj);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $EnvTypeModel = model("EnvTypeModel");
            $this->data['list_env_type'] = $EnvTypeModel->asObject()->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function edit($id)
    {
        if (isset($_POST['dangtin'])) {

            $StorageModel = model("StorageModel");
            $data = $this->request->getPost();

            $obj_old = $StorageModel->where(array('id' => $id))->asArray()->first();
            $obj = $StorageModel->create_object($data);
            $StorageModel->update($id, $obj);

            $description = "User " . user()->name . " updated a Storage";
            $StorageModel->trail(1, 'update', $obj, $obj_old, $description);
            return redirect()->to(base_url('admin/' . $this->data['controller']));
        } else {
            $StorageModel = model("StorageModel");
            $tin = $StorageModel->where(array('id' => $id))->asObject()->first();
            $this->data['tin'] = $tin;
            $EnvTypeModel = model("EnvTypeModel");
            $this->data['list_env_type'] = $EnvTypeModel->asObject()->findAll();
            return view($this->data['content'], $this->data);
        }
    }

    public function remove($id)
    {
        $StorageModel = model("StorageModel");
        $StorageModel->delete($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function table()
    {
        $StorageModel = model("StorageModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $page = ($start / $limit) + 1;
        $where = $StorageModel->where("factory_id", session()->factory_id);

        $totalData = $where->countAllResults(false);
        $totalFiltered = $totalData;

        if (empty($search)) {
            // no filter
        } else {
            $where->like("name", $search);
            $totalFiltered = $where->countAllResults(false);
        }

        $posts = $where->asObject()->orderby("id", "DESC")->paginate($limit, '', $page);

        // Load env_type lookup
        $EnvTypeModel = model("EnvTypeModel");
        $envTypes = $EnvTypeModel->asObject()->findAll();
        $envTypeMap = [];
        foreach ($envTypes as $et) {
            $envTypeMap[$et->id] = $et->name;
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] =  '<a href="' . base_url("admin/" . $this->data['controller'] . "/edit/" . $post->id) . '"><i class="fas fa-pencil-alt mr-2"></i>' . $post->id . '</a>';
                $nestedData['name'] = '<a href="' . base_url("admin/" . $this->data['controller'] . "/edit/" . $post->id) . '">' . $post->name . '</a>';
                $nestedData['code'] = $post->code ?? '';
                $nestedData['env_type_name'] = isset($post->env_type) ? ($envTypeMap[$post->env_type] ?? '') : '';
                $nestedData['action'] = "";
                if (in_groups(array('admin', 'editor')))
                    $nestedData['action'] = '<div class="btn-group"><a href="' . base_url("admin/" . $this->data['controller'] . "/remove/" . $post->id) . '" class="btn btn-danger btn-sm" title="Xóa?" data-type="confirm">'
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
