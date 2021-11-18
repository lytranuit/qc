<?php

namespace App\Models;


use App\Models\BaseModel;

class EnvModel extends BaseModel
{
    protected $table      = 'env';
    protected $returnType     = 'array';


    function format_row($row_a, $relation)
    {
        if (gettype($row_a) == "object") {
            if (in_array("time", $relation)) {
                $id = $row_a->id;
                $builder = $this->db->table('env_time');
                $row_a->time = $builder->where('env_id', $id)->get()->getResult();
            }
        } else {
            if (in_array("time", $relation)) {
                $id = $row_a['id'];
                $builder = $this->db->table('env_time');
                $row_a['time'] = $builder->where('env_id', $id)->get()->getResult("array");
            }
        }
        return $row_a;
    }
}
