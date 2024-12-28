<?php require_once 'session.php';
require_once 'db/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/CloudSystem/CSS/bootstrap-5.1.3-dist/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/CloudSystem/CSS/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/dashboard.css">

    <title>Dashboard</title>

    <style>
        body {
            background-color: #eee;
        }

        table {
            background-color: white;
            padding: 1%;
            z-index: 11;
            width: 30%;
        }
    </style>
</head>

<body>
    <?php require_once "header.php"; ?>

    <div class="all">
        <!-- Body -->
        <div class="bodyfirst container mt-3 shadow rounded">
            <div class="">
                <table class="table w-75">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Files</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // Fetching the files
                        $sql = $conn->prepare("SELECT * FROM files WHERE userid=?");
                        $sql->bind_param("i", $_SESSION['userid']);
                        $sql->execute();

                        $res = $sql->get_result();
                        if ($res->num_rows > 0) {
                            while ($fetch = $res->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $fetch['id']; ?></td>
                                    <td><?php echo $fetch['file_name']; ?></td>
                                    <td><?php echo $fetch['file_type']; ?></td>
                                    <td><button class="btn btn-primary p-0"><a class="nav-link text-light" href="download.php?id=<?php echo $fetch['id']; ?>">Download</a></button></td>
                                </tr>
                            <?php
                            }
                        } else { ?>
                            <div class="all">
                                <!-- Body -->
                                <div class="body container mt-3 rounded">
                                    <div class="">
                                        <p>You have not uploaded any of your files !</p>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

</body>

</html>