<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else {
    // Handle adding a single student
    if(isset($_POST['add'])) {
        
        $empid = $_POST['empcode'];
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];   
        $email = $_POST['email']; 
        $password = md5($_POST['password']); 
        $gender = $_POST['gender']; 
        $dob = $_POST['dob']; 
        $class = $_POST['class']; 
        $address = $_POST['address']; 
        $city = $_POST['city']; 
        $country = $_POST['country']; 
        $mobileno = $_POST['mobileno']; 
        $status = 1;

        $sql = "INSERT INTO tblemployees (EmpId, FirstName, LastName, EmailId, Password, Gender, Dob, `class_id`, Address, City, Country, Phonenumber, Status) 
                VALUES (:empid, :fname, :lname, :email, :password, :gender, :dob, :class, :address, :city, :country, :mobileno, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':class', $class, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId) {
            $msg = "Student record added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
}
        // Your existing code to add a single student goes here
        // ...
    

    // Handle file export/update
    if(isset($_POST['export'])) {
        // Retrieve the Excel file content from the database if any
        $sql = "SELECT excel_file FROM tblemployees WHERE excel_file IS NOT NULL";
        $query = $dbh->prepare($sql);
        $query->execute();
        $excelData = $query->fetchAll(PDO::FETCH_ASSOC);

        // Code to update the Excel file goes here
        // You need to write code to update the existing Excel file or create a new one
        // based on your requirements and the form data
        // Ensure to handle file upload and data processing here

        // Once the Excel file is updated, you can provide it for download
        // Here, you need to implement code to generate the Excel file
        // and provide it for download, based on the updated data
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin | Add student</title>
    
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
</head>
<body>
    <!-- Header and Sidebar -->
    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title" style="color: silver;">Add Student</div>
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
                                                    <?php if($error) { ?>
                                                        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                                                    <?php } else if($msg) { ?>
                                                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                                                    <?php } ?>
                                                    <div class="input-field col  s12">
                                                        <label for="empcode">Student REG no(Must be unique)</label>
                                                        <input  name="empcode" id="empcode" onBlur="checkAvailabilityEmpid()" type="text" autocomplete="off" required>
                                                        <span id="empid-availability" style="font-size:12px;"></span> 
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="firstName">First name</label>
                                                        <input id="firstName" name="firstName" type="text" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="lastName">Last name</label>
                                                        <input id="lastName" name="lastName" type="text" autocomplete="off" required>
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

                                            <div class="col m6">
                                                <div class="row">
                                                    <div class="input-field col m6 s12">
                                                        <select name="gender" autocomplete="off">
                                                            <option value="">Gender...</option>                                          
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="birthdate">Birthdate</label>
                                                        <input id="birthdate" name="dob" type="date" class="datepicker" autocomplete="off">
                                                    </div>

                                                    <div class="input-field col m6 s12">
    <select name="class" autocomplete="off">
        <option value="">Select Class</option>
        <?php 
        // Fetch class data from the database
        $sql = "SELECT * FROM classes";
        $query = $dbh->prepare($sql);
        $query->execute();
        $classes = $query->fetchAll(PDO::FETCH_ASSOC);

        // Check if classes exist
        if($query->rowCount() > 0) {
            foreach($classes as $class) { ?>
                <option value="<?php echo htmlentities($class['class_id']); ?>"><?php echo htmlentities($class['class_name']); ?></option>
            <?php } 
        }
        ?>
    </select>
    <label>Select Class</label>
</div>


                                                    <div class="input-field col m6 s12">
                                                        <label for="country">Country</label>
                                                        <input id="country" name="country" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="city">City/Town</label>
                                                        <input id="city" name="city" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="address">Address</label>
                                                        <input id="address" name="address" type="text" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="phone">Mobile number</label>
                                                        <input id="phone" name="mobileno" type="tel" maxlength="10" autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12" style="margin-top: 30px;">
                                                        <button type="submit" name="add" onclick="return valid();" id="add" class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col m6">
                                                <div class="row">
                                                    <!-- Bulk student addition form -->
                                                    <div class="col s12">
                                                        <div class="card">
                                                      
                                                            
                                                        </div>
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
<?php
  ?>