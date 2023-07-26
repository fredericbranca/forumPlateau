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

    public function answerTopic($id) {
        $topicId = $id;
        // Vérifie qu'un utilisateur est connecté pour qu'il puisse réponse à un topic
        if (Session::getUser()) {
            // Répondre à un topic
            if (isset($_POST['answerTopic']) && isset($id)) {

                // Filtres
                $userId = Session::getUser()->getId();
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
                // Vérifie si les filtres sont ok
                if ($topicId !== false && $userId !== false && $message !== false) {
                    $postManager = new PostManager();
                    // supprime les espaces spéciaux et les espaces vides du message
                    $trimmedMessage = preg_replace('/(&nbsp;|\s)+/', '', html_entity_decode($message));
                    //  supprime toutes les balises HTML
                    $strippedMessage = strip_tags(html_entity_decode($trimmedMessage));

                    // Vérifier si le message ne contient que des espaces vides
                    if (empty($strippedMessage)) {
                        SESSION::addFlash('error', "<div class='message'>Le message ne doit pas être vide</div>");
                        $this->redirectTo('post', 'listPostsByTopic', $topicId);
                    }
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
        } else {
            SESSION::addFlash('error', "<div class='message'>Vous devez être connecté pour répondre à une discussion</div>");
            $this->redirectTo('post', 'listPostsByTopic', $topicId);
        }
    }

    // Supprimer le message d'une discussion
    public function deleteTopicMessage($id)
    {
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);
        if (!$post) {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo('topic');
        }
        // On récupère le topic
        $topic = $post->getTopic();
        $topicId = $topic->getId();
        // on vérifie que l'user en session puisse supprimer uniquement son message (l'admin peut tout faire) et que le topic est ouvert
        if (Session::isAdmin() || (!$topic->getClosed() && ($post->getUser() && (Session::getUser()->getId() === $post->getUser()->getId())))) {

            if (isset($_POST['deleteTopicMessage']) && isset($id)) {
                if ($id !== false) {
                    $topicManager = new TopicManager();
                    // Supprimer le message avec la méthode delete() du Manager
                    $postManager->delete($id);
                    // Redirection vers le topic
                    SESSION::addFlash('success', "<div class='message'>Message supprimé !</div>");
                    $this->redirectTo('post', 'listPostsByTopic', $topicId);
                } else {
                    SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                    $topic = $postManager->findOneById($id);
                    $topicId = $topic->getTopic()->getId();
                    $this->redirectTo('post', 'listPostsByTopic', $topicId);
                }
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo('post', 'listPostsByTopic', $topicId);
        }
    }

    public function modifyTopicMessage($id)
    {
        $postManager = new PostManager();
        $post = $postManager->findOneById($id);
        if (!$post) {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo('topic');
        }
        // On récupère le topic
        $topic = $post->getTopic();
        $topicId = $topic->getId();
        // on vérifie que l'user en session puisse supprimer uniquement son message (l'admin peut tout faire) et que le topic est ouvert
        if (Session::isAdmin() || (!$topic->getClosed() && ($post->getUser() && (Session::getUser()->getId() === $post->getUser()->getId())))) {

            // Modifier le message d'un post
            if (isset($_POST['modifyTopicMessage']) && isset($id)) {
                // Filtres
                $messageId = $id;
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

                // Vérifie si les filtres sont ok
                if ($message !== false && $messageId !== false) {
                    // supprime les espaces spéciaux et les espaces vides du message
                    $trimmedMessage = preg_replace('/(&nbsp;|\s)+/', '', html_entity_decode($message));
                    //  supprime toutes les balises HTML
                    $strippedMessage = strip_tags(html_entity_decode($trimmedMessage));

                    // Vérifier si le message ne contient que des espaces vides
                    if (empty($strippedMessage)) {
                        SESSION::addFlash('error', "<div class='message'>Le message ne doit pas être vide</div>");
                        $this->redirectTo('post', 'listPostsByTopic', $topicId);
                    }
                    // Modifie le message du post
                    $postManager->updatePostMessage($message, $messageId);
                    // Redirection
                    $this->redirectTo('post', 'listPostsByTopic', $topicId);
                } else {
                    SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                    $this->redirectTo('post', 'listPostsByTopic', $topicId);
                }
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo('post', 'listPostsByTopic', $topicId);
        }
    }
}
