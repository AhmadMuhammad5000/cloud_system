<?php require_once 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/CloudSystem/CSS/bootstrap-5.1.3-dist/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/CloudSystem/CSS/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="CSS/header.css">
    <title>Header</title>
</head>

<body>
    <div class="header shadow">
        <ul class="ul mt-2">
            <div class="">
                <h2>Secure Cloud <em>System</em> </h2>
            </div>

            <span class="d-flex"><i class="fa fa-dashboard me-2 d-flex align-items-center"></i>
                <li><a href="dashboard.php">Dashboard</a></li>
            </span>
            <span class="d-flex"><i class="fa fa-upload me-2 d-flex align-items-center"></i>
                <li><a href="upload.php">Upload to cloud</a></li>
            </span>
            <span class="d-flex"><i class="fa fa-close me-2 d-flex align-items-center"></i>
                <li><a href="logout.php">Logout</a></li>
            </span>
        </ul>

    </div>
</body>

</html>