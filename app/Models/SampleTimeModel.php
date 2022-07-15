<?php

namespace App\Models;


use App\Models\BaseModel;

class SampleTimeModel extends BaseModel
{
    protected $table      = 'sample_time';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    function format_row($row_a, $relation)
    {
        if (gettype($row_a) == "object") {
            if (in_array("sample", $relation)) {
                $id = $row_a->sample_id;
                $builder = $this->db->table('sample');
                $row_a->sample = $builder->where('id', $id)->get()->getFirstRow();
            }
        } else {
            if (in_array("sample", $relation)) {
                $id = $row_a['sample_id'];
                $builder = $this->db->table('sample');
                $row_a['sample'] = $builder->where('id', $id)->get()->getFirstRow();
            }
        }
        return $row_a;
    }
}
