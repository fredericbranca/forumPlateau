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

        public function findTopicsByCategorie($id){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.categorie_id = :id";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );
        }

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
    } 