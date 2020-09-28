<?php
        session_start();
        
echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">iDiscuss</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Category
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

                    $sql="SELECT * FROM `category`"; 
                    $result=mysqli_query($conn,$sql);
                    while ($row=mysqli_fetch_assoc($result)) {
                        echo '<a class="dropdown-item" href="http://localhost/iforum/threadlist.php?catid='.$row['cat_id'].'">'.$row['cat_name'].'</a>';
                    }
                        
                    echo '</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
            </ul>';
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']=true) {
            
                echo '<form class="form-inline my-2 my-lg-0" method="get" action="search.php">
                <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0 mr-4" type="submit">Search</button>
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.$_SESSION['useremail'].'
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button" onclick="window.location.href=\'components/logout.php\'">Logout</button>
                    </div>
                </div>
                </form>';
            } else{

                echo '<form class="form-inline my-2 my-lg-0" method="get" action="search.php">
                <input class="form-control mr-sm-2" type="text" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0 mr-4" type="submit">Search</button>
                <button class="btn btn-outline-success my-2 my-sm-0 mr-1" type="button" data-toggle="modal" data-target="#loginModal">Login</button>
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="modal" data-target="#signupModal">Signup</button>
                </form>';
            }
            
        echo '</div>
    </nav>';

    include '_signup.php';
    include '_login.php';

    if (isset($_GET['signup'])&& $_GET['signup']==true) {
        echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                     <strong>Success!</strong> You successfully created account.Now you can Login.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }
    if (isset($_GET['repeat'])&& $_GET['repeat']==true) {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                     <strong>Failed!</strong> Email address already registered.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }
    if (isset($_GET['passerror'])&& $_GET['passerror']==true) {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                     <strong>Failed!</strong> Passwords doesn\'t match. Please try again.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }
    if (isset($_GET['login'])&& $_GET['login']==true) {
        echo '<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                     <strong>Success!</strong> You successfully Logged in.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }
    if (isset($_GET['wrongpass'])&& $_GET['wrongpass']==true) {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                     <strong>Failed!</strong> You entered a wrong password.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }
    if (isset($_GET['noemail'])&& $_GET['noemail']==true) {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                     <strong>Failed!</strong> Email address doesn\'t exist.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }

    if (isset($_GET['logout'])&& $_GET['logout']==true) {
        echo '<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                     <strong>Success</strong> You\'ve been Logout.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                  </div>';
        }

?>