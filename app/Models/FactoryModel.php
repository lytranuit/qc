<?php

namespace App\Models;


use App\Models\BaseModel;

class FactoryModel extends BaseModel
{
    protected $table      = 'factory';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
