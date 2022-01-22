<?php

namespace App\Controllers\Admin;


class Home extends BaseController
{
    public function index()
    {

        $SampleModel = model("SampleModel");
        $SampleTimeModel = model("SampleTimeModel");

        $this->data['num_product'] = $SampleModel->countAllResults();
        $this->data['num_sample'] = $SampleTimeModel->countAllResults();
        $this->data['num_sample_incomplete'] = $SampleTimeModel->where("date_reality", NULL)->countAllResults();
        $this->data['num_sample_complete'] = $SampleTimeModel->where("date_reality !=", NULL)->countAllResults();
        $this->data['num_sample_expire'] = $SampleTimeModel->where("date_reality", NULL)->where("date_theory < ", date("Y-m-d"))->countAllResults();

        return view($this->data['content'], $this->data);
    }
    public function table()
    {
        $SampleModel = model("SampleModel", false);
        // $SampleTimeModel = model("SampleTimeModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $type = $this->request->getVar('type');
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $page = ($start / $limit) + 1;
        $where = $SampleModel->join("sample_time", "sample.id = sample_time.sample_id")->select("*,sample.name as name_sample");
        switch ($type) {
            case "w":
                $where = $where->where("YEARWEEK(`date_theory`, 1) = YEARWEEK(CURDATE())");
                break;
            case "M":
                $where = $where->where("MONTH(`date_theory`) = MONTH(CURRENT_DATE()) AND YEAR(`date_theory`) = YEAR(CURRENT_DATE())");
                break;
            case "d":
                $where = $where->where("date_theory = CURRENT_DATE()");
                break;
            default:
                $where = $where->where("date_theory BETWEEN '$startDate' AND '$endDate'");
                break;
        }
        // echo "<pre>";
        // print_r($rows);
        // die();
        // $list_sample = [];
        // $list = [];
        // foreach ($rows as $row) {
        //     $list_sample[] = $row['sample_id'];
        //     $list[$row['sample_id']] = $row['date_theory'];
        // }
        // if (!empty($list_sample)) {
        //     $where->whereIn("id", $list_sample);
        // } else {
        //     $where->where("0=1");
        // }
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
            $where->like("sample.name", $search);
            $totalFiltered = $where->countAllResults(false);
        }

        // $where = $Document_model;
        $posts = $where->asObject()->orderby("date_theory", "DESC")->paginate($limit, '', $page);

        // echo "<pre>";
        // print_r($posts);
        // die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] =  '<a href="' . base_url("admin/sample/edit/" . $post->sample_id) . '"><i class="fas fa-pencil-alt mr-2"></i>' . $post->sample_id . '</a>';
                $nestedData['name'] = '<a href="' . base_url("admin/sample/edit/" . $post->sample_id) . '">' . $post->name_sample . '</a>';
                $nestedData['code'] = $post->code;
                $nestedData['code_research'] = $post->code_research;
                $nestedData['outline_number'] = $post->outline_number;
                $nestedData['code_batch'] = $post->code_batch;
                $nestedData['code_analysis'] = $post->code_analysis;
                $nestedData['date_manufacture'] = $post->date_manufacture;
                $nestedData['date_storage'] = $post->date_storage;
                $nestedData['date_theory'] = $post->date_theory;
                $nestedData['env'] = $post->name;
                $nestedData['time'] = $post->time . " " . ($post->type_time == "M" ? "Tháng" : ($post->type_time == "d" ? "Ngày" : ($post->type_time == "w" ? "Tuần" : ($post->type_time == "y" ? "Năm" : ""))));
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
    public function table1()
    {
        $SampleModel = model("SampleModel", false);
        // $SampleTimeModel = model("SampleTimeModel", false);
        $limit = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $search = $this->request->getPost('search')['value'];
        $page = ($start / $limit) + 1;
        $where = $SampleModel->join("sample_time", "sample.id = sample_time.sample_id")->select("*,sample.name as name_sample");
        $rows = $where->where("(date_reality IS NULL OR date_reality = '0000-00-00') AND date_theory < CURDATE()");
        // echo "<pre>";
        // print_r($rows);
        // die();
        // $list_sample = [];
        // $list = [];
        // foreach ($rows as $row) {
        //     $list_sample[] = $row['sample_id'];
        //     $list[$row['sample_id']] = $row['date_theory'];
        // }
        // if (!empty($list_sample)) {
        //     $where->whereIn("id", $list_sample);
        // } else {
        //     $where->where("0=1");
        // }
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
            $where->like("sample.name", $search);
            $totalFiltered = $where->countAllResults(false);
        }

        // $where = $Document_model;
        $posts = $where->asObject()->orderby("date_theory", "DESC")->paginate($limit, '', $page);

        // echo "<pre>";
        // print_r($posts);
        // die();
        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['id'] =  '<a href="' . base_url("admin/sample/edit/" . $post->sample_id) . '"><i class="fas fa-pencil-alt mr-2"></i>' . $post->sample_id . '</a>';
                $nestedData['name'] = '<a href="' . base_url("admin/sample/edit/" . $post->sample_id) . '">' . $post->name_sample . '</a>';
                $nestedData['code'] = $post->code;
                $nestedData['code_research'] = $post->code_research;
                $nestedData['outline_number'] = $post->outline_number;
                $nestedData['code_batch'] = $post->code_batch;
                $nestedData['code_analysis'] = $post->code_analysis;
                $nestedData['date_manufacture'] = $post->date_manufacture;
                $nestedData['date_storage'] = $post->date_storage;
                $nestedData['date_theory'] = $post->date_theory;
                $nestedData['env'] = $post->name;
                $nestedData['time'] = $post->time . " " . ($post->type_time == "M" ? "Tháng" : ($post->type_time == "d" ? "Ngày" : ($post->type_time == "w" ? "Tuần" : ($post->type_time == "y" ? "Năm" : ""))));
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
    public function listqrcode()
    {

        $Document_model = model("DocumentModel");
        $documents = $Document_model->findAll();

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        $styleCell =
            [
                'borderColor' => 'ffffff',
                'borderSize' => 6,
            ];
        $table = $section->addTable(array('borderSize' => 0, 'cellMargin'  => 80, 'width' => 100 * 50, 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'valign' => 'center'));

        $count = 0;
        foreach ($documents as $row) {
            $count++;
            if ($count > 6)
                $count = 1;
            if ($count == 1)
                $table->addRow(null, []);
            $cell = $table->addCell(null, $styleCell);
            $cell->addImage(
                APPPATH . '..' . $row->image_url,
                array(
                    'align' => 'center',
                    'width'         => 70,
                    'height'        => 70,
                    'marginTop'     => -1,
                    'marginLeft'    => -1,
                    'wrappingStyle' => 'behind'
                )
            );
            $name = basename($row->image_url);
            $cell->addText($name, array('size' => 8), array('align' => 'center'));
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(time() . '.docx');
    }
}
