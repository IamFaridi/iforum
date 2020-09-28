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

    $alert=false;
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $id=$_GET['threadid'];
        $replycontent=$_POST['replycontent'];
        $replycontent=str_replace('<','&lt',$replycontent);
        $replycontent=str_replace('>','&gt',$replycontent);
        $sql="INSERT INTO `replies` (`reply_content`, `thread_id`, `reply_by`, `reply_time`) VALUES ('$replycontent', '$id', '$usersno', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        if ($result) {
            $alert=true;
        }
    }

?>
    <?php 
        if ($alert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succes!</strong> Your question has been added. Please wait for community to reply.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
        ?>
    <?php require 'components/_dbconnect.php'; ?>
    <?php
        $id=$_GET['threadid'];
        $sql="SELECT * FROM `thread` WHERE `thread_id`=$id";
        $result=mysqli_query($conn,$sql);
        while ($row=mysqli_fetch_assoc($result)) {
            $title=$row['thread_title'];
            $desc=$row['thread_desc'];
            $thread_user_id=$row['thread_user_id'];
        }
        
        ?>

    <div class="container my-3" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
        <div class="container my-4">
            <div class="jumbotron">
                <h1 class="display-4">Question No <?php echo $id;?>. <b><?php echo $title; ?></b></h1>
                <p class="lead my-4"><?php echo $desc; ?></p>
                <p class="text-right">Posted by-<b><?php 
                
                    $sql4="SELECT user_email FROM `users` where sno=$thread_user_id";
                    $result4=mysqli_query($conn,$sql4);
                    $row4=mysqli_fetch_assoc($result4);
                    echo $row4['user_email'];
                ?></b></p>
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
            </div>
        </div>

        <div class="container my-4 mb-4">

            <?php
            
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                    echo '<form action="http://localhost/iForum/thread.php?threadid='.$id.'" method="post">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1"><b>Reply to this Thread<b></label>
                    <textarea class="form-control" id="replycontent" name="replycontent" rows="3"
                        style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>';
            } else {
                   echo '<h3 class="text-center py-4 bg-danger">Login to add reply</h3>';
            }
            

            ?>
            
        </div>

        <div class="container my-4">
            <h2 class="text-center py-4 bg-secondary">Question's Discussion</h2>
            <?php
        $id=$_GET['threadid'];
        $sql="SELECT * FROM `replies` WHERE `thread_id` = $id";
        $result=mysqli_query($conn,$sql);
        $noResult=true;
        while ($row=mysqli_fetch_assoc($result)) {
            $noResult=false;
            $reply=$row['reply_content'];
            $id=$row['reply_id'];
            $time=$row['reply_time'];
            if ($id%2==0) {
                $gender="women";
                $color="warning";
            } else {
                $gender="men";
                $color="danger";
            }
            $reply_by=$row['reply_by'];
            $sql2="SELECT user_email FROM `users` WHERE sno=$reply_by";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $useremail=$row2['user_email'];

                echo '<div class="alert alert-'.$color.' my-4" role="alert">
                <img src="https://randomuser.me/api/portraits/'.$gender.'/'.$id.'.jpg" height=70px class="mr-3" alt="...">
                        '.$useremail.' at '.$time.'
                        <h5 style="display: flex; justify-content: center;">'.$reply.'</h5>
                    </div>';
    }
    if ($noResult==true) {
        echo '<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">No Reply found</h1>
    <p class="lead">Be the first person to reply a question.</p>
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