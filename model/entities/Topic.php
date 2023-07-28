<?php
    namespace Model\Entities;

    use App\Entity;

    final class Topic extends Entity{

        private $id;
        private $categorie;
        private $user;
        private $titre;
        private $message;
        private $creationdate;
        private $closed;
        private $messagecount;
        private $lastPostDate;

        public function __construct($data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of categorie
         */ 
        public function getCategorie()
        {
                return $this->categorie;
        }

        /**
         * Set the value of categorie
         *
         * @return  self
         */ 
        public function setCategorie($categorie)
        {
                $this->categorie = $categorie;

                return $this;
        }
        
        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }
        
        /**
         * Get the value of titre
         */ 
        public function getTitre()
        {
                return $this->titre;
        }

        /**
         * Set the value of titre
         *
         * @return  self
         */ 
        public function setTitre($titre)
        {
                $this->titre = $titre;
                
                return $this;
        }

        /**
         * Get the value of message
         */ 
        public function getMessage()
        {
                return $this->message;
        }

        /**
         * Set the value of message
         *
         * @return  self
         */ 
        public function setMessage($message)
        {
                $this->message = $message;

                return $this;
        }
        

        /**
         * Get the value of creationdate
         */ 
        public function getCreationdate(){
            $formattedDate = $this->creationdate->format("d/m/Y à H\hi");
            return $formattedDate;
        }

        /**
         * Set the value of creationdate
         *
         * @return  self
         */ 
        public function setCreationdate($date){
            $this->creationdate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of closed
         */ 
        public function getClosed()
        {
                return $this->closed;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setClosed($closed)
        {
                $this->closed = $closed;

                return $this;
        }

        /**
         * Get the value of messagecount
         */ 
        public function getMessagecount()
        {
                return $this->messagecount;
        }

        /**
         * Set the value of messagecount
         *
         * @return  self
         */ 
        public function setMessagecount($messagecount)
        {
                $this->messagecount = $messagecount;

                return $this;
        }

        /**
         * Get the value of lastPostDate
         */ 
        public function getLastPostDate()
        {
                return $this->lastPostDate;
        }

        /**
         * Set the value of lastPostDate
         *
         * @return  self
         */ 
        public function setLastPostDate($lastPostDate)
        {
                $this->lastPostDate = $lastPostDate;

                return $this;
        }
    }
