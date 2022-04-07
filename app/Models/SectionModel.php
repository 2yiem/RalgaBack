<?php

namespace App\Models;

use CodeIgniter\Model;

class SectionModel extends Model
{
    protected $table = "section";
    protected $primaryKey = "id";
    protected $allowedFields = ["articleId", "title"];
}
