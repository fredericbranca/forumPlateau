<?php

namespace Model\Entities;

use App\Entity;

final class User extends Entity
{

        private $id;
        private $nickname;
        private $email;
        private $password;
        private $creationdate;
        private $role;
        private $statut;

        public function __construct($data)
        {
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
         * Get the value of nickname
         */
        public function getNickname()
        {
                return $this->nickname;
        }

        /**
         * Set the value of nickname
         *
         * @return  self
         */
        public function setNickname($nickname)
        {
                $this->nickname = $nickname;

                return $this;
        }

        /**
         * Get the value of email
         */
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of password
         */
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of creationdate
         */
        public function getCreationdate()
        {
                $formattedDate = $this->creationdate->format("d/m/Y, H:i:s");
                return $formattedDate;
        }

        /**
         * Set the value of creationdate
         *
         * @return  self
         */
        public function setCreationdate($date)
        {
                $this->creationdate = new \DateTime($date);
                return $this;
        }

        /**
         * Get the value of role
         */
        public function getRole()
        {
                return $this->role;
        }

        /**
         * Set the value of role
         *
         * @return  self
         */
        public function setRole($role)
        {
                $this->role = $role;

                return $this;
        }

        /**
         * Vérifie le rôle mit en argument
         */
        public function hasRole($role)
        {
                if ($this->role === $role) {
                        return true;
                }
                return false;
        }

        /**
         * Get the value of statut
         */
        public function getStatut()
        {
                return $this->statut;
        }

        /**
         * Set the value of statut
         *
         * @return  self
         */
        public function setStatut($statut)
        {
                $this->statut = $statut;

                return $this;
        }

        public function __toString()
        {
                return $this->nickname;
        }
}
