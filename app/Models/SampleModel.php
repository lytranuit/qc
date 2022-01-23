<?php

namespace App\Models;


use App\Models\BaseModel;

class SampleModel extends BaseModel
{
    protected $table      = 'sample';
    protected $returnType     = 'array';
    protected $afterInsert = ['insertTrail', 'create_qr'];


    function format_row($row_a, $relation)
    {
        if (gettype($row_a) == "object") {
            if (in_array("time", $relation)) {
                $id = $row_a->id;
                $builder = $this->db->table('sample_time');
                $row_a->time = $builder->where('sample_id', $id)->get()->getResult();
            }
        } else {
            if (in_array("time", $relation)) {
                $id = $row_a['id'];
                $builder = $this->db->table('sample_time');
                $row_a['time'] = $builder->where('sample_id', $id)->get()->getResult("array");
            }
        }
        return $row_a;
    }
    public function create_qr($params)
    {
        // print_r($params);
        // die();
        $id = $params['id'];
        $sample = $this->find($id);
        $data_qr = base_url("qrcode/sample") . "/" . urlencode($sample->uuid);
        $dir = FCPATH . "assets/qrcode/";
        $save_name =  $id . "_" . time()  . '.png';

        /* QR Code File Directory Initialize */
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */

        /* QR Data  */
        $params['data']     = $data_qr;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = $dir . $save_name;

        $this->ciqrcode->generate($params);
        $this->update($id, array("image_url" => "/assets/qrcode/$save_name"));
        return $params;
    }
}
