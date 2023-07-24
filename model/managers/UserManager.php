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

    }