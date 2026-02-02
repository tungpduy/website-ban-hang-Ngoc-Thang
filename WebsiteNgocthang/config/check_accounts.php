<?php
require_once 'database.php';

echo "<h2>Checking Users Table:</h2>";
$sql = "SELECT id, username, email, full_name FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["full_name"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found in the database.<br>";
}

echo "<h2>Checking Admins Table:</h2>";
$sql = "SELECT id, username, email, full_name FROM admins";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["full_name"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No admins found in the database.<br>";
}

mysqli_close($conn);
?> 