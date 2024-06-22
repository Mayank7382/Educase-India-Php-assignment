<?php
include 'db.php';

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
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES ('$name', '$email', '$address', '$class_id', '$image')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            $error = "Error creating record: " . $conn->error;
        }
    }
}

// Array to hold class options
$classes = range(1, 12);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h1>Create Student</h1>
    <form action="create.php" method="post" enctype="multipart/form-data">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Address: <textarea name="address" rows="4" required></textarea><br>
        Class: 
        <select name="class_id" required>
            <?php foreach ($classes as $class) { ?>
                <option value="<?php echo $class; ?>"><?php echo "Grade $class"; ?></option>
            <?php } ?>
        </select><br>
        Image: <input type="file" name="image" required><br>
        <input type="submit" value="Create">
    </form>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
</body>
</html>
<?php
$conn->close();
?>
