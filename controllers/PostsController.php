<?php
class PostsController extends BaseController {
    private $db;

    public function onInit(){
        $this->db=new PostsModel();
        $this->title="Posts";
        $this->mostUsedTags = $this->db->mostUsedTags();
    }

    public function index($id=1){
        $posts = $this->db->getAll($id);
        $this->posts=$posts['posts'];
        $this->numberOfPages=$posts['pages'];
    }

    public function getAll($id){
        $posts = $this->db->getAll($id);
        $this->posts=$posts['posts'];
        $this->numberOfPages=$posts['pages'];
        $this->redirectToUrl('/posts/index/'.$id);
    }

    public function createPost($createPost = null){

        if(!$this->isAdmin){
            $this->redirect('posts');
        }

        if($this->isPost){
            $title = $_POST['post_title'];
            $content = $_POST['post_content'];
            $tag = $_POST['post_tag'];

            $numberOfLettersInTitle = $this->getNumberOfLettersInString($title);
            $numberOfLettersInContent = $this->getNumberOfLettersInString($content);

            if($numberOfLettersInTitle < 5){
              $this->addErrorMessage("Заглавието трябва съдърж поне 5 букви.");
                $this->redirect('posts','createPost');
            }

            if($numberOfLettersInTitle > 45){
                $this->addErrorMessage("Максималната дължина на заглавието е 45 символа.");
                $this->redirect('posts','createPost');
            }

            if($numberOfLettersInContent < 200){
                $this->addErrorMessage("Поста трябва да съдържа поне 200 букви.");
                $this->redirect('posts','createPost');
            }

            $tagsString=preg_replace('/[^a-zA-Z0-9а-яА-Я]+/u', ' ', $tag);
            $tagsArray = array_filter(explode(' ',$tagsString));

//            $isPostCreated = false
            if($createPost=='postForEdit'){
                $isPostCreated = $this->db->createPost($title,$content,$tagsArray,$_SESSION['userId'],true);
            }else{
                $isPostCreated = $this->db->createPost($title,$content,$tagsArray,$_SESSION['userId']);
            }

            if($isPostCreated){
                $this->redirect("posts");
            }else{
                $this->addErrorMessage('Вече има създаден пост с това  заглавие');
                $this->redirect('posts','createPost');
            }
        }
    }

    public function deletePost($id){
        $isPostDeleted  = $this->db->deletePost($id);
        if($isPostDeleted) {
            $this->redirect('posts');
        }
    }

    public function editPost($id){
        if($this->isPost){
            $this->createPost('postForEdit');
        }else{
            $currentPostWithTags = $this->db->getPost($id);
            $this->currentPost = $currentPostWithTags['post'];
            $this->currentPostTagsNames =$currentPostWithTags['tagsNames'];

        }

    }

    public function getPostWithComments($id){
        $postWithComments =  $this->currentPost= $this->db->getPostWithComments($id);
        $this->currentPost = $postWithComments["post"];
        $this->comments = $postWithComments["comments"];
        if($this->currentPost == null){
            $this->addErrorMessage('Постът които искате да видите беше изтрит');
            $this->redirect('posts');
        }
    }

    public function postsByTag($tagFromUrl = null){
        if($tagFromUrl==null){
            $tag = $_POST['search_tag'];
        }else{
            $tag = $tagFromUrl;
        }

        $this->posts = $this->db->postsByTag($tag);
        $this->renderView('index');
    }

    public function mostVisitedPosts(){
        $this->posts = $this->db->mostVisitedPosts();
        $this->renderView('index');
    }

    public function mostCommentedPosts(){
        $this->posts = $this->db->mostCommentedPosts();
        $this->renderView('index');
    }

}






