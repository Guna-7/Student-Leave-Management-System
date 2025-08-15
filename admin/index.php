<?php
session_start();
include('includes/config.php');
if(isset($_POST['signin']))
{
    $uname=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        $_SESSION['alogin']=$_POST['username'];
        echo "<script type='text/javascript'> document.location = 'changepassword.php'; </script>";
    }
    else
    {
        $sql ="SELECT Email,Password,id FROM tblstaff WHERE Email=:uname and Password=:password";
        $query= $dbh -> prepare($sql);
        $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
        $query-> bindParam(':password', $password, PDO::PARAM_STR);
        $query-> execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $staffid = 0;
        if($query->rowCount() > 0)
        {
            foreach ($results as $result) {
                $staffid=$result->id;
                $_SESSION['eid']=$result->id;
            }
        }  
        if($staffid != 0)
        {   
            $_SESSION['alogin']=$_POST['username'];
            echo "<script type='text/javascript'> document.location = 'staff-change-password.php'; </script>";
        }
        else{
            $sql ="SELECT EmailId,Password,Status,id FROM tblemployees WHERE EmailId=:uname and Password=:password";
            $query= $dbh -> prepare($sql);
            $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
            $query-> bindParam(':password', $password, PDO::PARAM_STR);
            $query-> execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $status=0;
            if($query->rowCount() > 0)
            {
            foreach ($results as $result) {
                $status=$result->Status;
                $_SESSION['eid']=$result->id;
            } 
    
            }
            if($status==0)
            {
            $msg="Your account is Inactive. Please contact admin";
            echo "<script>alert('Invalid details');</script>";
            }
    
            else{
            $_SESSION['emplogin']=$_POST['username'];
            echo "<script type='text/javascript'> document.location = 'emp-changepassword.php'; </script>";
            } 
        }
    
    }    
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>Student Leave management system |  Admin</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">        
      
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <style>
             #one{
        background-color: #2a2a2a;
        background-size: 100%;
    }
        
        body {
            background-color: #2a2a2a;
        }
        .background {
            background-color: 	#282828; /* light red color */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Ensure the background is behind other content */
        }
        .h4{
            font-color: #20b2aa;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    </head>
    <body>
    <div class="background"></div>
<nav class="navbar navbar-expand-lg navbar-light py-3"style="background-color: #20b2aa;">
          <button class="navbar-toggler"style="background-color: #20b2aa;"type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse d-flex justify-content-center align-items-center" id="navbarNavAltMarkup">
          <div class="navbar-nav d-flex justify-content-center align-items-center">
            <!-- <a class="nav-item text-white font-weight-bold nav-link active ml-3" href="#">Home <span class="sr-only">(current)</span></a> -->
            
		
        </nav>
            <main class="mn-inner mt-5">
                <div class="row d-flex justify-content-center align-items-center">
        <h4  style="font-color:#20b2aa;text-align: center; font-family: MinecrafterReg">WELCOME</h4>
        <br>

        
                    <div class="col-md-12">
                         <div class="row" >
    <div class="col-md-3"></div>
                          <div class="col-md-6 d-flex justify-content-center align-items-center">
                              <div class="card white darken-1">
                                  <div class="card-content">
                                      <span class="card-title text-danger" style="font-size:20px;">Login</span>
                                       <div class="row">
                                           <form class="col s12" name="signin" method="post">
                                               <div class="input-field col s12">
                                                   <input id="username" type="text" name="username" class="validate" autocomplete="off" required >
                                                   <label for="email">Enter Username</label>
                                               </div>
                                               <div class="input-field col s12">
                                                   <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                                   <label for="password">Enter Password</label>
                                               </div>
                                               <div class="col s12 center m-t-sm">
                                                
                                                   <input type="submit" name="signin" value="Login" class="waves-effect waves-light btn teal">
                                               </div>
                                           </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </main>
        
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
     </section>   
    </body>
</html>