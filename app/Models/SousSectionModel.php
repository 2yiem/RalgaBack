<?php

namespace App\Models;

use CodeIgniter\Model;

class SousSectionModel extends Model
{
    protected $table = "sousSection";
    protected $primaryKey = "id";
    protected $allowedFields = ["sectionId", "title"];
}
