<?php

        require 'components/_dbconnect.php';

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style>
    #maincon {
        min-height: 450px;
    }
    </style>

    <title>welcome to iDiscuss-Coding Forum</title>
</head>

<body>
    <?php require 'components/_navbar.php'?>
    
        }
        
        ?>
    <div class="container my-3" id="maincon">
        <div class="search">
            <h1 class="my-4"><u>Search Result for <em>"<?php echo $_GET['query']?>"</em></u></h1><br>
            <div class="searchresult">

                <div id="list-example" class="list-group">
                    <?php   
                            $noresult=true;
                            $search=$_GET['query'];
                            $sql="SELECT * FROM thread WHERE MATCH(thread_title, thread_desc) AGAINST('$search' IN NATURAL LANGUAGE MODE)";
                            $result=mysqli_query($conn,$sql);
                            while ($row=mysqli_fetch_assoc($result)) {
                                $noresult=false;
                                $title=$row['thread_title'];
                                $desc=$row['thread_desc'];
                                $thread_id=$row['thread_id'];
                    echo '<a class="list-group-item list-group-item-action my-4"
                        style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"
                        href="http://localhost/iforum/thread.php?threadid='.$thread_id.'">
                        <h4>'.$title.'</h4>
                        <p>'.$desc.'</p>
                    </a>';
                }
                if ($noresult) {
                    echo '<div class="jumbotron jumbotron-fluid">
                                    <div class="container">
                                        <h1 class="display-4">No Result found</h1>
                                        <p class="lead">Suggestion<ul>
                                        <li>Make sure that all words are spelled correctly</li>
                                        <li>Try different Keyword</li>
                                        <li>Try more general words</li></ul>
                                        </p>
                                    </div>
                            </div>';
                }
                ?>

                </div>

            </div>

        </div>
    </div>
    <?php require 'components/_footer.php'?>
    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>