<?php
    namespace App;

    abstract class Entity{

        // hydrate() va permettre de donner à chaque attribut d'un objet, la donnée qui lui correspond
        protected function hydrate($data){

            // pour chaque attribut as champs => valeur
            foreach($data as $field => $value){

                //field = marque_id
                //fieldarray = ['marque','id']
                // On sépare la chaîne de caractères si elle possède un "_"
                $fieldArray = explode("_", $field);
                // Si la chaîne est de type marque_id : une classe étrangère
                if(isset($fieldArray[1]) && $fieldArray[1] == "id"){
                    // Nom du manager
                    $manName = ucfirst($fieldArray[0])."Manager";
                    //Chemin vers le manager
                    $FQCName = "Model\Managers".DS.$manName;
                    // On instancie la classe
                    $man = new $FQCName();
                    // On récupère les données de l'objet
                    $value = $man->findOneById($value);
                }
                //fabrication du nom du setter à appeler (ex: setMarque)
                $method = "set".ucfirst($fieldArray[0]);
               
                //si le setter existe dans dans l'entité
                if(method_exists($this, $method)){
                    // On set la donnée à l'attribut de l'objet
                    $this->$method($value);
                }

            }
        }

        public function getClass(){
            return get_class($this);
        }
    }