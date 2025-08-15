<!DOCTYPE html>
<html>
<head>
    <title>Admin - Download Uploaded Files</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
        }

        .file-link {
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Download Uploaded Files</h2>
        <?php
        // DB credentials.
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'elms');

        // Establish database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }

        // Query to select uploaded files
        $sql = "SELECT id, file_name, file_path FROM uploaded_files";
        $stmt = $dbh->query($sql);

        if ($stmt->rowCount() > 0) {
            // Output links for downloading files
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $file_name = $row["file_name"];
                $file_path = $row["file_path"];
                echo "<a href='download.php?file_path=" . urlencode($file_path) . "' class='file-link' download>$file_name</a>";
            }
        } else {
            echo "<p>No files uploaded yet.</p>";
        }
        ?>
    </div>
</body>
</html>
