<?php
session_start();
include('includes/config.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Debugging: Check if empid is set correctly
if(!isset($_GET['empid']) || empty($_GET['empid'])) {
    echo "Employee ID not provided.";
    exit(); // Stop further execution
}

$empid = $_GET['empid'];

// Fetch student details for editing
$sql = "SELECT * FROM tblemployees WHERE EmpId = :empid";
$query = $dbh->prepare($sql);
$query->bindParam(':empid', $empid, PDO::PARAM_STR);
$query->execute();
$student = $query->fetch(PDO::FETCH_ASSOC);

if(!$student) {
    echo "Student not found.";
    exit(); // Stop further execution
}

// Process form submission
if(isset($_POST['update'])) {
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $class_name = $_POST['class_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Update student details in the database
    $sql = "UPDATE tblemployees SET FirstName = :fname, LastName = :lname ,class_name = :class_name, Address = :address, City = :city, Country = :country WHERE EmpId = :empid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':lname', $lname, PDO::PARAM_STR);
    $query->bindParam(':class_name', $class_name, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':country', $country, PDO::PARAM_STR);
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->execute();

    // Check if update was successful
    if($query->rowCount() > 0) {
        $success_message = "Student details updated successfully.";
    } else {
        $success_message = "No changes made or an error occurred while updating student details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
         <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
  <style>
   .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #000; /* Change background color to black */
            color: #fff; /* Change text color to white */
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }



</style>

    </head>
    <body>
  <?php include('stf/header.php');?>
            
       <?php include('stf/sidebar.php');?>
    
   <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Update Student</div>
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <form id="example-form" method="post" name="updatemp">
                                    

   
    <?php if(isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlentities($student['FirstName']); ?>" required>
        <br>
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlentities($student['LastName']); ?>" required>
        <br>
        <label for="class_name">Class Name:</label>
        <input type="text" id="class_name" name="class_name" value="<?php echo htmlentities($student['class_name']); ?>" required>
        <br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlentities($student['Address']); ?>" required>
        <br>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlentities($student['City']); ?>" required>
        <br>
        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo htmlentities($student['Country']); ?>" required>
        <br>
        <!-- Add other input fields for editing -->
        <input type="submit" name="update" value="Update">
    </form>
    
    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                     
                                    
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
