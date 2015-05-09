<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis; display: inline-block" class="panel-title">
            <h3 style="display: inline-block;   margin-top: 0; margin-bottom: 0;">
                <?= htmlspecialchars($this->currentPost["Title"])?>
            </h3>
        </h3>
        <span style="float: right"><?= $this->currentPost["PostDate"]?></span>
    </div>
    <div class="panel-body" style="overflow:hidden;text-overflow:ellipsis;" >
        <?= $this->currentPost["Content"]?>
    </div>
    <div style="margin: 20px">
    <span>Коментари</span>
    <hr/>
    <?php foreach($this->comments as $comment):?>
        <div style="background-color: #fafafa; border: 1px solid #c0c0c0; border-radius: 10px;padding: 5px;margin-top: 8px">

            <div  style="overflow:hidden;text-overflow:ellipsis;background-color:#ffffff;border: 1px solid #c0c0c0; border-radius: 10px;padding: 5px;" >
            <?=htmlspecialchars($comment["Content"])?>
            </div>
            Автор:<?=htmlspecialchars($comment["AuthorName"]).","?>
            Email: <?=htmlspecialchars($comment["AuthorEmail"])?>
            <span style="float: right">
                 Дата: <?php  if(isset($comment["CommentDate"]))
                {
                    echo htmlspecialchars($comment["CommentDate"]);
                }?>
            </span>
            <br/>

        </div>
    <?php endforeach ?>
    </div>

    <form action="/comments/addComment/<?= $this->currentPost["Id"]?>" method="post" class="form-horizontal" style="margin: 20px">
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

