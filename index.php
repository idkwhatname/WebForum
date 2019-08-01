<html>
    <!–– Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <!–– Css -->
    <link rel = "stylesheet"
          type = 'text/css'
          href = "style.css" 
    />
    
    <title>
    Forum
    </title>
      
    <body>
        <div class="container">
            <fig class="tooltip" style="width: fit-content; display:inline-block;">
                <IMG STYLE="WIDTH:64; HEIGHT:64" SRC="cam.png">
                </IMG>
            <span class="tooltiptext">Upload</span>
            </fig>

            <div class="SearchBar">
                <input  style="border: 2px solid #09b3ff;border-radius: 5px;width: 50%; padding: 5; display:inline-block;" type="text" placeholder="SEARCH">
            </div>

        <div class="Login">
            <div>
                <input type="text" placeholder="Login" style="margin: 3;">
            </div>
            <div>
                <input type="password" placeholder="Password" style="margin: 3";>
            </div>
            <div style="float: right;"> 
                <button> Login </button>
                <button> SignUp</button>
            </div>  
            
        </div>
            <img class="Banner" src="img/Banner.png">
            <div class="BannerText">
                <h1>
                        Web Forum
                </h1>
            </div>
                <div class="TopBar">
                    Popular Posts

            </div>
            
            
<?php
    $m = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    $filter = [ 'tags' => new MongoDB\BSON\Regex('pasta')]; 
    $query = new MongoDB\Driver\Query($filter);     
    
    $res = $m->executeQuery("forum.articles", $query);
    
    $r = $res->toArray();          
?>        
            <div class="ArticleSection">
                <?php

                    foreach($r as $a){
                        $article = <<<HTML
                            <article class='Article'>
                            <img class='ArticlePeekImg' src='img/placeholder.jpg'>
                            <h4>
                               $a->title
                            </h4>
                               $a->description
                            <div class='ArticleLikeCount'>
                                $a->likes
                            </div>
                            </article>
                        HTML;
                        echo $article;
                    }
                ?>
            </div>
        </div> 
    </body>
</html>