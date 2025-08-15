<?php
// Include database connectivity code
include('includes/config.php');

$msg = ''; // Initialize message variable

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $class_id = $_POST['class_id'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $class_name = $_POST['class_name'];

    // Prepare and execute SQL query to update data in the classes table
    $sql = "UPDATE classes SET year=:year, section=:section, class_name=:class_name WHERE class_id=:class_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':year', $year, PDO::PARAM_INT);
    $query->bindParam(':section', $section, PDO::PARAM_STR);
    $query->bindParam(':class_name', $class_name, PDO::PARAM_STR);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $query->execute();

    $msg = "Class updated successfully";
}

// Fetch class details based on class ID passed in URL
if(isset($_GET['id'])) {
    $class_id = $_GET['id'];
    $sql = "SELECT * FROM classes WHERE class_id=:class_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $query->execute();
    $class = $query->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Class</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Class</h2>
    <?php if($msg != '') echo '<p>' . $msg . '</p>'; ?>
    <form method="post">
        <input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">

        <label for="year">Year:</label>
        <input type="text" id="year" name="year" value="<?php echo $class['year']; ?>" required>

        <label for="section">Section:</label>
        <input type="text" id="section" name="section" value="<?php echo $class['section']; ?>" required>

        <label for="class_name">Class Name:</label>
        <input type="text" id="class_name" name="class_name" value="<?php echo $class['class_name']; ?>" required>

        <input type="submit" name="submit" value="Update Class">
    </form>
</div>

</body>
</html>
