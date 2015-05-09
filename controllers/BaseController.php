<?php
abstract class BaseController {

    protected $action;
    protected $controllerName;
    protected $isViewRendered = false;
    protected $layoutName = DEFAULT_LAYOUT_NAME;
    protected $isPost = false;
    protected $isLoggedIn = false;
    protected $isAdmin = false;
    protected $postsByTag = false;

    public function __construct($controllerName,$action){
        $this->action = $action;
        $this->controllerName = $controllerName;
        $this->onInit();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $this->isPost= true;
        }

        if(isset($_SESSION['username'])){
            $this->isLoggedIn = true;
        }

        if(isset($_SESSION['admin'])){
            $this->isAdmin = true;
        }
    }

    public function index(){

    }

    public function onInit(){

    }

    public function renderView($viewName=null,$includeLayout=true){
        if(!$this->isViewRendered) {
            if ($viewName == null) {
                $viewName = $this->action;
            }

            if($includeLayout){
                $headerFile = 'views/layouts/'.$this->layoutName.'/header.php';
                include_once($headerFile);
            }

            include_once('views/' . $this->controllerName . '/' . $viewName . '.php');

            if($includeLayout){
                $footerFile = 'views/layouts/'.$this->layoutName.'/footer.php';
                include_once($footerFile);
            }

            $this->isViewRendered=true;
        }
    }

    protected function redirectToUrl($url) {
        header("Location: $url");
        exit();
    }

    protected function redirect($controller, $action = null, $params = []) {
        $url = "/$controller/$action";
        $paramsUrlEncoded = array_map('urlencode', $params);
        $paramsJoined = implode('/', $paramsUrlEncoded);

        if ($paramsJoined != '') {
            $url .= '/' . $paramsJoined;
        }

        $this->redirectToUrl($url);
    }

    private function addMessage($msgSessionkey, $msgText) {
        if (!isset($_SESSION[$msgSessionkey])) {
            $_SESSION[$msgSessionkey] = [];
        }

        array_push($_SESSION[$msgSessionkey], $msgText);

    }

    protected function addErrorMessage($errorMsg) {
        $this->addMessage(ERROR_MESSAGES_SESSION_KEY, $errorMsg);
    }

    protected function addInfoMessage($infoMsg) {
        $this->addMessage(INFO_MESSAGES_SESSION_KEY, $infoMsg);
    }

    protected function getNumberOfLettersInString($string){
        $number = mb_strlen(preg_replace('/[^a-zA-Z\p{Cyrillic}]/u', '', $string), 'UTF-8');
        return $number;
    }

}