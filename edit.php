<?php
require_once "connect_db.php";

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM employees WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id',$id);
        if ($stmt->execute()) {
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Something went wrong.Please try again later";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $employee = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'gender' => $_POST['gender'],
        'birthday' => null,
        'address' => null,
        'salary' => $_POST['salary'],
    ];

    if (!empty($_POST['birthday'])) {
        $employee['birthday'] = $_POST['birthday'];
    }

    if (!empty($_POST['address'])) {
        $employee['address'] = $_POST['address'];
    }

    //errors

    if (empty($_POST['name'])) {
        $errors['nameErr'] = "Please enter name";
    }

    if (empty($_POST['gender'])) {
        $errors['genderErr'] = "Please choose gender";
    }

    if (empty($_POST['salary'])) {
        $errors['salaryErr'] = "Please enter salary";
    }

    if (empty($errors)) {
        $sql = "UPDATE employees SET name = :name,gender = :gender,birthday = :birthday,address = :address,salary = :salary  WHERE id = :id";

        if($stmt = $conn->prepare($sql)) {
            if ($stmt->execute($employee)) {
                $_SESSION['message'] = 'Successfully updated';
                header("location:index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            $stmt->close();
            $conn->close();
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Demo PHP base</title>
</head>
<body>
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h4>Update Employee</h4>
        </div>
        <div class="col-12">
            <p class="text-success">
                <?php
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </p>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $employee['id'] ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter full name employee." value="<?php if (!empty($employee['name'])) echo $employee['name'] ?>">
                    <p class="text-danger" style="font-size: 12px"><?php if (!empty($errors['nameErr'])) echo $errors['nameErr'] ?></p>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <div class="form">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="1" <?php if ($employee['gender'] == 1) echo 'checked' ?> >
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="2" <?php if ($employee['gender'] == 2) echo 'checked' ?> >
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="3" <?php if ($employee['gender'] == 3) echo 'checked' ?> >
                            <label class="form-check-label" for="inlineRadio2">Orther</label>
                        </div>
                        <p class="text-danger" style="font-size: 12px"><?php if (!empty($errors['genderErr'])) echo $errors['genderErr'] ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Birthday</label>
                    <input type="date" class="form-control" name="birthday" placeholder="Enter full name employee." value="<?php if (!empty($employee['birthday'])) echo $employee['birthday'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter address employee." value="<?php if (!empty($employee['address']))  echo $employee['address'] ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Salary</label>
                    <input type="number" class="form-control" name="salary" placeholder="Enter saraly employee." value="<?php if (!empty($employee['salary'])) echo $employee['salary'] ?>" >
                    <p class="text-danger" style="font-size: 12px"><?php if (!empty($errors['salaryErr'])) echo $errors['salaryErr'] ?></p>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
