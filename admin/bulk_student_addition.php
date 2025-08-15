<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else {
    // Handle adding multiple students through Excel sheet
    if(isset($_POST['add_multiple'])) {
        // Check if file is uploaded successfully
        if(isset($_FILES['excel']['name']) && $_FILES['excel']['name'] != '') {
            // Process the Excel file
            require 'PHPExcel/PHPExcel.php';

            $inputFileType = PHPExcel_IOFactory::identify($_FILES['excel']['tmp_name']);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($_FILES['excel']['tmp_name']);

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // Get the last inserted ID
            $lastInsertIdQuery = "SELECT MAX(id) as max_id FROM tblemployees";
            $stmt = $dbh->prepare($lastInsertIdQuery);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastId = $result['max_id'];

            // Loop through each row in the Excel file
            for($row = 2; $row <= $highestRow; $row++) { // Assuming first row is header
                // Get data from each column
                $empid = $sheet->getCellByColumnAndRow(0, $row)->getValue();
                $fname = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                $lname = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                $email = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                $password = md5($sheet->getCellByColumnAndRow(4, $row)->getValue());
                $gender = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                $dob = $sheet->getCellByColumnAndRow(6, $row)->getValue();
                $class = $sheet->getCellByColumnAndRow(7, $row)->getValue();
                $address = $sheet->getCellByColumnAndRow(8, $row)->getValue();
                $city = $sheet->getCellByColumnAndRow(9, $row)->getValue();
                $country = $sheet->getCellByColumnAndRow(10, $row)->getValue();
                $mobileno = $sheet->getCellByColumnAndRow(11, $row)->getValue();
                $status = 1;

                $currentDate = date('Y-m-d');

                $lastId++;
                
                // Insert data into database with default values for class_name and staff_id
                $sql = "INSERT INTO tblemployees (id, EmpId, FirstName, LastName, EmailId, Password, Gender, Dob, class_id, class_name, staff_id, Address, City, Country, Phonenumber, Status, RegDate) 
                        VALUES (:id, :empid, :fname, :lname, :email, :password, :gender, :dob, :class, :class_name, :staff_id, :address, :city, :country, :mobileno, :status, :regDate)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':id', $lastId, PDO::PARAM_INT);
                $query->bindParam(':empid', $empid, PDO::PARAM_STR);
                $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                $query->bindParam(':lname', $lname, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':password', $password, PDO::PARAM_STR);
                $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                $query->bindParam(':class', $class, PDO::PARAM_STR);
                $query->bindValue(':class_name', 'Nil', PDO::PARAM_STR); // Default value for class_name
                $query->bindValue(':staff_id', 'Nil', PDO::PARAM_STR); // Default value for staff_id
                $query->bindParam(':address', $address, PDO::PARAM_STR);
                $query->bindParam(':city', $city, PDO::PARAM_STR);
                $query->bindParam(':country', $country, PDO::PARAM_STR);
                $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
                $query->bindParam(':status', $status, PDO::PARAM_INT);
                $query->bindParam(':regDate', $currentDate, PDO::PARAM_STR);
                $query->execute();
            }
            $msg = "Students added successfully";
        } else {
            $error = "Please select a file to upload";
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Add Multiple Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
            <meta charset="UTF-8" />
            <meta name="description" content="Responsive Admin Dashboard Template" />
            <meta name="keywords" content="admin,dashboard" />
            <meta name="author" content="Steelcoders" />
            
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
</style>

</head>
<body>
    <!-- Header and Sidebar -->
    <?php include('includes/header.php');?>
    <?php include('includes/sidebar.php');?>
    
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title" style="color: silver;">Add Multiple Students</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addMultipleStudents" enctype="multipart/form-data">
                            <div>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <?php if($error) { ?>
                                                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
                                                <?php } ?>
                                                <?php if($msg) { ?>
                                                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
                                                <?php } ?>

                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <span>Upload Excel File</span>
                                                        <input type="file" name="excel" required>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text">
                                                    </div>
                                                </div>

                                                <div class="input-field col s12" style="margin-top: 30px;">
                                                    <button type="submit" name="add_multiple" class="waves-effect waves-light btn indigo m-b-xs">Add Multiple Students</button>
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

    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>
    
</body>
</html>
