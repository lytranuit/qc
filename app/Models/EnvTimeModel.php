<?php

namespace App\Models;


use App\Models\BaseModel;

class EnvTimeModel extends BaseModel
{
    protected $table      = 'env_time';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
