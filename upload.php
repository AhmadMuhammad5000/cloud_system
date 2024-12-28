<?php require_once 'session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/upload.css">

  <title>Upload</title>

  <style>
    form {
      background-color: white;
      height: 30vh;
      padding: 4%;
      z-index: 11;
      margin: 0 auto;
    }
  </style>
</head>

<body>
  <?php require_once 'header.php'; ?> <br>
  <div class="contaner-fluid">
    <div class="upload">
      <p align="center"><b>Upload any file of type : .pdf, .exsl, .docx, .mp3, .mp4, .txt securely</b></p>

      <form class="form-control w-50 shadow" method="POST" action="phpupload.php" enctype="multipart/form-data">
        <h3 style="color: skyblue;">Upload your file</p>
          <div class="">
            <label for="file"></label>
            <input type="file" name="file" id="file" class="form-control w-50" required>
            <button class="btn btn-primary mt-2" name="upload"> Upload </button>
          </div>
      </form>
    </div>

    <!-- <div class="brief">
      <p> </p>
   </div> -->

  </div>

</body>

</html>