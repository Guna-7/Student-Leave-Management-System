<?php
// Include database connectivity code
include('includes/config.php');

$msg = ''; // Initialize message variable

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $year = $_POST['year'];
    $section = $_POST['section'];
    $class_name = $_POST['class_name'];

    // Prepare and execute SQL query to insert data into the classes table
    $sql = "INSERT INTO classes (year, section, class_name) VALUES (:year, :section, :class_name)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    $query->bindParam(':section', $section, PDO::PARAM_STR);
    $query->bindParam(':class_name', $class_name, PDO::PARAM_STR);
    $query->execute();

    $msg = "Class added successfully";
}

// Delete class if 'del' parameter is present in URL
if(isset($_GET['del'])) {
    $class_id = $_GET['del'];
    $sql = "DELETE FROM classes WHERE class_id=:class_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $query->execute();
    $msg = "Class deleted successfully";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
        <link href="../assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet">
        <link href="../assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <style>
 
  
        body {
            font-family: Arial, sans-serif;
            background-color: #2a2a2a;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-links a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<?php include('includes/header.php');?>
            
            <?php include('includes/sidebar.php');?>
     
                 <main class="mn-inner mt-5">

<div class="container">
    <h3>Manage Classes</h3>
    <?php if($msg != '') echo '<p>' . $msg . '</p>'; ?>
    <form method="post">
        <label for="year">Year:</label>
        <input type="text" id="year" name="year" required>

        <label for="section">Section:</label>
        <input type="text" id="section" name="section" required>

        <label for="class_name">Class Name:</label>
        <input type="text" id="class_name" name="class_name" required>

        <input type="submit" name="submit" value="Add Class">
    </form>

    <!-- Display added classes -->
    <?php
    // Retrieve classes from the database
    $sql = "SELECT * FROM classes";
    $stmt = $dbh->query($sql);
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($classes)) {
        echo "<h3>Added Classes</h3>";
        echo "<table>";
        echo "<tr><th>Class ID</th><th>Year</th><th>Section</th><th>Class Name</th><th>Action</th></tr>";
        foreach($classes as $class) {
            echo "<tr>";
            echo "<td>" . $class['class_id'] . "</td>";
            echo "<td>" . $class['year'] . "</td>";
            echo "<td>" . $class['section'] . "</td>";
            echo "<td>" . $class['class_name'] . "</td>";
            echo "<td class='action-links'><a href='edit.php?id=" . $class['class_id'] . "'>Edit</a> | <a href='?del=" . $class['class_id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No classes added yet.</p>";
    }
    ?>
</div>
<div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
        
    </body>
</html>
