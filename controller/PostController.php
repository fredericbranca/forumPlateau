<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;

class PostController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $this->redirectTo("topic");
    }


    public function listPostsByTopic($id)
    {


        $postManager = new PostManager();
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum\posts.php",
            "data" => [
                "posts" => $postManager->findPostsById($id),
                "topic" => $topicManager->findOneById($id)
            ]
        ];
    }
}
