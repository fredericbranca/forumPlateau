<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\CategorieManager;

class TopicController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum\listTopics.php",
            "data" => [
                "topics" => $topicManager->findTopicMessageCounter(),
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
                "categorie" => $categorieManager->findOneById($id),
            ]
        ];
    }

    public function createTopic()
    {
        // Vérifie si un utilisateur est connecté pour créer un topic
        if (Session::getUser()) {

            $topicManager = new TopicManager();
            $caterogieManager = new CategorieManager();

            // Créer un topic (bouton Poster la discussion dans createTopic)

            if (isset($_POST['createTopic'])) {

                // Filtres
                $userId = Session::getUser()->getId();
                $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
                $categorie = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);

                // Vérifie si les filtres sont ok
                if ($userId !== false && $titre !== false && $message !== false && $categorie !== false) {
                    // supprime les espaces spéciaux et les espaces vides du message
                    $trimmedMessage = preg_replace('/(&nbsp;|\s)+/', '', html_entity_decode($message));
                    //  supprime toutes les balises HTML
                    $strippedMessage = strip_tags(html_entity_decode($trimmedMessage));

                    // Vérifier si le message ne contient que des espaces vides
                    if (empty($strippedMessage)) {
                        SESSION::addFlash('error', "<div class='message'>Le message ne doit pas être vide</div>");
                        $this->redirectTo('topic', 'createTopic');
                    }
                    $data = ['user_id' => $userId, 'categorie_id' => $categorie, 'titre' => $titre, 'message' => $message];
                    // Ajoute le topic à la db grâce à la metho add() du Manager
                    $idTopic = $topicManager->add($data);
                    // Redirection
                    $this->redirectTo('post', 'listPostsByTopic', $idTopic);
                } else {
                    SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                    $this->redirectTo('topic', 'createTopic');
                }
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Vous devez être connecté pour créer une nouvelle discussion</div>");
            $this->redirectTo('security', 'login');
        }
        return [
            "view" => VIEW_DIR . "forum\createTopic.php",
            "data" => [
                "categories" => $caterogieManager->findAll(["nom", "ASC"])
            ]
        ];
    }

    public function modifyTopic($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        if (!$topic) {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo('topic');
        }
        $topicId = $id;
        // on vérifie que l'user en session modifie uniquement son message (l'admin peut tout faire) et que le post soit ouvert
        if (Session::isAdmin() || (!$topic->getClosed() && ($topic->getUser() && (Session::getUser()->getId() === $topic->getUser()->getId())))) {
            // Modifier le message d'un topic
            if (isset($_POST['modifyTopic']) && isset($id)) {
                // Filtres
                $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
                // Vérifie si les filtres sont ok
                if ($topicId !== false && $message !== false) {
                    // supprime les espaces spéciaux et les espaces vides du message
                    $trimmedMessage = preg_replace('/(&nbsp;|\s)+/', '', html_entity_decode($message));
                    //  supprime toutes les balises HTML
                    $strippedMessage = strip_tags(html_entity_decode($trimmedMessage));

                    // Vérifier si le message ne contient que des espaces vides
                    if (empty($strippedMessage)) {
                        SESSION::addFlash('error', "<div class='message'>Le message ne doit pas être vide</div>");
                        $this->redirectTo('post', 'listPostsByTopic', $topicId);
                    }
                    // Modifie le message du topic
                    $topicManager->updateTopicMessage($message, $topicId);
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

    // Supprimer un topic
    public function deleteTopic($id)
    {
        if (Session::isAdmin()) {
            if ($_GET['ctrl'] === "topic" && $_GET['action'] === "deleteTopic" && isset($id)) {
                if ($id !== false) {
                    $topicManager = new TopicManager();
                    $postManager = new PostManager();
                    // vérifie que le topic existe
                    $topic = $topicManager->findOneById($id);
                    if (!$topic) {
                        SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
                        $this->redirectTo('topic');
                    }
                    // Supprime les messages du topic s'il y en a
                    $posts = $postManager->findPostsById($id);
                    if(!empty($posts)) {
                        foreach($posts as $post) {
                            $postManager->delete($post->getId());
                        }
                    }
                    // Supprime le topic avec la méthode delete() du Manager
                    $topicManager->delete($id);
                    SESSION::addFlash('success', "<div class='message'>Topic supprimé !</div>");
                    $this->redirectTo('topic');
                } else {
                    SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                    $this->redirectTo('topic');
                }
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo('topic');
        }
    }
}
