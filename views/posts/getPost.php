<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 id="currentPostHeader">
                <?= htmlspecialchars($this->currentPost["Title"])?>
        </h3>
        <span class="pull-right">
            <?= 'Дата: '. $this->currentPost["PostDate"]?><br/>
        </span>
    </div>
    <div class="panel-body" style="overflow:hidden;text-overflow:ellipsis;" >
        <?= $this->currentPost["Content"]?>
    </div>
    <div style="margin: 20px">
    <span>Коментари</span>
    <hr/>

    <?php foreach($this->comments as $comment):?>
        <div class="comment-container">

            <div  class="commentContentContainer" >
            <?=htmlspecialchars($comment["Content"])?>
            </div>
            Автор:<?=htmlspecialchars($comment["AuthorName"])?>
            <?php if(htmlspecialchars($comment["AuthorEmail"])!=''){
                echo ",  Email: ".htmlspecialchars($comment["AuthorEmail"]);
            }?>
            <span class="pull-right">
                 Дата: <?=htmlspecialchars($comment["CommentDate"]);?>
            </span>
            <br/>
            <a href="/comments/deleteComment/<?=$comment["id"]."/".$this->currentPost['Id'];?>">изтриване</a>

        </div>
    <?php endforeach ?>

    </div>
    <form action="/comments/addComment/<?= $this->currentPost["Id"]?>" method="post" id="addCommentForm" class="form-horizontal">
        <fieldset>
            <legend>Добавяе на коментари</legend>
            <?php if(!$this->isLoggedIn):?>
                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">Име</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="authorName" id="name" placeholder="Име">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-lg-2 control-label">Имеил</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="authorEmail" id="inputEmail" placeholder="Имеил">
                    </div>
                </div>
            <?php endif ?>
            <div class="form-group">
                <label for="textArea" class="col-lg-2 control-label">Коментар</label>
                <div class="col-lg-10">
                    <textarea class="form-control" rows="9" name="authorComment" id="textArea"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Добави коментар</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

