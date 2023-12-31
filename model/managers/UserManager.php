<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }

        // Récupérer un utilisateur grâce à son email
        public function findOneByEmail($email){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.email = :email
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $email], false), 
                $this->className
            );
        }
        
        // Récupérer un utilisateur grâce à son pseudo
        public function findOneByUser($user){

            $sql = "SELECT *
                    FROM ".$this->tableName." a
                    WHERE a.nickname = :nickname
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['nickname' => $user], false), 
                $this->className
            );
        }

        // Récupérer le mot de passe d'un user grâce à son email ou son pseudo
        public function retrievePassword($user) {

            $sql = "SELECT password
                    FROM ".$this->tableName." a
                    WHERE a.email = :email OR a.nickname = :nickname
                    ";
            
            return $this->getOneOrNullResult(
                DAO::select($sql, ['email' => $user, 'nickname' => $user], false), 
                $this->className
            );
        }

        // Bannir un utilisateur en seconde
        public function bannir($id, $seconde) {
            // DATE_ADD() ajoute un intervalle temps/date à une date et renvoie ensuite la date
            $sql = "UPDATE ".$this->tableName."
                    SET statut = 
                        CASE
                            WHEN statut IS NULL THEN DATE_ADD(NOW(), INTERVAL :seconde SECOND)
                            ELSE DATE_ADD(NOW(), INTERVAL :seconde SECOND)
                        END
                    WHERE id_user = :id";

            try{
                return DAO::update($sql, ['id' => $id, 'seconde' => $seconde]);
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        // Recupère les données de la table user, formate les dates 
        public function findUserByIdDateFR($id){

            $sql = "SELECT *, DATE_FORMAT(creationdate, '%d %M %Y à %Hh%i') AS creationdateFR, DATE_FORMAT(statut, '%d %M %Y à %Hh%i et %s secondes') AS statutFR
                    FROM user
                    WHERE id_user = :id
                    ";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );
        }

        // Update la value d'une table
        public function updateOneValueById($id, $param, $value){

            $sql = "UPDATE ".$this->tableName."
                    SET ".$param." = :value
                    WHERE id_".$this->tableName." = :id
                    ";
            
            try{ 
                DAO::update($sql, ['value' => $value, 'id' => $id]); 
            }
            catch(\PDOException $e){
                echo $e->getMessage();
                die();
            }
        }
    }