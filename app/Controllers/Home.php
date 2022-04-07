<?php

namespace App\Controllers;

use App\Models\Article;
use App\Models\ChapterModel;
use App\Models\Law;
use App\Models\SectionModel;
use App\Models\SousSectionModel;
use \CodeIgniter\HTTP\ResponseInterface;
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
    public function chapter() : ResponseInterface
    {
        $this->appendHeader();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'title' => $input->title
        ];
        $model = new ChapterModel();
        $result = $model->insert($data);
        if ($result)
        {
            return $this->response->setJSON(["status" => 200, "msg" => "Chapter saved successfully"]);
        } else {
            return $this->response->setJSON(["status" => 401, "error" => "Error during saving chapter"]);
        }
    }
    public function retrieveChapters() : ResponseInterface
    {
        $this->appendHeader();
        $model = new ChapterModel();
        $result = $model->select("id as value, title as text")
//            ->join()
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
        $model = new Article();
        $data = [
            'title' => $input->title,
            'chapterId' => $input->chapterId,
            'sectionId' => $input->section,
            'sousSectionId' => $input->sousSection
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["status" => 200, "msg" => "Article saved successfully"]);
        }catch (\Exception $exception){
            return $this->response->setStatusCode(400)->setJSon($exception->getMessage());
        }
    }
    public function articleRetrieve($sectionId) : ResponseInterface
    {
        $this->appendHeader();
        $model = new Article();
        $result = $model->select("id as value, title as text")->where('sousSectionId', $sectionId)->get()->getResultArray();
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
            'chapterId' => $input->chapter,
            'articleId' => $input->article,
            'title' => $input->laws,
            'subSectionId' => $input->laws
        ];
        try {
            $model->save($law);
            return $this->response->setJSON(["msg" => "saved successfully"]);
        } catch (\Exception $exception) {
            return $this->response->setStatusCode(401)->setJSON($exception->getMessage());
        }
    }
    public function retrieveLaws() : ResponseInterface
    {
        $input = json_decode(file_get_contents('php://input'));
        $this->appendHeader();
        $model = new Law();
        $result = $model->select('a.title as article, c.title as chapter, laws.title')
            ->join('article a', 'a.id=laws.articleId', "left")
            ->join('chapter c', 'c.id  = laws.chapterId', "left")
            ->get()->getResultArray();
        return $this->response->setJSON($result);
    }
    public function sectionRegistration() : ResponseInterface
    {
        $this->appendHeader();
        $model = new SectionModel();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'chapterId' => $input->chapterId,
            'title' => $input->title
        ];
        try {
            $results = $model->insert($data);
            return $this->response->setJSON($results);
        } catch (\Exception $ex) {
            return $this->response->setJSON($ex->getMessage());
        }
    }

    public function sousSectionRegistration() : ResponseInterface
    {
        $this->appendHeader();
        $model = new SousSectionModel();
        $input = json_decode(file_get_contents('php://input'));
        $data = [
            'sectionId' => $input->sous,
            'title' => $input->title
        ];
        try {
            $model->insert($data);
            return $this->response->setJSON(["msg" => "Sous Section saved successfully"]);
        } catch (\Exception $exception) {
            return $this->response->setJSON($exception->getMessage());
        }
    }
    public function retrieveSection() : ResponseInterface
    {
        $this->appendHeader();
        $model = new SectionModel();
        $result = $model->select('id as value, title as text')
//                    ->where('articleId', $articleId)
                    ->get()->getResultArray();
        if ($result)
        {
            return  $this->response->setJSON($result);
        } else {
            return  $this->response->setJSON(['message' => 'No Datas Found']);
        }
//        return $this->response->setJSON($result);
    }
    public function retrieveSousSection() : ResponseInterface
    {
        $this->appendHeader();
        $model = new SousSectionModel();
        $result = $model->select('id as value, title as text')->get()->getResultArray();
        if ($result)
        {
                    return  $this->response->setJSON(['message' => "data found"]);
        } else {
                    return  $this->response->setJSON(['message' => 'No Data Found']);
        }
    }
    public function subSectionRetrieve() : ResponseInterface
    {
        $this->appendHeader();
        $model = new SousSectionModel();
        $result = $model->select('id as value, title as text')->get()->getResultArray();
        return $this->response->setJSON($result);
    }
}
