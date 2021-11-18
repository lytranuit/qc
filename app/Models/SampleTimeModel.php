<?php

namespace App\Models;


use App\Models\BaseModel;

class SampleTimeModel extends BaseModel
{
    protected $table      = 'sample_time';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
