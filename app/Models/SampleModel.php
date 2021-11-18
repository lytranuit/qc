<?php

namespace App\Models;


use App\Models\BaseModel;

class SampleModel extends BaseModel
{
    protected $table      = 'sample';
    protected $returnType     = 'array';


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
}
