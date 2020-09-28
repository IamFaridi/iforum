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

    <title>welcome to iDiscuss-Coding Forum</title>
</head>

<body>
    <?php require 'components/_navbar.php';?>
    <?php
        require 'components/_dbconnect.php';

    $usersno='';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
        $loggedemail=$_SESSION['useremail'];
        $sql3="SELECT sno FROM `users` WHERE `user_email` LIKE '$loggedemail'";
        $result3=mysqli_query($conn,$sql3);
        $row3=mysqli_fetch_assoc($result3);
        $usersno=$row3['sno'];
    }

    $inserted=false;
    if ($_SERVER['REQUEST_METHOD']=='POST') {
            $title=$_POST['title'];
            $desc=$_POST['desc'];
            $id=$_GET['catid'];
            $title=str_replace('<','&lt',$title);
            $title=str_replace('>','&gt',$title);
            $desc=str_replace('<','&lt',$desc);
            $desc=str_replace('>','&gt',$desc);
            $sql="INSERT INTO `thread` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `ctime`) VALUES ('$title', '$desc', '$id', '$usersno', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if ($result) {
                $inserted=true;
            }
        }

?>
    <?php 
        if ($inserted) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Succes!</strong> Your question has been added. Please wait for community to reply.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        }
    ?>
    <?php
        $id=$_GET['catid'];
        $sql="SELECT * FROM `category` WHERE `cat_id`=$id";
        $result=mysqli_query($conn,$sql);
        while ($row=mysqli_fetch_assoc($result)) {
            $name=$row['cat_name'];
            $desc=$row['cat_desc'];
        }
    
    ?>
    <div class="container" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
        <div class="container my-4">
            <div class="jumbotron">
                <h1 class="display-4">Welcome to <?php echo $name; ?> Forum</h1>
                <p class="lead my-4"><?php echo $desc; ?></p>
                <hr class="my-4">
                <p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item  bg-secondary"><strong>Rules of iDiscuss Forum</strong></li>
                    <li class="list-group-item bg-secondary">No Spam / Advertising / Self-promote in the forums</li>
                    <li class="list-group-item bg-secondary">Do not post copyright-infringing material.</li>
                    <li class="list-group-item bg-secondary">Do not post “offensive” posts, links or images</li>
                    <li class="list-group-item bg-secondary">Remain respectful of other members at all times</li>
                </ul>
                </p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </div>
        </div>
        <div class="container my-3">
            <?php
            
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
                echo '<h2 class="text-center py-4 bg-secondary">Start Discussion</h2>
            <form style="display:grid;" action="threadlist.php?catid='.$id.'" method="post">
                <div class="form-group">
                    <label for="inputEmail4" class="text-center"><b>Problem in brief</b></label>
                    <input type="text" class="form-control" id="title" name="title"
                        placeholder="Make title short and crispy"
                        style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                </div>
                <div class="form-group">
                    <label for="inputAddress"><b>Ellobrate your Problem</b></label>
                    <textarea type="text" class="form-control" id="desc" name="desc" placeholder="Describe your problem"
                        style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"></textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">Add
                    Question</button>
            </form>';
            } else {
                echo '<h3 class="text-center py-4 bg-danger">Login to Start Discussion</h3>';
            }
            
            
            ?>
            
        </div>



        <div class="container my-4">
            <h2 class="text-center py-4 bg-secondary">Browse Question</h2>
            <?php
        $id=$_GET['catid'];
        $sql="SELECT * FROM `thread` WHERE `thread_cat_id` = $id";
        $result=mysqli_query($conn,$sql);
        $noResult=true;
        while ($row=mysqli_fetch_assoc($result)) {
            $noResult=false;
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $id=$row['thread_id'];
            $time=$row['ctime'];
            $thread_user_id=$row['thread_user_id'];
            
            if ($id%2==0) {
                $gender="men";
            } else {
                $gender="women";
            }
            $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $useremail=$row2['user_email'];
                
                
                echo'<div class="media-body" style="display: flex;">
                <div >
                <img src="https://randomuser.me/api/portraits/'.$gender.'/'.$id.'.jpg" height=90px class="mr-3" alt="...">
                </div>
                <div style="display: grid;">
                <div class="media-body">
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                '.$desc.'.
                </div>
                <h5 style="display: flex; justify-content:right;"><b>'.$useremail.' at '.$time.'</b></h5>
                </div>
                </div>
                <hr>';
            
    }
    if ($noResult==true) {
        echo '<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">No thread found</h1>
    <p class="lead">Be the first person to ask a question.</p>
  </div>
</div>';
    }
?>

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