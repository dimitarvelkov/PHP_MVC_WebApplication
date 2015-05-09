<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05/06/2015
 * Time: 3:25 PM
 */

class CommentsModel extends BaseModel {
    public function addComment($postId, $commentAuthorName,$commentContent,$userId,$commentAuthorEmail=null){
        $statement = self::$db-> prepare("INSERT INTO comments (PostId,AuthorName, User_Id, AuthorEmail,Content ,CommentDate) VALUES (?, ?, ?, ?, ?,NOW())");
        $statement->bind_param("isiss",$postId, $commentAuthorName,$userId, $commentAuthorEmail,$commentContent);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function deleteComment($id){
        $statement = self::$db-> prepare("DELETE FROM comments WHERE id = ?;");
        $statement->bind_param("i",$id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
}