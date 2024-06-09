<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        // echo 1;
        // die();
        return redirect()->to(base_url('admin'));
    }

    public function cron()
    {

        $SampleTimeModel = model("SampleTimeModel");
        $EmailSQLModel = model("EmailSQLModel");
        $query = $SampleTimeModel->where([
            'date_reality' => null,
            "date_theory >=" => date("Y-m-d"),
            "date_theory <=" => date("Y-m-d", strtotime("+1 day"))
        ]);
        // $sql = $query->builder();
        // echo 1;
        // echo "<pre>";
        // print_r($sql->getCompiledSelect());
        // die();
        $data = $query->asObject()->findAll();

        $SampleTimeModel->relation($data, ["sample"]);
        // echo "<pre>";
        // print_r($data);
        // die();
        foreach ($data as $row) {
            if (!isset($row->sample->emails) || $row->sample->emails == "") {
                continue;
            }
            $data1['data'] = $row;
            $data1['link'] = site_url("/admin/sample/edit/" . $row->sample->id);
            // echo "<pre>";
            // print_r($data1);
            // die();
            $message = view("backend/template/DueSampleTime", $data1);
            echo "<pre>";
            print_r($message);
            die();
            $id = $EmailSQLModel->insert(
                [
                    "email_to" => $row->sample->emails,
                    "subject" => "[Nhắc nhở] Lấy mẫu thời gian độ ổn định.",
                    "body" => $message,
                    "email_type" => "DueSampleTime",
                    "status" => 1
                ]
            );
        }
        // ((d.date_theory >= timecheck && d.date_theory <= timecheck1) || d.date_theory == timecheck5));
    }
}
