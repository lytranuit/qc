<?php

namespace App\Controllers\Admin;


class Settings extends BaseController
{

    public function __construct()
    {
        if (!in_groups(array('admin'))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
        }
    }
    public function index()
    {
        if (isset($_POST['post'])) {
            $data = $_POST;
            $option_model = model("OptionModel");

            foreach ($data['id'] as $key => $id) {
                $value = isset($data["value$id"]) ? $data["value$id"] : null;
                $option_model->update($id, array('value' => $value));
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            $option_model = model("OptionModel");

            $this->data['mail'] = $option_model->where("group", 'mail')->orderBy("order", "asc")->findAll();;

            return view($this->data['content'], $this->data);
        }
    }
}
