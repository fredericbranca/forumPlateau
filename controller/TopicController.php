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
        $topicManager = new TopicManager();

        // Créer un topic (bouton Poster la discussion dans createTopic)

        if (isset($_POST['createTopic'])) {

            // Filtres
            $userId = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
            $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
            $categorie = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);

            // Vérifie si les filtres sont ok
            if ($userId !== false && $titre !== false && $message !== false && $categorie !== false) {

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
        return [
            "view" => VIEW_DIR . "forum\createTopic.php"
        ];
    }

    public function modifyTopic()
    {
        $topicManager = new TopicManager();

        // Modifier le message d'un topic
        if (isset($_POST['modifyTopic']) && isset($_GET['id'])) {
            // Filtres
            $topicId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
            // Vérifie si les filtres sont ok
            if ($topicId !== false && $message !== false) {

                // Modifie le message du topic
                $topicManager->updateTopicMessage($message, $topicId);
                // Redirection
                $this->redirectTo('post', 'listPostsByTopic', $topicId);
            } else {
                SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                $this->redirectTo('post', 'listPostsByTopic', $topicId);
            }
        }
    }

    // Supprimer un topic
    public function deleteTopic($id) {
        $topicManager = new TopicManager();
        if (isset($_POST['deleteTopic']) && isset($id)) {
            if ($id !== false) {
                // Supprime le topic avec la méthode delete() du Manager
                $topicManager->delete($id);
                SESSION::addFlash('success', "<div class='message'>Topic supprimé !</div>");
                $this->redirectTo('topic');
            } else {
                SESSION::addFlash('error', "<div class='message'>Filtres non ok</div>");
                $this->redirectTo('topic');
            }
        }
    }
}
