<?php

namespace App\Models;


use App\Models\BaseModel;

class UserFactoryModel extends BaseModel
{
    protected $table      = 'user_factory';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
