<?php

namespace App\Controllers;

use App\Models\ArticleEn;
use App\Models\ArticleFr;
use App\Models\ArticleRw;
use App\Models\CategoryEn;
use App\Models\CategoryFr;
use App\Models\CategoryRw;
use App\Models\ChapterEnModel;
use App\Models\ChapterFrModel;
use App\Models\ChapterRwModel;
use App\Models\Law;
use App\Models\LawEn;
use App\Models\LawFR;
use App\Models\LawsCityEnModel;
use App\Models\LawsCityModel;
use App\Models\LawsCityModelFr;
use App\Models\SectionModel;
use App\Models\SousSectionModel;
use \CodeIgniter\HTTP\ResponseInterface;
use Exception;
use http\Client\Response;
use phpDocumentor\Reflection\Types\This;

class Home extends BaseController
{
    public function appendHeader()
    {
        if($this->request->getMethod(true)=="OPTIONS"){
            $this->response->appendHeader('Access-Control-Allow-Origin','*');
            $this->response->appendHeader('Access-Control-Allow-Methods','*');
            $this->response->appendHeader('Access-Control-Allow-Credentials', 'true');
            $this->response->appendHeader('Access-Control-Allow-Headers','Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
            $this->response->setJSON(array("success","okay"));
            $this->response->send();
            exit();
        }
        $this->response->appendHeader("Access-Control-Allow-Origin","*");
        $this->response->appendHeader("Access-Control-Allow-Methods","*");
        $this->response->appendHeader("Access-Control-Max-Age",3600);
        $this->response->appendHeader("Access-Control-Allow-Headers","Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
    /**
     * @throws \ReflectionException
     */
    public function saveChapterRW() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'categoryId' => 2,
            'title' => $input->title
        ];
        $model = new ChapterRwModel();
        $result = $model->insert($data);
        if ($result)
        {
            return $this->response->setJSON(["status" => 200, "msg" => "Chapter saved successfully"]);
        } else {
            return $this->response->setJSON(["status" => 401, "error" => "Error during saving chapter"]);
        }
    }
    public function saveChapterEN() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'categoryId' => 2,
            'title' => $input->title
        ];
        $model = new ChapterEnModel();
        $result = $model->insert($data);
        if ($result)
        {
            return $this->response->setJSON(["status" => 200, "msg" => "Chapter saved successfully"]);
        } else {
            return $this->response->setJSON(["status" => 401, "error" => "Error during saving chapter"]);
        }
    }
    public function saveChapterFR() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'categoryId' => 2,
            'title' => $input->title
        ];
        $model = new ChapterFrModel();
        $result = $model->insert($data);
        if ($result)
        {
            return $this->response->setJSON(["status" => 200, "msg" => "Chapter saved successfully"]);
        } else {
            return $this->response->setJSON(["status" => 401, "error" => "Error during saving chapter"]);
        }
    }

    public function retrieveChaptersRW(int $id= null) : ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterRwModel();
        $result = $model->select("chapters_rw.id, chapters_rw.title as text, c.id as category, if(isnull(articles_rw.num),0,articles_rw.num) as articles_count")
            ->join('category_rw c', 'c.id = chapters_rw.category_id')
            ->join("(select count(ar.id) as num,chapter_id from article_rw ar left join chapters_rw ccr on ccr.id = ar.chapter_id GROUP by chapter_id) articles_rw","articles_rw.chapter_id = chapters_rw.id","left")
            ->where('chapters_rw.category_id', $id)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function retrieveChaptersEN(int $id = null) : ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterEnModel();
        $result = $model->select("chapters_en.id, chapters_en.title as text, c.id as category, if(isnull(articles_en.num),0,articles_en.num) as articles_count")
            ->join('category_en c', 'c.id = chapters_en.category_id')
            ->join("(select count(ar.id) as num,chapter_id from article_en ar left join chapters_en ccr on ccr.id = ar.chapter_id GROUP by chapter_id) articles_en","articles_en.chapter_id = chapters_en.id","left")
            ->where('chapters_en.category_id', $id)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function retrieveChaptersFR(int $id = null) : ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterFrModel();
        $result = $model->select("chapters_fr.id, chapters_fr.title as text, c.title as category, if(isnull(articles_fr.num),0,articles_fr.num) as articles_count")
            ->join('category_fr c', 'c.id = chapters_fr.category_id')
            ->join("(select count(ar.id) as num,chapter_id from article_fr ar left join chapters_fr ccr on ccr.id = ar.chapter_id GROUP by chapter_id) articles_fr","articles_fr.chapter_id = chapters_fr.id","left")
            ->where('chapters_fr.category_id', $id)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }

    /**
     * @throws \ReflectionException
     */
    public function storeArticle() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $model = new ArticleRw();
        $data = [
            'title' => $input->title,
            'chapter_id' => $input->chapterId
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["status" => 200, "msg" => "ArticleRw saved successfully"]);
        }catch (Exception $exception){
            return $this->response->setStatusCode(400)->setJSon($exception->getMessage());
        }
    }
    public function storeArticleFR() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $model = new ArticleFr();
        $data = [
            'title' => $input->title,
            'chapter_id' => $input->chapterId
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["status" => 200, "msg" => "ArticleRw saved successfully"]);
        }catch (Exception $exception){
            return $this->response->setStatusCode(400)->setJSon($exception->getMessage());
        }
    }
    public function storeArticleEN() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $model = new ArticleEn();
        $data = [
            'title' => $input->title,
            'chapter_id' => $input->chapterId
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["status" => 200, "msg" => "ArticleRw saved successfully"]);
        }catch (Exception $exception){
            return $this->response->setStatusCode(400)->setJSon($exception->getMessage());
        }
    }
    public function articleRetrieveRW(int $art_id = null) : ResponseInterface
    {
        $this->appendHeader();
        $model = new ArticleRw();
        $result = $model->select("article_rw.id, article_rw.title,laws_rw.title as law" )
            ->join("(select le.title, articleId from laws_rw le left join article_rw ar on ar.id = le.articleId GROUP by articleId) laws_rw","laws_rw.articleId = article_rw.id","left")
            ->where("article_rw.chapter_id", $art_id)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function articleRetrieveFR($art_id = null) : ResponseInterface
    {
        $this->appendHeader();
        $model = new ArticleFr();
        $result = $model->select("article_fr.id, article_fr.title,laws_fr.title as law" )
            ->join("(select le.title, articleId from laws_fr le left join article_fr ar on ar.id = le.articleId GROUP by articleId) laws_fr","laws_fr.articleId = article_fr.id","left")
            ->where("article_fr.chapter_id", $art_id)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function articleRetrieveEN($id = null) : ResponseInterface
    {
        $this->appendHeader();
        $model = new ArticleEn();
        $result = $model->select("article_en.id, article_en.title,laws_en.title as law" )
            ->join("(select le.title, articleId from laws_en le left join article_en ar on ar.id = le.articleId GROUP by articleId) laws_en","laws_en.articleId = article_en.id","left")
            ->where("article_en.chapter_id", $id)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    /**
     * @throws \ReflectionException
     */
    public function storeLaw() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $model = new Law();
        $law = [
            'title' => $input->title,
            'articleId' => $input->article,
        ];
        try {
            $model->save($law);
            return $this->response->setJSON(["msg" => "saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setStatusCode(401)->setJSON($exception->getMessage());
        }
    }
    public function retrieveLaws() : ResponseInterface
    {
        $this->appendHeader();
        $model = new Law();
        $result = $model->select('laws_rw.id as value, a.title as article, c.title as chapter, laws_rw.title as text, ca.title as category')
            ->join('article_rw a', 'a.id=laws_rw.articleId')
            ->join('chapters_rw c', 'c.id  = a.chapter_id')
            ->join('category_rw ca', 'ca.id  = c.category_id')
            ->where('ca.id', 2)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function storeLawFR() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $model = new LawFR();
        $law = [
            'title' => $input->title,
            'articleId' => $input->article,
        ];
        try {
            $model->save($law);
            return $this->response->setJSON(["msg" => "saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setStatusCode(401)->setJSON($exception->getMessage());
        }
    }
    public function retrieveLawsFR() : ResponseInterface
    {
        $this->appendHeader();
        $model = new LawFR();
        $result = $model->select('laws_fr.id as value, a.title as article, c.title as chapter, laws_fr.title as text, ca.title as category')
            ->join('article_fr a', 'a.id=laws_fr.articleId')
            ->join('chapters_fr c', 'c.id  = a.chapter_id')
            ->join('category_fr ca', 'ca.id  = c.category_id')
            ->where('ca.id', 2)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function storeLawEN() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $model = new LawEn();
        $law = [
            'title' => $input->title,
            'articleId' => $input->article,
        ];
        try {
            $model->save($law);
            return $this->response->setJSON(["msg" => "saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setStatusCode(401)->setJSON($exception->getMessage());
        }
    }
    public function retrieveLawsEN() : ResponseInterface
    {
        $this->appendHeader();
        $model = new LawEn();
        $result = $model->select('laws_en.id as value, a.title as article, c.title as chapter, laws_en.title as text, ca.title as category')
            ->join('article_en a', 'a.id = laws_en.articleId')
            ->join('chapters_en c', 'c.id  = a.chapter_id')
            ->join('category_en ca', 'ca.id  = c.category_id')
            ->where('ca.id', 2)
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    //Fetching Categories
    public function retrieveCategoriesRW() : ResponseInterface
    {
        $this->appendHeader();
        $model = new CategoryRw();
        $result = $model->select("category_rw.id, category_rw.title,if(isnull(chapter_rw.num),0,chapter_rw.num) as chapters_count")
            ->join("(select count(cr.id) as num,category_id from chapters_rw cr left join category_rw ccr on ccr.id = cr.category_id group by category_id) chapter_rw","chapter_rw.category_id = category_rw.id","left")
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function retrieveCategoriesEN() : ResponseInterface
    {
        $this->appendHeader();
        $model = new CategoryEn();
        $result = $model->select("category_en.id, category_en.title,if(isnull(chapter_en.num),0,chapter_en.num) as chapters_count")
            ->join("(select count(cr.id) as num,category_id from chapters_en cr left join category_en ccr on ccr.id = cr.category_id group by category_id) chapter_en","chapter_en.category_id = category_en.id","left")
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function retrieveCategoriesFR() : ResponseInterface
    {
        $this->appendHeader();
        $model = new CategoryFr();

        $result = $model->select("category_fr.id, category_fr.title,if(isnull(chapter_fr.num),0,chapter_fr.num) as chapters_count")
            ->join("(select count(cr.id) as num,category_id from chapters_fr cr left join category_fr ccr on ccr.id = cr.category_id group by category_id) chapter_fr","chapter_fr.category_id = category_fr.id","left")
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }

    public function storeCategory() :ResponseInterface
    {
        $this->appendHeader();
        $model = new CategoryEn();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'title' => $input->title
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["msg" => "Sous Section saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setJSON($exception->getMessage());
        }
    }

    public function storeChapterRW() :ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterRwModel();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'title' => $input->title,
            'category_id' => 2
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["msg" => "Chapter saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setJSON($exception->getMessage());
        }
    }
    public function storeChapterFR() :ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterFrModel();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'title' => $input->title,
            'category_id' => 2
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["msg" => "Sous Section saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setJSON($exception->getMessage());
        }
    }
    public function storeChapterEN() :ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterEnModel();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'title' => $input->title,
            'category_id' => 2
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["msg" => "Chapter saved successfully"]);
        } catch (Exception $exception) {
            return $this->response->setJSON($exception->getMessage());
        }
    }
}
