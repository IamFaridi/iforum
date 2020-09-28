<?php
    if ($_SESSION['']) {
        # code...
    }

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        include '_dbconnect.php';
        $loginEmail=$_POST['loginemail'];
        $loginpass=$_POST['loginpass'];
        $sql="SELECT * FROM `users` WHERE `user_email` LIKE '$loginEmail'";
        $result=mysqli_query($conn,$sql);
        
        if ($row=mysqli_fetch_assoc($result)) {
            if (password_verify($loginpass,$row['user_pass'])) {
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['useremail']=$loginEmail;
                header("location: http://localhost/iForum/index.php?login=true");
            }else {
                header("location: http://localhost/iForum/index.php?wrongpass=true");
            }
        }
        else {
            header("location: http://localhost/iForum/index.php?noemail=true");
        }

    }
    

?>