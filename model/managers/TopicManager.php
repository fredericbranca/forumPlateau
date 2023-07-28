<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }
        // Afficher toutes les infos d'un topic + nombre de message + date/heure du dernier message
        public function findTopics($idCategorie = null){

            $categorieQuery = ($idCategorie) ?                 
            "WHERE a.categorie_id = :idCategorie" :
            "";
            $param = ($idCategorie) ?
            ["idCategorie" => $idCategorie] : [];

            $sql = "SELECT a.*, DATE_FORMAT(a.creationdate, '%d/%m/%Y à %Hh%i') as formatedcreationdate, COUNT(p.id_post) AS messagecount, latestCreationDate.lastPostDate
                    FROM topic a
                    LEFT JOIN post p ON p.topic_id = a.id_topic 
                    LEFT JOIN (
                        SELECT topic_id, MAX(DATE_FORMAT(creationdate, '%d/%m/%Y à %Hh%i')) as lastPostDate 
                        FROM post
                        GROUP BY topic_id
                     ) latestCreationDate ON a.id_topic = latestCreationDate.topic_id "
                    .$categorieQuery. "
                    GROUP BY a.id_topic
                    ORDER BY a.creationdate DESC";
            
            return $this->getMultipleResults(
                DAO::select($sql, $param),
                $this->className
            );
        }

        // Modifier le messsage d'un topic
        public function updateTopicMessage($message, $id) {

            $sql = "UPDATE ".$this->tableName."
                    SET message = '" . $message . "'
                    WHERE id_topic = :id";

            try{
                return DAO::update($sql, ['id' => $id]);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        //Vérouiller un topic
        public function closeTopic($id) {

            $sql = "UPDATE ".$this->tableName."
                    SET closed = 1
                    WHERE id_topic = :id";

            try{
                return DAO::update($sql, ['id' => $id]);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        //Dévérouiller un topic
        public function openTopic($id) {

            $sql = "UPDATE ".$this->tableName."
                    SET closed = 0
                    WHERE id_topic = :id";

            try{
                return DAO::update($sql, ['id' => $id]);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

    } 