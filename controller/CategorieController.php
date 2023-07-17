<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\CategorieManager;
    
    class CategorieController extends AbstractController implements ControllerInterface{

        public function index(){
          

           $categorieManager = new CategorieManager();

            return [
                "view" => VIEW_DIR."categorie/listCategories.php",
                "data" => [
                    "categories" => $categorieManager->findAll(["nom", "DESC"])
                ]
            ];
        
        }


        

    }