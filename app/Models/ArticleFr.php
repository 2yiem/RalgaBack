<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleFr extends Model
{
    protected $table = "article_fr";
    protected $primaryKey = "id";
    protected $allowedFields = ["title", "chapter_id"];
}
