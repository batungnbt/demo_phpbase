<?php
    require_once "connect_db.php";
    $sql = "SELECT * FROM employees ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo PHP base</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-6"><h4>List Employees</h4></div>
        <div class="col-md-6">
            <a href="create.php" class="btn btn-primary">Add New Employee</a></div>
        <div class="col-md-12">
            <p class="text-success">
                <?php
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </p>
            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                <tr>
                    <th>STT</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>Address</th>
                    <th>Salary</th>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>
                <?php
                    if ($result && $stmt->rowCount() > 0) {
                        foreach ($result as $key => $value) { ?>
                            <tr>
                                <td scope="row"><?php echo $key+1 ?></td>
                                <td><?php echo $value['name'] ?></td>
                                <td>
                                    <?php
                                        if ($value['gender'] == 1) echo "Male";
                                        if ($value['gender'] == 2) echo "Female";
                                        if ($value['gender'] == 3) echo "Orther";
                                    ?>
                                </td>
                                <td><?php echo $value['birthday'] ?> </td>
                                <td><?php echo $value['address'] ?> </td>
                                <td><?php echo $value['salary'] ?> </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $value['id'] ?>">Edit</a>
                                    <a href="delete.php?id=<?php echo $value['id'] ?>" onclick="return confirm('Are you sure ?')">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>