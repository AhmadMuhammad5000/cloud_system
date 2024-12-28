<?php 
require_once 'session.php'; 
require_once 'db/db.php';

// Function to download the files
function download($fileName, $fileType, $fileContent) {
    // Set headers for file download
    header("Content-Type: application/" . $fileType);
    header("Content-Disposition: attachment; filename=" . basename($fileName));
    header("Content-Length: " . strlen($fileContent));

    // Output the file content
    echo $fileContent;
    exit; // End the script to ensure no additional output
}

// Function to decrypt the file content
function decryptFile($fileContent) {
    $secret = "12erww++@g.;xLL;ffpdcvv123409-@@"; // Retrieve key from .env file
    if (!$secret || strlen($secret) !== 32) {
        throw new Exception("Invalid or missing encryption key.");
    }

    // Extract the IV and encrypted content from the input
    $decodedContent = base64_decode($fileContent); // Assuming content is Base64-encoded
    $iv = substr($decodedContent, 0, 16); // IV is the first 16 bytes
    $encryptedData = substr($decodedContent, 16);

    // Decrypt the content
    $decryptedContent = openssl_decrypt($encryptedData, 'aes-256-cbc', $secret, OPENSSL_RAW_DATA, $iv);
    if ($decryptedContent === false) {
        throw new Exception("Decryption failed.");
    }

    return $decryptedContent;
}

// Main logic
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the specific file from the database
    $sql = $conn->prepare("SELECT * FROM files WHERE userid = ? AND id = ?");
    $sql->bind_param('ii', $_SESSION['userid'], $id); // Bind both user ID and file ID
    $sql->execute();

    $rs = $sql->get_result();
    if ($rs->num_rows > 0) {
        $fetch = $rs->fetch_assoc();

        $fileName = $fetch['file_name'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); // Ensure correct extension

        // Different destinations
        $destination = [
            "txt" => "Files/doc/" . $fileName,
            "pdf" => "Files/doc/" . $fileName,
            "xlsx" => "Files/doc/" . $fileName,
            "xls" => "Files/doc/" . $fileName,
            "doc" => "Files/doc/" . $fileName,
            "docx" => "Files/doc/" . $fileName,
            "sql" => "Files/doc/" . $fileName,
            "mp3" => "Files/mp3/" . $fileName,
            "mp4" => "Files/mp4/" . $fileName
        ];

        $fileContent = file_get_contents($destination[$fileType]);

        try {
            // Check file type
            if (in_array($fileType, ["mp3", "mp4"])) {
                // Skip decryption for mp3 and mp4
                download($fileName, $fileType, $fileContent);
            } else {
                // Decrypt and download for other types
                $decryptedContent = decryptFile($fileContent);
                download($fileName, $fileType, $decryptedContent);
            }
        } catch (Exception $e) {
            echo '<script> alert("Error: ' . $e->getMessage() . '"); </script>';
            echo '<script> window.location.href = "dashboard.php"; </script>';
        }
    } else {
        echo '<script> alert("File not found!"); </script>';
        echo '<script> window.location.href = "dashboard.php"; </script>';
    }
}
?>
