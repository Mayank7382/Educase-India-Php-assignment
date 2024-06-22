<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (empty($name)) {
        $error = "Name is required.";
    } elseif ($image && !in_array($imageFileType, array('jpg', 'jpeg', 'png'))) {
        $error = "Only JPG and PNG files are allowed.";
    } else {
        if ($image) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $sql = "UPDATE student SET name='$name', email='$email', address='$address', class_id='$class_id', image='$image' WHERE id=$id";
        } else {
            $sql = "UPDATE student SET name='$name', email='$email', address='$address', class_id='$class_id' WHERE id=$id";
        }
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM student WHERE id=$id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

// Array to hold class options
$classes = range(1, 12);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        Name: <input type="text" name="name" value="<?php echo $student['name']; ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $student['email']; ?>"><br>
        Address: <textarea name="address"><?php echo $student['address']; ?></textarea><br>
        Class: 
        <select name="class_id">
            <?php foreach ($classes as $class) { ?>
                <option value="<?php echo $class; ?>" <?php if ($class == $student['class_id']) echo "selected"; ?>><?php echo "Grade $class"; ?></option>
            <?php } ?>
        </select><br>
        Image: <input type="file" name="image"><br>
        <input type="submit" value="Update">
    </form>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
<?php
$conn->close();
?>
