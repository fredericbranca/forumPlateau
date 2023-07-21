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


        // Répondre à un topic
        if (isset($_POST['answerTopic']) && isset($_GET['id'])) {

            // Filtres
            $topicId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $userId = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
            // Vérifie si les filtres sont ok
            if ($topicId !== false && $userId !== false && $message !== false) {

                $data = ['topic_id' => $topicId, 'user_id' => $userId, 'message' => $message];
                // Ajoute le topic à la db grâce à la metho add() du Manager
                $postManager->add($data);
                // Redirection
                $this->redirectTo('post', 'listPostsByTopic', $topicId);
            } else {
                SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                $this->redirectTo('post', 'listPostsByTopic', $topicId);
            }
        }

        return [
            "view" => VIEW_DIR . "forum\posts.php",
            "data" => [
                "posts" => $postManager->findPostsById($id),
                "topic" => $topicManager->findOneById($id)
            ]
        ];
    }
}
