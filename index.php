<html>
<!–– Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <!–– Css -->
        <link rel="stylesheet" type='text/css' href="style.css" />

        <title>
            Forum
        </title>
    
    <?php
    $m = new MongoDB\Driver\Manager("mongodb://localhost:27017");
                
    if(isset($_GET["query"])){
            $query  = htmlentities($_GET['query']);
            $filter = [ 'tags' => new MongoDB\BSON\Regex($query)];
            $query = new MongoDB\Driver\Query($filter);

            $res = $m->executeQuery("forum.articles", $query);

            $r = $res->toArray();
    }else{
        $query = new MongoDB\Driver\Query([]);
        
        $r = $m->executeQuery("forum.articles", $query);
        $r = $r->toArray();
    }     
    if(isset($r)){
        function compare($o1, $o2){
            return $o1->likes < $o2->likes;
        }

        usort($r, 'compare');
    }
?>

        <body>

            <div class="container">
                <div class="topBar">

                    <div class="icons">
                        <fig class="tooltip" style="width: fit-content; display:inline-block;">
                            <a href="/webforum/index.php"><img class="home" src="img/home.png"></a>
                            <span class="tooltiptext">Home</span>
                        </fig>

                        <fig class="tooltip" style="width: fit-content; display:inline-block;">
                            <a href="http://google.com"><img class="profile" src="img/profile.jpg"></a>
                            <span class="tooltiptext">Profile</span>
                        </fig>

                        <fig class="tooltip" style="width: fit-content; display:inline-block;">
                            <button onclick="showHideUpload()"><img class="upload" src="img/upload.png"></button>
                            <span class="tooltiptext">Create Post</span>
                        </fig>
                    </div>

                    <form action="<?php $_PHP_SELF ?>" method="get" class="searchbar">
                        
                        <input type="text" name="query" id="query" class="sbar" placeholder="Search..">
                        
                        <fig class="tooltip" style="width: fit-content; display:inline-block;">
                            <img class="simg" src="img/search.png">
                        </fig>
                    </form>

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



                <div class="ArticleSection">
                    <?php
                    if(isset($r)){
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
                    }
                    if(empty($r)){
                        $error = <<<HTML
                                <h4>Sorry, there are no posts regarding your search!</h4>
                        HTML;
                        echo $error;
                    }
                ?>
                </div>
            </div>

            <!-- UPLOAD -->
            <div id="Upload" class="uploadall">
                <div class="uploadWrapper">
                    <h1 style="text-align: center; margin-top: 0">
                        Create Post
                    </h1>
                    <div class="image">
                        <div class="choose">
                            <input type="file" id="file" accept=".jpeg, .jfif, .jpg, .png, .gif, .bmp">
                        </div>
                    </div>

                    <div class="title">
                        <input type="text" placeholder="Title" id="title">
                    </div>

                    <div class="desc">
                        <textarea placeholder="Description" id="desc"></textarea>
                    </div>

                    <div class=tags>
                        <input type="text" placeholder="Tags" id="tags">
                    </div>

                    <div class="done">
                        <div class="cancel">
                            <button type="button" id="cancel">Cancel</button>
                        </div>
                        <div class="post">
                            <button type="button" id="post">Post</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="loading hide" id="loading">
                <img class="loading1" src="img/loadinggif.gif">
                <img class="loading2" src="img/loadinggif2.gif">
                <text class="loading3">Loading...</text>
            </div>

            <!----------------------------------------java scripts---------------------------------------->

            <script>
                /*-----------------------------------------variables----------------------------------------*/
                var title = document.getElementById("title");
                var tags = document.getElementById("tags");
                var file = document.getElementById("file");
                var desc = document.getElementById("desc");
                /*-----------------------------------------variable-----------------------------------------*/

                /*------------------------------------------Cancel------------------------------------------*/
                document.getElementById("cancel").addEventListener("click", function() {
                    if (title.value.length > 0 || desc.value.length > 0 || tags.value.length > 0 || file.value.length > 0) {
                        if (confirm("Are you sure you want to cancel?")) {
                            showHideUpload()
                        }
                    } else {
                        showHideUpload()
                    }
                });
                /*------------------------------------------Cancel------------------------------------------*/

                /*-------------------------------------------Post-------------------------------------------*/
                document.getElementById("post").addEventListener("click", function() {
                    if (title.value.length > 0 && tags.value.length > 0 && file.value.length > 0 && desc.value.length > 0) {
                        if (confirm("Are you sure you want to post?")) {
                            document.getElementById("loading").classList.remove("hide");
                            sFile().then(function(post_file) {
                                var post_title = title.value;
                                var post_tags = tags.value;
                                var post_desc = desc.value;
                                //add to data base
                                //bring you to new uploaded page
                            });
                        }
                    } else if (title.value.length > 0 && tags.value.length > 0 && file.value.length > 0) {
                        if (confirm("Are you sure you want to post?")) {
                            document.getElementById("loading").classList.remove("hide");
                            sFile().then(function(post_file) {
                                var post_title = title.value;
                                var post_tags = tags.value;
                                var post_desc = desc.value;
                                //add to data base
                                //bring you to new uploaded page
                            });
                        }
                    } else if (title.value.length > 0 && tags.value.length > 0 && desc.value.length > 0) {
                        if (confirm("Are you sure you want to post?")) {
                            document.getElementById("loading").classList.remove("hide");
                            var post_title = title.value;
                            var post_tags = tags.value;
                            var post_desc = desc.value;
                            //add to data base
                            //bring you to new uploaded page
                        }
                    } else {
                        if (title.value.length == 0) {
                            window.alert("Please add a title.");
                        } else if (tags.value.length == 0) {
                            window.alert("Please add a tag.");
                        } else {
                            window.alert("Please add an image or description.");
                        }
                    }

                });

                /*-----------------------------------file loader function-----------------------------------*/
                /*---------------------------------------Don't Touch----------------------------------------*/
                async function sFile() {
                    var p = new Promise(function(result, reject) {
                        var reader = new FileReader();
                        reader.onload = function(f) {
                            return (function(e) {
                                result(e.target.result)
                            })(f);
                        };

                        reader.readAsDataURL(document.getElementById("file").files[0]);
                    });
                    return await p;
                }
                /*---------------------------------------Don't Touch----------------------------------------*/
                /*-----------------------------------file loader function-----------------------------------*/

                /*-------------------------------------------Post-------------------------------------------*/

                function showHideUpload() {
                    var x = document.getElementById("Upload");
                    if (x.style.display === "block") {
                        x.style.display = "none";

                    } else {
                        x.style.display = "block";
                    }
                }
            </script>



        </body>

</html>