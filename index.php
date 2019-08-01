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
            <div class="topBar">
               
                <div class="icons">
                    <fig class="tooltip" style="width: fit-content; display:inline-block;">
                        <a href="http://google.com"><img class="home" src="img/home.png"></a> 
                        <span class="tooltiptext">Home</span>
                    </fig>
                
                    <fig class="tooltip" style="width: fit-content; display:inline-block;">
                        <a href="http://google.com"><img class="profile" src="img/profile.jpg"></a> 
                    <span class="tooltiptext">Profile</span>
                    </fig>
                
                    <fig class="tooltip" style="width: fit-content; display:inline-block;">
                        <a href="http://google.com"><img class="upload" src="img/upload.png"></a> 
                        <span class="tooltiptext">Upload</span>
                    </fig>
            </div>

            <div class="searchbar">
                <input type="text" class="sbar" placeholder="Search..">
                <fig class="tooltip" style="width: fit-content; display:inline-block;">
                    <img class="simg" src="img/search.png">
                </fig>
            </div>

            <div class="loginbox">
                <div class="lsbuttons">
                    <button type="button" class="loginbutton">Login</button>
                    <button type="button" class="signupbutton">Signup</button>
                </div>
            </div>   
            
        </div>
            
            <div class="BannerText">
                <h1>
                        Web Forum
                </h1>
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