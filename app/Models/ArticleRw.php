<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleRw extends Model
{
    protected $table = "article_rw";
    protected $primaryKey = "id";
    protected $allowedFields = ["title", "chapter_id"];
}
