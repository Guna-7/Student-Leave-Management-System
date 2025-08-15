<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: grey;
            background-image: url('https://static.vecteezy.com/system/resources/previews/001/879/423/non_2x/upload-file-and-document-to-folders-in-cloud-rental-services-for-hosting-and-domains-digital-storage-service-for-file-transfer-and-data-center-illustration-of-website-banner-software-poster-free-vector.jpg');
            background-size: 100%; /* Adjust as needed */
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .upload-container {
            text-align: center;
            padding: 20px;
        }

        .upload-input {
            display: none;
        }

        .upload-label {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-label:hover {
            background-color: #2980b9;
        }

        .file-name {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1 style="font-family: 'Arial', sans-serif; color: black; text-align: center;">PLEASE UPLOAD YOUR OD FILE HERE! </h1>

    <div class="upload-container">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file-upload" class="upload-label">Choose File</label>
            <input type="file" id="file-upload" name="file" class="upload-input" accept=".jpg, .jpeg, .png, .gif">
            <div class="file-name" id="file-name"></div>
            <button type="submit">Upload</button>
        </form>
    </div>

    <script>
        const fileUploadInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('file-name');

        fileUploadInput.addEventListener('change', function () {
            if (fileUploadInput.files.length > 0) {
                fileNameDisplay.textContent = `Selected File: ${fileUploadInput.files[0].name}`;
            } else {
                fileNameDisplay.textContent = '';
            }
        });
    </script>
</body>
</html>
