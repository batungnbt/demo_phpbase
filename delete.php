<?php
require_once "connect_db.php";

if (!empty($_GET['id'])) {
    $sql = 'DELETE FROM employees WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id',$_GET['id']);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Successfully deleted";
        header('location:index.php');
        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }
} else {
    header('location:index.php');
}

?>