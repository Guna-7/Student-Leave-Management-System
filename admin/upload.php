<?php
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','elms');

// Establish database connection.
try {
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

// Check if file is uploaded
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Define upload directory
    $uploadDir = 'C:/xampp-1/htdocs/elms/admin/uploads/';

    // Create the uploads directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate unique file name
    $fileName = uniqid() . '_' . $_FILES['file']['name'];

    // Move uploaded file to the upload directory
    $uploadPath = $uploadDir . $fileName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
        // Store file information in the database
        $file_name = $_FILES['file']['name'];
        $file_path = $uploadPath;

        // Prepare SQL statement to insert file information
        $sql = "INSERT INTO uploaded_files (file_name, file_path) VALUES (:file_name, :file_path)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':file_name', $file_name);
        $stmt->bindParam(':file_path', $file_path);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "File uploaded successfully.";
        } else {
            echo "Error: Unable to insert file details into database.";
        }
    } else {
        echo "Error: Failed to move uploaded file.";
    }
} else {
    echo "Error: Failed to upload file. Error code: ".$_FILES['file']['error'];
}
?>
