<?php

namespace App\Models;

use CodeIgniter\Model;


class LawEn extends Model
{
    protected $table = "laws_en";
    protected $primaryKey = "id";
    protected $allowedFields = ["articleId", "title"];
}
