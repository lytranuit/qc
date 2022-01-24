<?php

namespace App\Controllers;


class Qrcode extends BaseController
{
    function __construct()
    {
    }
    public function sample($code)
    {
        $SampleModel = model("SampleModel");
        $sample = $SampleModel->where('uuid', $code)->first();
        if (!empty($sample)) {
            return redirect()->to(base_url("admin/sample/edit/$sample->id"));
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang('Auth.notEnoughPrivilege'));
        }
    }
}
