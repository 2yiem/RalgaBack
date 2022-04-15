<?php

namespace App\Models;

use CodeIgniter\Model;

class LawFR extends Model
{
    protected $table= "laws_fr";
    protected $primaryKey = "id";
    protected $allowedFields = ["articleId", "title"];
}
