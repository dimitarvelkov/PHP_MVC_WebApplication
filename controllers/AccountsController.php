<?php

class AccountsController extends  BaseController{
    private $db;

    public function onInit(){
        $this->db=new AccountsModel();
        $this->title="Register";
    }

    public function register(){
        if($this->isPost) {

            $username = $_POST["username"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirmPassword"];
            $email = $_POST["еmail"];

            $usernameLenght = $this->getNumberOfLettersInString($username);
            $passwordLenght = $this->getNumberOfLettersInString($password);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addErrorMessage("Имеилът не е валиден!");
                $this->redirect("accounts","register");
            }

            if($usernameLenght<3){
                $this->addErrorMessage("Името трябва да съдържа 3 букви!");
                $this->redirect("accounts","register");
            }

            if($passwordLenght<3){
                $this->addErrorMessage("Паролата трябва да съдътжа по не 3 букви");
                $this->redirect("accounts","register");
            }

            if($password != $confirmPassword ){
                $this->addErrorMessage("Паролите не съвпадат!!");
                $this->redirect("accounts","register");
            }


            if($username == null || strlen($username)<3)
            {
                $this->addErrorMessage("invalid usernaem");
            }
            $isRegistered = $this->db->register($username,$password,$email);

            if($isRegistered){
                $this->addInfoMessage("successful register");
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $this->isLoggedIn = true;
                $this->redirect("posts");
            }
        }
    }

    public function login() {
        if($this->isPost) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $usernameLenght = $this->getNumberOfLettersInString($username);
            $passwordLenght = $this->getNumberOfLettersInString($password);

            if($usernameLenght < 2 || $passwordLenght < 5 ){
                $this->addErrorMessage("Невалидно потребителско или парола!");
                $this->redirect('accounts','login');
            }

            $user = $this->db->login($username,$password);

            if($user){
                if($user['is_admin'] == 1){
                    $_SESSION['admin'] = $user['is_admin'];
                    $_SESSION['email'] = $user['email'];
                    $this->isAdmin=true;
                }

                $this->addInfoMessage("Здарвей, ".ucfirst ($username)."!!!");

                $_SESSION['username'] = $username;
                $this->isLoggedIn = true;
                $this->redirect("posts");

            }else{
                $this->addErrorMessage("Грешно потребителско име или парола!");
                $this->redirect('accounts','login');
            }
        }
    }

    public function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['admin']);
        $this->isLoggedIn = false;
        $this->isLoggedIn = false;
        $this->addInfoMessage("Успешен изход от системата");
        $this->redirect("posts");
    }
}