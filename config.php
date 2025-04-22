<?php
session_start(); // Make sure session is started before using $_SESSION

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "streetwearfinal";

// Create connection
$conn = new mysqli('localhost', 'root', '', 'streetwearfinal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $age = trim($_POST["age"]);
    $sex = trim($_POST["sex"]);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the email is already registered
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            die('MySQL prepare error (email check): ' . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Hash the password and insert the new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, age, sex) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                die('MySQL prepare error (insert): ' . $conn->error);
            }

            $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $age, $sex);
            if ($stmt->execute()) {
                // Fetch the inserted user data
                $user_id = $conn->insert_id;
                $stmt->close();

                // Fetch user again by ID
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                if (!$stmt) {
                    die('MySQL prepare error (fetch user): ' . $conn->error);
                }

                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                // Set session and redirect
                $_SESSION["user"] = $user;
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>
