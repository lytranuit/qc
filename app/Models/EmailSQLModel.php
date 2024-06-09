<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailSQLModel extends Model
{
    protected $DBGroup = 'OrgData';

    protected $table      = 'emails';
    protected $returnType     = 'array';
    protected $allowedFields = ["id", "subject", "email_to", "email_type", "status", "body", "error", "date", "attachments"];
}
