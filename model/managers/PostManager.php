<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        public function findPostsById($id){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.topic_id = :id";

            return $this->getMultipleResults(
                DAO::select($sql, ['id' => $id]),
                $this->className
            );
        }

        public function updatePostMessage($message, $messageId) {

            $sql = "UPDATE ".$this->tableName."
                    SET message = '" . $message . "', modifiedmessagedate = '" . (new \DateTime())->format('Y-m-d H:i:s') . "'
                    WHERE id_post = :id_post";

            try{
                return DAO::update($sql, ['id_post' => $messageId]);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }
    }