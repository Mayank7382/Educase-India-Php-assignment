<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];
    $sql = "INSERT INTO classes (name) VALUES ('$name')";
    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id']) && isset($_POST['edit_name'])) {
    $class_id = $_POST['class_id'];
    $edit_name = $_POST['edit_name'];
    $sql = "UPDATE classes SET name='$edit_name' WHERE class_id=$class_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_class_id'])) {
    $delete_class_id = $_POST['delete_class_id'];
    $sql = "DELETE FROM classes WHERE class_id=$delete_class_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM classes";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Manage Classes</h1>
    <form action="classes.php" method="post">
        Name: <input type="text" name="name">
        <input type="submit" value="Add Class">
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['class_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <form action="classes.php" method="post" style="display:inline;">
                        <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                        <input type="text" name="edit_name" value="<?php echo $row['name']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                    <form action="classes.php" method="post" style="display:inline;">
                        <input type="hidden" name="delete_class_id" value="<?php echo $row['class_id']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="index.php">Back to Home</a>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
<?php
$conn->close();
?>
