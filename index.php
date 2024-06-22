<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>All Students</h1>
        <a href="create.php" class="btn btn-primary mb-3">Add New Student</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Created At</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';

                // Fetch students with class names
                $sql = "SELECT student.*, classes.name as class_name FROM student LEFT JOIN classes ON student.class_id = classes.class_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>";
                        // Dropdown list for selecting class
                        echo "<form action='update_class.php' method='POST'>";
                        echo "<select name='class_id' class='form-control'>";
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = ($row['class_id'] == $i) ? 'selected' : '';
                            echo "<option value='$i' $selected>Grade $i</option>";
                        }
                        echo "</select>";
                        echo "<button type='submit' class='btn btn-sm btn-primary mt-1'>Update</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td><img src='uploads/" . $row['image'] . "' alt='Student Image' width='50'></td>";
                        echo "<td><a href='view.php?id=" . $row['id'] . "' class='btn btn-sm btn-info'>View</a> | <a href='edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a> | <a href='delete.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No students found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
