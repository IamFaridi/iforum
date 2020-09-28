<?php

    if($_SERVER['REQUEST_METHOD']=='POST'){
        include '_dbconnect.php';
        $emailSignup=$_POST['signupemail'];
        $emailSignup=str_replace('<','&lt',$emailSignup);
        $emailSignup=str_replace('>','&gt',$emailSignup);
        $passwordSignup=$_POST['signuppassword'];
        $cpassword=$_POST['cpassword'];

        $existSql="SELECT * FROM `users` WHERE `user_email` LIKE '$emailSignup'";
        $result=mysqli_query($conn,$existSql);
        $num=mysqli_num_rows($result);
        if ($num>0 ) {
            header("location: http://localhost/iForum/index.php?repeat=true");
        } else {
            if ($passwordSignup==$cpassword) {
                $hash=password_hash($passwordSignup,PASSWORD_DEFAULT);
                $sql="INSERT INTO `users` (`user_email`, `user_pass`, `signup_time`) VALUES ('$emailSignup', '$hash', current_timestamp());";
                $result=mysqli_query($conn,$sql);
                if ($result) {
                    header("location: http://localhost/iForum/index.php?signup=true");
                }
            } else {
                header("location: http://localhost/iForum/index.php?passerror=true");
                
            }
            
        }
        
        
    }

?>