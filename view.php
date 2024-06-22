<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>View Student</h1>
        <?php
        include 'db.php';

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $student_id = $_GET['id'];

            // Fetch student details with class name
            $sql = "SELECT student.*, classes.name as class_name FROM student LEFT JOIN classes ON student.class_id = classes.class_id WHERE student.id = $student_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
                echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                echo "<p><strong>Class:</strong> " . $row['class_name'] . "</p>"; // Ensure class name is fetched correctly
                echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
                echo "<p><strong>Created At:</strong> " . $row['created_at'] . "</p>";
                echo "<img src='uploads/" . $row['image'] . "' alt='Student Image' width='150'>";
            } else {
                echo "<p>No student found with ID $student_id.</p>";
            }
        } else {
            echo "<p>Invalid student ID.</p>";
        }

        $conn->close();
        ?>
        <a href="index.php" class="btn btn-secondary mt-3">Back to Students List</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
