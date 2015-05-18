<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="/content/style.css"/>
    <title>
        <?php if(isset($this->title )){
            echo htmlspecialchars($this->title);
        } ?>
    </title>
    <link rel="stylesheet" href="/content/bootstrap/css/bootstrap.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/posts/index">BLOG</a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                    <li>
                        <?php if($this->isAdmin) :?>
                            <a href="/posts/createPost">Нов пост</a>

                        <?php endif ?>

                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Категории<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">С#</a></li>
                            <li><a href="#">Java</a></li>
                            <li><a href="#">PHP</a></li>
                            <li><a href="#">ORM</a></li>
                        </ul>
                    </li>
                </ul>
                <form action="/posts/postsByTag" method="post" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" name="search_tag" class="form-control" placeholder="Търсене по таг">
                    </div>
                    <button type="submit" class="btn btn-default">Търси</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><?php if($this->isLoggedIn) :?>
                            <a id="header-right-bar-a" href="#"><?php echo "Име: ".$_SESSION['username']?></a>
                            <a id="header-right-bar-a" href="/accounts/logout">Изход</a>
                        <?php  else:?>
                            <a id="header-right-bar-a" href="/accounts/login">Вход</a>
                            <a id="header-right-bar-a" href="/accounts/register">Регистрация</a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</header>
<?php include_once('views/layouts/messages.php'); ?>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <?php if($this->controllerName == 'posts') :?>
            <div class="col-md-2">


                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        Меню
                    </a>
                    <a href="/posts/index" class="list-group-item">Всички постове
                    </a>
                    <a href="/posts/mostVisitedPosts" class="list-group-item">Най-четени постове
                    </a>
                    <a href="/posts/mostCommentedPosts" class="list-group-item">Най-коментирани постове
                    </a>
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item active">
                        Най-популяри тагове
                    </a>
                    <?php foreach($this->mostUsedTags as $tag){
                        echo "<a href= "."/posts/postsByTag/".htmlspecialchars($tag['Name'])." class='list-group-item'>". htmlspecialchars($tag['Name'])."</a>";
                    }
                    ?>
                </div>

            </div>
        <div  id="container  class="col-md-10">
            <?php else: ?>
            <div id="container" class="col-md-12">
        <?php endif; ?>







