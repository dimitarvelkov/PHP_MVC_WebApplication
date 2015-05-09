<div>
    <?php if(count($this->posts)==0){
        echo "<h1>Сжаляваме,  но към момента няма постове.</h1>";
    }
    ?>

    <?php foreach($this->posts as $post):?>
        <div class="panel panel-primary">
            <div class="panel-heading"  style="overflow:hidden; text-overflow:ellipsis;">
                <h3 style="display: inline-block" class="panel-title">
                    <a href="/posts/getPost/<?=$post["Id"]?>">
                        <h2 style="display: inline-block ; margin-top: 0; margin-bottom: 0">
                            <?=htmlspecialchars($post["Title"])?>
                        </h2>
                        <div><?php if(isset($post["NumberOfComments"])){
                                echo "Коментари: ".htmlspecialchars($post["NumberOfComments"]);
                            }
                            ?>
                        </div>
                    </a>
                </h3>
                <div class="pull-right"> Показвания: <?=$post["VisitCounter"]?>
                    <br/> Дата: <?=$post["PostDate"]?></div>
            </div>
            <div class="panel-body" style="overflow:hidden;  text-overflow:ellipsis;">
                <?php
                $content  =$post["Content"];
                $rest = substr($content, 0, 300);
                echo  htmlspecialchars($rest)
                ?>
                <a href="/posts/getPost/<?=$post["Id"]?>">Виж още</a>

            </div>
        </div>
    <?php endforeach ?>

    <?php if($this->controllerName == "posts" && $this->action == "index"){

        if($this->numberOfPages!=0){
            echo '<nav>';
            echo "<ul class='pagination'>";
            echo '<li><a style="background-color: #ffffff">Страници</a></li>';
            for($i=1; $i<= $this->numberOfPages; $i++){
                echo "<li><a href="."/posts/getAll/".$i.'>' .$i."</a></li>";
            }
            echo '</ul>';
            echo '</nav>';
        }
    }
    ?>
</div>

