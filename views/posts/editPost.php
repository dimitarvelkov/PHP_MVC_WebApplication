<form class="form-horizontal col-sm-10 col-sm-offset-1" action="/posts/editPost" method="post" >
    <fieldset>
        <legend>Добавяне на нов пост</legend>
        <div class="form-group">
            <label for="post_title" class="col-lg-2 control-label">Заглавие</label>
            <div class="col-lg-10">
                <input type="text" value="<?= $this->currentPost['Title']?>" name="post_title" class="form-control" id="post_title" placeholder="Заглавие">
            </div>
        </div>
        <div class="form-group">
            <label for="post_content"  class="col-lg-2 control-label">Съдържание</label>
            <div class="col-lg-10">
                <textarea rows="9" name="post_content" class="form-control" id="post_content" placeholder="Съдържание">
                    <?= $this->currentPost['Content']?>
                </textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="post_tag" class="col-lg-2 control-label">Тагове</label>
            <div class="col-lg-10">
                <input type="text"
                       value="<?php  ;foreach( $this->currentPostTagsNames as $tag) {
                           echo $tag['TagsNames']." ";
                       }
                       ?>"
                       name="post_tag" class="form-control" id="post_tag" placeholder="Тагове">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit"  class="btn btn-primary">Промени</button>
            </div>
        </div>
    </fieldset>
</form>
