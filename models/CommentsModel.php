<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05/06/2015
 * Time: 3:25 PM
 */

class CommentsModel extends BaseModel {
    public function addComment($postId, $commentAuthorName,$commentContent,$commentAuthorEmail=null){
        $statement = self::$db-> prepare("INSERT INTO comments (PostId,AuthorName, AuthorEmail,Content ,CommentDate) VALUES (?, ?, ?, ?,NOW())");
        $statement->bind_param("isss",$postId, $commentAuthorName, $commentAuthorEmail,$commentContent);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
}