<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use DateTime;
use Model\Managers\UserManager;

class SecurityController extends AbstractController implements ControllerInterface
{
    public function index()
    {
        $this->redirectTo("security", "login");
    }

    public function register()
    {
        if (Session::getUser()) {
            SESSION::addFlash('error', "<div class='message'>Vous êtes déjà inscrit et connecté</div>");
            $this->redirectTo("topic");
        }
        if (isset($_POST['submitSignUp'])) {
            // Filtre
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $nickname = filter_input(INPUT_POST, "nickname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Si les filtres passent
            if ($email !== false && $nickname !== false && $password !== false) {
                $userManager = new UserManager();

                // si le mail n'existe pas
                if (!$userManager->findOneByEmail($email)) {
                    // Si le pseudo n'existe pas
                    if (!$userManager->findOneByUser($nickname)) {
                        // si les 2 mots de passe concordent et que le mot de passe a une longueur minimale de 8
                        if (($password == $confirmPassword) && strlen($password) >= 8) {
                            // Hachage du mot de passe
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            // Ajout de l'user à la db avec la method add() du Manager
                            $data = ['nickname' => $nickname, 'email' => $email, 'password' => $hashedPassword];
                            $userManager->add($data);
                            // Redirection vers le login
                            SESSION::addFlash('success', "<div class='message'>Inscription réussie ! Vous pouvez maintenant vous connecter</div>");
                            $this->redirectTo("security", "login");
                            // Si les mots de passe ne correspondent pas
                        } else {
                            SESSION::addFlash('error', "<div class='message'>Les deux mots de passe ne correspondent pas ou le mot de passe fait moins de 8 caractères</div>");
                            $this->redirectTo("security", "register");
                        }
                        // Si le nickname existe déjà
                    } else {
                        SESSION::addFlash('error', "<div class='message'>Ce pseudo est déjà utilisé</div>");
                        $this->redirectTo("security", "register");
                    }
                    // Si l'adresse mail est déjà utilisé
                } else {
                    SESSION::addFlash('error', "<div class='message'>Cette adresse mail est déjà utilisée</div>");
                    $this->redirectTo("security", "register");
                }
            } else {
                SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                $this->redirectTo("security", "register");
            }
        }

        return [
            "view" => VIEW_DIR . 'security\register.php'
        ];
    }

    public function login()
    {

        if (Session::getUser()) {
            SESSION::addFlash('error', "<div class='message'>Vous êtes déjà connecté</div>");
            $this->redirectTo("topic");
        }
        if (isset($_POST['submitLogin'])) {
            // Filtre
            $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // On vérifie si c'est le nickname ou un email
            // Patern email
            $emailPattern = "/^([a-z0-9\+\_\-]+)(\.[a-z0-9\+\_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix"; // Validation d'email par expression régulière
            // preg_match() est utilisée pour rechercher un motif dans une chaîne de caractères
            if (preg_match($emailPattern, $user)) {
                $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
                $email = 1;
            }

            if ($user !== false && $password !== false) {
                $userManager = new UserManager();
                // retrouver le mot de passe de l'utilisateur
                $dbPass = $userManager->retrievePassword($user);
                // si le mot de passe est retrouvé
                if ($dbPass) {
                    // récupération du mot de passe
                    $hash = $dbPass->getPassword();
                    // retrouver l'utilisateur
                    if (isset($email)) {
                        $user = $userManager->findOneByEmail($user);
                    } else {
                        $user = $userManager->findOneByUser($user);
                    }
                    // comparaison du hash de la base de données et le mot de passe renseigné
                    if (password_verify($password, $hash)) {
                        // si l'user n'est pas banni
                        // convertit le statut : string en object DateTime
                        $statut = DateTime::createFromFormat('Y-m-d H:i:s', $user->getStatut());
                        if ($statut < new DateTime("now")) {
                            // placer l'utilisateur en Session
                            Session::setUser($user);
                            SESSION::addFlash('success', "<div class='message'>Connexion réussie</div>");
                            $this->redirectTo("topic");
                        } else {
                            SESSION::addFlash('error', "<div class='message'>Ce compte est banni</div>");
                            $this->redirectTo("security", "login");
                        }
                    } else {
                        SESSION::addFlash('error', "<div class='message'>Mot de passe incorrect</div>");
                        $this->redirectTo("security", "login");
                    }
                } else {
                    SESSION::addFlash('error', "<div class='message'>Email ou Pseudo incorrect</div>");
                    $this->redirectTo("security", "login");
                }
            } else {
                SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                $this->redirectTo("security", "login");
            }
        }

        return [
            "view" => VIEW_DIR . 'security\login.php'
        ];
    }

    public function logout()
    {
        if (!Session::getUser()) {
            SESSION::addFlash('error', "<div class='message'>Vous êtes déjà déconnecté</div>");
            $this->redirectTo("security", "login");
        }
        if ($_GET['action'] === 'logout') {
            // Détruit la session et rediriger vers l'accueil
            SESSION::unsetUser();
            SESSION::addFlash('success', "<div class='message'>Déconnexion réussie</div>");
            $this->redirectTo("security", "login");
        }
    }

    public function user($id)
    {

        if (!empty($id)) {
            if ($id !== false) {
                $userManager = new UserManager();
                // On recherche si l'user existe avec la method spécial de l'UserManager
                $user = $userManager->findUserByIdDateFR($id);
                if (!$user) {
                    SESSION::addFlash('error', "<div class='message'>Cet utilisateur n'existe pas</div>");
                    $this->redirectTo('topic');
                }

                return [
                    "view" => VIEW_DIR . 'security\user.php',
                    "data" => [
                        "users" => $user
                    ]
                ];
            } else {
                SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                $this->redirectTo("security", "user");
            }
        } elseif (Session::getUser()) {
            $this->redirectTo("security", "user", Session::getUser()->getId());
        } else {
            $this->redirectTo("topic");
        }
    }

    public function deleteUser($id)
    {
        // Si un user n'est pas admin : il peut supprimer son propre compte
        // Si un user est admin : il peut supprimer tous les comptes sauf le sien
        if (Session::getUser() && ((Session::isAdmin() && Session::getUser()->getId() !== $id) || (!Session::isAdmin() && (Session::getUser()->getId() === $id)))) {
            if ($id !== false && !empty($id)) {
                $userManager = new UserManager();
                // On vérifie que l'user existe avant de le supprimer
                $user = $userManager->findOneById($id);
                if (!$user) {
                    SESSION::addFlash('error', "<div class='message'>Cet utilisateur n'existe pas</div>");
                    $this->redirectTo('topic');
                }

                // On supprime l'utilisation avec l'id et la méthode delete
                $userManager->delete($id);
                // On détruit la session si l'user supprime son propre compte
                if (!Session::isAdmin()) {
                    Session::unsetUser();
                }
                // Redirection
                SESSION::addFlash('success', "<div class='message'>Le compte utilisateur a été supprimé</div>");
                $this->redirectTo("topic");
            } else {
                SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                $this->redirectTo("security", "user");
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo("topic");
        }
    }

    // Restriction d'un utilisateur (ban unban)
    public function restriction($id)
    {
        // Gestion des accès : Etre admin et que l'admin ne se restreint pas lui-même
        if (Session::isAdmin() && Session::getUser()->getId() !== $id) {
            if (isset($_POST['restriction'])) {
                // Filtre
                $seconde = filter_input(INPUT_POST, 'seconde', FILTER_VALIDATE_INT);
                // On vérifie que les filtres passent
                if ($id !== false && $seconde !== false && !empty($id) && !empty($seconde)) {
                    // Récupère l'utilisateur avec la method findOneById($id) du Manager
                    $userManager = new UserManager;
                    $user = $userManager->findOneById($id);
                    // Vérifie que l'utilisateur existe sinon on redirige
                    if (!$user) {
                        SESSION::addFlash('error', "<div class='message'>L'utilisateur n'existe pas</div>");
                        $this->redirectTo("topic");
                    }
                    // Vérifie que $seconde soit un entier supérieur
                    if ($seconde < 0) {
                        SESSION::addFlash('error', "<div class='message'>Le temps minimum est de 0 seconde(s)</div>");
                        $this->redirectTo("security", "user", $id);
                    }
                    // On ban l'utilisateur le temps donné en seconde grâce à la méthode bannir($id, $seconde) du UserManager
                    $userManager->bannir($id, $seconde);
                    // Redirection
                    SESSION::addFlash('success', "<div class='message'>L'utilisateur a été banni $seconde secondes.</div>");
                    $this->redirectTo("security", "user", $id);
                } else {
                    SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                    $this->redirectTo("topic");
                }
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé ou cet utilisateur n'existe pas</div>");
            $this->redirectTo("topic");
        }
    }

    // Modifier son pseudo (user)
    public function changeNickname($id)
    {
        if (Session::getUser() && Session::getUser()->getId() == $id) {
            if (isset($_POST['changeNickname'])) {
                // Filtre
                $nickname = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                if ($nickname !== false && !empty($nickname)) {
                    $userManager = new UserManager;
                    //Vérifie que le nickname c'est pas déjà utilisé
                    if ($userManager->findOneByUser($nickname)) {
                        SESSION::addFlash('error', "<div class='message'>Ce pseudo est déjà utilisé</div>");
                        $this->redirectTo("security", "user");
                    }
                    //Modifie le nickname avec la méthode updateOneValueById() de l'UserManager
                    $userManager->updateOneValueById($id, 'nickname', $nickname);
                    // Redirection + deconnexion
                    SESSION::unsetUser();
                    SESSION::addFlash('success', "<div class='message'>Votre pseudo a été changé en $nickname. Veuillez vous reconnecter.</div>");
                    $this->redirectTo("security", "login");
                } else {
                    SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                    $this->redirectTo("topic");
                }
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo("topic");
        }
    }

    // Changer le mot de passe
    public function changePassword($id)
    {
        if (Session::getUser() && Session::getUser()->getId() === $id) {
            if (isset($_POST['changePassword'])) {
                // Filtre
                $oldpassword = filter_input(INPUT_POST, "oldpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $newpassword = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $confirmedNewPassword = filter_input(INPUT_POST, "confirmNewPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // Si les filtres passent
                if ($oldpassword !== false && $newpassword !== false && $confirmedNewPassword !== false) {
                    $userManager = new UserManager();
                    $user = $userManager->findOneById($id);
                    // vérifie si l'user existe (au cas où)
                    if ($user) {
                        // récupération du mot de passe
                        $hash = $user->getPassword();
                        // comparaison du hash de la base de données et le mot de passe renseigné
                        if (password_verify($oldpassword, $hash)) {
                            // Vérifie le nouveau mot de passe
                            if ($newpassword === $confirmedNewPassword) {
                                // Si le mot de passe fait moins de 8 caractères
                                if ((strlen($newpassword) <= 8)) {
                                    SESSION::addFlash('error', "<div class='message'>Le nouveau mot de passe fait moins de 8 caractères</div>");
                                    $this->redirectTo("security", "user");
                                }
                                // Hachage du nouveau mot de passe
                                $hashedNewPassword = password_hash($newpassword, PASSWORD_DEFAULT);
                                // Update le mdp dans la db
                                $userManager->updateOneValueById($id, 'password', $hashedNewPassword);
                                // Redirection
                                SESSION::addFlash('success', "<div class='message'>Le mot de passe a été modifié avec succès</div>");
                                $this->redirectTo("security", "user");
                            } else {
                                SESSION::addFlash('error', "<div class='message'>Les deux mots de passe ne correspondent pas</div>");
                                $this->redirectTo("security", "user");
                            }
                        } else {
                            SESSION::addFlash('error', "<div class='message'>Le mot de passe est incorrect</div>");
                            $this->redirectTo("security", "user");
                        }
                    } else {
                        SESSION::addFlash('error', "<div class='message'>Quelque chose c'est mal passé</div>");
                        $this->redirectTo("security", "user");
                    }
                } else {
                    SESSION::addFlash('error', "<div class='message'>Erreur filtre</div>");
                    $this->redirectTo("security", "login");
                }
            } else {
                SESSION::addFlash('error', "<div class='message'>Action impossible</div>");
                $this->redirectTo("security", "user");
            }
        } else {
            SESSION::addFlash('error', "<div class='message'>Action non autorisé</div>");
            $this->redirectTo("security", "login");
        }
    }

    // Vue liste des utilisateurs
    public function users(){
        $this->restrictTo("ROLE_USER");

        $manager = new UserManager();
        $users = $manager->findAll(['nickname', 'ASC']);

        return [
            "view" => VIEW_DIR."security/userslist.php",
            "data" => [
                "users" => $users
            ]
        ];
    }
}
