<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT image FROM student WHERE id=$id";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();
    unlink("uploads/" . $student['image']);
    
    $sql = "DELETE FROM student WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Delete Student</h1>
    <p>Are you sure you want to delete this student?</p>
    <form action="delete.php?id=<?php echo $id; ?>" method="post">
        <input type="submit" value="Delete">
    </form>
    <a href="index.php">Back to Home</a>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
<?php
$conn->close();
?>
