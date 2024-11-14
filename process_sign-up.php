
<?php
alert("HELLO");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

$conn = new mysqli($servername, $username ,$password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Input validation
if (empty($username) || empty($email) || empty($password)) {
    echo "All fields are required";
    exit();
}
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Email already registered";
    exit();
}

// Hash password
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$stmt->bind_param("sss", $username, $email, $password_hashed);
$result = $stmt->execute();

if ($result) {
    echo "User registered successfully";
} else {
    echo "Failed to register user";
}
$conn->close();



header("Location: index.html");
exit();
?>
