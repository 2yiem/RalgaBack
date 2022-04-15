<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleEn extends Model
{
    protected $table = "article_en";
    protected $primaryKey = "id";
    protected $allowedFields = ["title", "chapter_id"];
}
