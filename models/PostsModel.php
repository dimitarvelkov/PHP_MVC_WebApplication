<?php
class PostsModel extends BaseModel {

    public function getAll($page){
        $numberOfPostsOnPage = 5;
        $page=$page-1;

        if($page==0){
            $offset = 0;
        }else{
            $offset  = $page * $numberOfPostsOnPage;
        }

        $statement = self::$db-> query(' SELECT COUNT(DISTINCT p.title) AS NumberOfPosts
                                           FROM Posts AS p');
        $numberOfPosts = $statement->fetch_assoc()['NumberOfPosts'];
        $numberOfPages = ceil($numberOfPosts/$numberOfPostsOnPage);

        $statement = self::$db-> prepare('SELECT p.Id, p.Title, p.Content, p.PostDate, p.VisitCounter,p.Tag, count(c.id) AS NumberOfComments
                                            FROM Posts AS p
                                            LEFT JOIN comments AS c
                                            ON p.id = c.PostId
                                            GROUP BY p.Title
                                            ORDER BY p.PostDate
                                            LIMIT ? OFFSET ?');
        $statement->bind_param("ii", $numberOfPostsOnPage,$offset);
        $statement->execute();
        $result =  $statement->get_result()->fetch_all(MYSQLI_ASSOC);

        return array("posts"=>$result,"pages"=>$numberOfPages);
    }

    public function mostVisitedPosts(){
        $statement = self::$db-> query('SELECT  p.Id, p.Title, p.Content, p.PostDate, p.VisitCounter,p.Tag, count(c.id) AS NumberOfComments
                                            FROM Posts AS p
                                            LEFT JOIN comments AS c
                                            ON p.id = c.PostId GROUP BY p.Title
                                            ORDER BY p.VisitCounter DESC
                                            LIMIT 2;');
        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    public function mostUsedTags(){
        $statement = self::$db-> query('SELECT t.Name, count(p.id) AS TagNumber
                                            FROM posts AS p
                                            JOIN post_tags AS x ON x.Post_id = p.Id
                                            JOIN tags AS t ON t.id = x.Tag_id
                                            GROUP BY t.Id
                                            ORDER BY TagNumber DESC
                                            LIMIT 5;');
        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    public function mostCommentedPosts(){
        $statement = self::$db-> query('SELECT  p.Id, p.Title, p.Content, p.PostDate, p.VisitCounter,p.Tag, count(c.id) AS NumberOfComments
                                            FROM Posts AS p
                                            LEFT JOIN comments AS c
                                            ON p.id = c.PostId GROUP BY p.Title
                                            ORDER BY NumberOfComments DESC
                                            LIMIT 2;');

        return $statement->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostWithComments($id){
        $statement = self::$db-> prepare("SELECT * FROM Posts WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $post=  $statement->get_result()->fetch_assoc();
        $comments = $this->getPostComments($id);
        $this->visitPost($id);
        return array("post"=>$post,"comments"=>$comments);
    }

    public function getPost($id){
        $statement = self::$db-> prepare("SELECT * FROM Posts WHERE id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $post =  $statement->get_result()->fetch_assoc();

        $statement = self::$db-> prepare(" SELECT t.name as TagsNames FROM Posts as p
                                           JOIN post_tags AS x ON x.Post_id = p.Id
                                           JOIN tags AS t ON t.id = x.Tag_id
                                           WHERE p.id = ? ");
        $statement->bind_param("i", $id);
        $statement->execute();
        $tagsNames = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        return array("post"=>$post,"tagsNames"=>$tagsNames);

    }

    public function postsByTag($tag){
        $statement = self::$db-> prepare("SELECT p.Id, p.Title, p.Content, p.PostDate, p.VisitCounter,p.Tag, count(c.id) AS NumberOfComments
                                            FROM posts AS p
                                            LEFT JOIN comments AS c
                                            ON p.id = c.PostId
                                            JOIN post_tags AS x ON x.Post_id = p.Id
                                            JOIN tags AS t ON t.id = x.Tag_id
                                            WHERE t.name = ?");
        $statement->bind_param("s", $tag);
        $statement->execute();
        $result =  $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function createPost($title,$content,$tagsArray,$userId,$isUpdate){
        $statement = self::$db-> prepare("INSERT INTO Posts (Title, Content, UserId, PostDate) VALUES (?, ?, ?, NOW())");
        $statement->bind_param("ssi", $title, $content, $userId);
        $statement->execute();

        if($statement->affected_rows < 1){
            return $statement->affected_rows < 1;
        }

        $statement = self::$db-> prepare("SELECT Id FROM Posts WHERE Title = ?");
        $statement->bind_param("s", $title);
        $statement->execute();
        $result =  $statement->get_result()->fetch_assoc();
        $postId = $result["Id"];

        foreach($tagsArray as $tag){
            $statement = self::$db-> prepare("SELECT Id FROM Tags WHERE name = ?");
            $statement->bind_param("s", $tag);
            $statement->execute();
            $tagInDb =  $statement->get_result()->fetch_assoc();

            if(isset($tagInDb['Id'])){
                $tagId = $tagInDb['Id'];
                $statement = self::$db-> prepare("INSERT INTO post_tags (Post_id,Tag_id) VALUES (?,?)");
                $statement->bind_param("ii", $postId, $tagId);
                $statement->execute();

                if($statement->affected_rows < 1){
                    return false;
                }
            }else{
                $statement = self::$db-> prepare("INSERT INTO Tags (name) VALUES (?)");
                $statement->bind_param("s",$tag);
                $statement->execute();
                if($statement->affected_rows < 1){
                    return false;
                }

                $statement = self::$db-> prepare("SELECT Id FROM Tags WHERE name = ?");
                $statement->bind_param("s", $tag);
                $statement->execute();
                $tagId =  $statement->get_result()->fetch_assoc()['Id'];

                $statement = self::$db-> prepare("INSERT INTO post_tags (Post_id,Tag_id) VALUES (?,?)");
                $statement->bind_param("ii", $postId, $tagId);
                $statement->execute();
                if($statement->affected_rows < 1){
                    return false;
                }
            }
        }

        return true;
    }



    public function deletePost($id){
        $statement = self::$db-> prepare("DELETE FROM posts WHERE id = ?;");
        $statement->bind_param("i",$id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function getPostComments($id){
        $statement = self::$db-> prepare("SELECT * FROM Comments AS c WHERE c.PostId = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    private function visitPost($postId){
        $statement = self::$db-> prepare("UPDATE posts SET VisitCounter = VisitCounter + ?
                                          WHERE Id = ?");
        $visit = 1;
        $statement->bind_param('ii',$visit, $postId);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
}