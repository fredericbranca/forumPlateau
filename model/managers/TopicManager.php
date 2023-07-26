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
        // Trier les topics par catégorie $id 
        public function findTopicsByCategorie($id){

            $sql = "SELECT a.*, COUNT(p.id_post) AS messagecount
                    FROM ".$this->tableName." a
                    LEFT JOIN post p ON p.topic_id = a.id_topic
                    WHERE a.categorie_id = :id
                    GROUP BY a.id_topic
                    ORDER BY a.creationdate DESC";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
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

        //Compter le nombre de message contenu dans un topic (hors message du topic)
        public function findTopicMessageCounter() {

            $sql = "SELECT t.*, COUNT(p.id_post) AS messagecount
                    FROM topic t
                    LEFT JOIN post p ON p.topic_id = t.id_topic
                    GROUP BY t.id_topic
                    ORDER BY t.creationdate DESC";

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
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