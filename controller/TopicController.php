<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\CategorieManager;

class TopicController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum\listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll(["creationdate", "DESC"])
            ]
        ];
    }

    public function listTopicsByCategorie($id)
    {

        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();

        return [
            "view" => VIEW_DIR . "forum\listTopics.php",
            "data" => [
                "topics" => $topicManager->findTopicsByCategorie($id),
                "categorie" => $categorieManager->findOneById($id)
            ]
        ];
    }

    public function createTopic()
    {

        // $topicManager = new TopicManager();
        // $postManager = new PostManager();

        return [
            "view" => VIEW_DIR . "forum\createTopic.php"
        ];
    }
}
