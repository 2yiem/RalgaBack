<?php

namespace App\Models;

use CodeIgniter\Model;

class Law extends Model
{
    protected $table = "laws_rw";
    protected $primaryKey = "id";
    protected $allowedFields = ["articleId", "title"];
}
