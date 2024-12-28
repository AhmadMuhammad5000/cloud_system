<?php
require_once 'session.php';
require_once 'db/db.php';

// phpini
ini_set("upload_max_filesize", '10MB');
ini_set("post_max_size", '10MB');
ini_set("memory_limit", '16M');

// Function to encrypt the file content
function encryptFileContent($fileContent)
{
    $secret = "12erww++@g.;xLL;ffpdcvv123409-@@"; // Retrieve key from .env file
    if (!$secret || strlen($secret) !== 32) {
        throw new Exception("Invalid or missing encryption key.");
    }

    $iv = openssl_random_pseudo_bytes(16); // Generate random IV
    $encryptedContent = openssl_encrypt($fileContent, 'aes-256-cbc', $secret, OPENSSL_RAW_DATA, $iv);
    if ($encryptedContent === false) {
        throw new Exception("Encryption failed.");
    }

    // Return Base64-encoded IV + Encrypted content for storage
    return base64_encode($iv . $encryptedContent);
}

// Function to save the file in database
function savetoDb($uid, $fileName, $fileType)
{
    try {
        global $conn;
        $sql = $conn->prepare("INSERT INTO files(userid, file_name, file_type) VALUES (?,?,?)");
        $sql->bind_param("iss", $uid, $fileName, $fileType);
        $sql->execute();

        if ($sql) {
            return true;
        }
        return;
    } catch (Exception $e) {
        throw new Exception("Something went wrong !" . $e->getMessage());
    }
}

// Handle the file upload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upload"])) {
    $allowedExtensions = ["txt", "pdf", "xlsx", "xls", "docx", "doc", "sql", "mp3", "mp4"];
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    // Validate file extension
    if (!in_array($fileType, $allowedExtensions)) {
        echo "<script>alert('Invalid file type!'); location.href='upload.php';</script>";
        exit();
    }

    // Define storage paths
    $directories = [
        "txt" => "Files/doc/",
        "pdf" => "Files/doc/",
        "xlsx" => "Files/doc/",
        "xls" => "Files/doc/",
        "doc" => "Files/doc/",
        "docx" => "Files/doc/",
        "sql" => "Files/doc/",
        "mp3" => "Files/mp3/",
        "mp4" => "Files/mp4/"
    ];

    $destinationDir = $directories[$fileType] ?? 'Files/';

    // Read file content
    $fileContent = file_get_contents($file['tmp_name']);
    if ($fileContent === false) {
        echo "<script>alert('Failed to read file!'); location.href='upload.php';</script>";
        exit();
    }

    // Encrypt file content (only for allowed document types)
    if (in_array($fileType, ["txt", "pdf", "xlsx", "xls", "docx", "doc", "sql"])) {
        try {
            $fileContent = encryptFileContent($fileContent);
        } catch (Exception $e) {
            error_log("Encryption error: " . $e->getMessage());
            echo "<script>alert('File encryption failed!'); location.href='upload.php';</script>";
            exit();
        }
    }

    // Define full destination path
    $destination = $destinationDir . $fileName;

    // Save the file
    if (file_put_contents($destination, $fileContent) !== false) {
        echo "<script>alert('File uploaded and saved successfully!'); </script>";
        // Inserting to database
        $save = savetoDb($_SESSION['userid'], $fileName, $fileType);
        if (!$save) {
            throw new Exception("Not inserted to db !");
            echo "<script>alert('Failed to save the file to database!')</script>";
        }

        echo "<script> location.href='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Failed to save the file!'); location.href='upload.php';</script>";
    }
}
