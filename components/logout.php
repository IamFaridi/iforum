<?php

    session_start();
    session_unset();
    session_destroy();
    header("location: http://localhost/iForum/index.php?logout=true");
    

?>