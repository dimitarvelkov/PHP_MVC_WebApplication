<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05/06/2015
 * Time: 3:23 PM
 */

class CommentsController extends BaseController {
    private $db;

    public function onInit(){
        $this->db=new CommentsModel();
    }

    public function addComment($postId){

        if($_POST['authorName']== null){
            $commentAuthorName = $_SESSION['username'];
        }else{
            $commentAuthorName = $_POST['authorName'];
        }

        if($_POST['authorEmail']== null){
            $commentAuthorEmail =$_SESSION['email'];
        }else{
            $commentAuthorEmail = $_POST['authorEmail'];
        }

        $commentContent = $_POST['authorComment'];

        $numberOfLettersInAuthorName =  $this->getNumberOfLettersInString($commentAuthorName);
        $numberOfLettersInContent =  $this->getNumberOfLettersInString($commentContent);

        if($numberOfLettersInAuthorName<3){
            $this->addErrorMessage("Името трябва да бъде поне с три букви");
            $this->redirectToUrl('/posts/getPost/'.$postId);
        }
        if($numberOfLettersInContent<3){
            $this->addErrorMessage("Коментара трябва да бъде поне 10 букви");
            $this->redirectToUrl('/posts/getPost/'.$postId);
        }

        $isAddComment = $this->db->addComment($postId,$commentAuthorName,$commentContent,$commentAuthorEmail);

        if($isAddComment){
            $this->redirect("posts");
        }else{
            $this->redirectToUrl('/posts/getPost/'.$postId);
        }
    }


}

