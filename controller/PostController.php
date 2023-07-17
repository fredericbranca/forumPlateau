<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\PostManager;
    
    class PostController extends AbstractController implements ControllerInterface{

        public function index(){
          

           $postManager = new PostManager();

            return [
                "view" => VIEW_DIR."forum\post.php",
                "data" => [
                    "posts" => $postManager->findAll(["message", "DESC"])
                ]
            ];
        
        }


        

    }