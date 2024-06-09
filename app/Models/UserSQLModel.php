<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSQLModel extends Model
{
    protected $DBGroup = 'OrgData';

    protected $table      = 'AspNetUsers';
    protected $returnType     = 'array';
    
    protected $allowedFields = ["Id", "Email"];
}
