<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['add'])) {
        $empid = $_POST['empid'];
        $fname = $_POST['firstName'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Hash the password using a secure hashing algorithm
        $dob = $_POST['dob'];
        $designation = $_POST['designation'];

        $sql = "INSERT INTO tblstaff(staff_id, StaffName, Email, Password, DOB, Designation) VALUES(:empid, :fname, :email, :password, :dob, :designation)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empid', $empid, PDO::PARAM_INT);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':designation', $designation, PDO::PARAM_STR);
        
        // Execute the query
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        // Check if the record was added successfully
        if ($lastInsertId) {
            $msg = "Staff record added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Title -->
    <title>Admin | Add Staff</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template"/>
    <meta name="keywords" content="admin,dashboard"/>
    <meta name="author" content="Steelcoders"/>

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
    <style>
         
            body {
            background-color: #2a2a2a;
        }
        
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
    <script type="text/javascript">
        function valid() {
            // Your validation logic goes here
            return true;
        }
    </script>
</head>
<body>
<?php include('includes/header.php'); ?>

<?php include('includes/sidebar.php'); ?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title" style="color: silver;">Add Staff</div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <form id="example-form" method="post" name="addemp">
                        <div>
                            <section>
                                <div class="wizard-content">
                                    <div class="row">
                                        <div class="col m6">
                                            <div class="row">
                                                <?php if ($error) { ?>
                                                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                                                <?php } else if ($msg) { ?>
                                                    <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                                                <?php } ?>

                                                <div class="input-field col s12">
                                                    <label for="empid">Staff ID (Must be unique)</label>
                                                    <input name="empid" id="empid" type="text" autocomplete="off" required>
                                                </div>

                                                <div class="input-field col m6 s12">
                                                    <label for="firstName">Staff name</label>
                                                    <input id="firstName" name="firstName" type="text" required>
                                                </div>
                                                <div class="input-field col s12">
                                                    <label for="dob">Date of Birth</label>
                                                    <input id="dob" name="dob" type="date" class="datepicker" autocomplete="off" required>
                                                </div>

                                                <div class="input-field col s12">
                                                    <label for="designation">Designation</label>
                                                    <input id="designation" name="designation" type="text" autocomplete="off" required>
                                                </div>
                                                
<div class="input-field col s12">
<label for="email">Email</label>
<input  name="email" type="email" id="email" onBlur="checkAvailabilityEmailid()" autocomplete="off" required>
<span id="emailid-availability" style="font-size:12px;"></span> 
</div>

<div class="input-field col s12">
<label for="password">Password</label>
<input id="password" name="password" type="password" autocomplete="off" required>
</div>

<div class="input-field col s12">
<label for="confirm">Confirm password</label>
<input id="confirm" name="confirmpassword" type="password" autocomplete="off" required>
</div>
</div>
</div>
                                            </div>
                                        </div>

                                        <div class="col m6">
                                            <div class="row">
                                                <div class="input-field col s12"
                                                     style="margin-top: 30px;">
                                                    <button type="submit" name="add" onclick="return valid();"
                                                            id="add"
                                                            class="waves-effect waves-light btn indigo m-b-xs">ADD
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
<div class="left-sidebar-hover"></div>

<!-- Javascripts -->
<script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
<script src="../assets/plugins/materialize/js/materialize.min.js"></script>
<script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
<script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="../assets/js/alpha.min.js"></script>
<script src="../assets/js/pages/form_elements.js"></script>

</body>
</html>
<?php  ?>
