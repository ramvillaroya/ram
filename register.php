
<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usertype = $_POST['usertype']; // 
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO users (firstname, lastname, email, address, password) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $firstname, $lastname, $email, $address, $hashedPassword);

            if ($insert->execute()) {
                echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Failed to register. Try again.');</script>";
            }
        }

        $checkEmail->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <!-- Include Font Awesome CDN in the <head> section -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #ccc;
    }

    .container {
      display: flex;
      height: 100vh;
      width: 100%;
    }

    .left {
      flex: 1;
      background: linear-gradient(135deg, #007F7F 50%, #444 50%);
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 24px;
      font-weight: bold;
      padding: 40px;
      text-align: center;
    }

    .right {
      flex: 1.5;
      background-color: #112b3c;
      padding: 60px;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative; /* To position the bottom link */
    }

    .right h2 {
      margin: 0;
      color: #00D1C1;
      font-size: 32px;
      margin-bottom: 30px;
    }

    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 15px;
    }

    .form-row input {
      flex: 1;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: none;
      outline: none;
    }

    .terms {
      margin-top: 10px;
      font-size: 13px;
    }

    .terms a {
      color: #00d1c1;
      text-decoration: none;
    }

    .submit-btn {
      margin-top: 20px;
      padding: 12px;
      background-color: #00d1c1;
      color: black;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
    }

    .social-buttons {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }

    .social-buttons button {
      flex: 1;
      padding: 10px;
      font-size: 14px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .facebook {
      background: #3b5998;
      color: white;
    }

    .gmail {
      background: #db4437;
      color: white;
    }

    .social-buttons button i {
      font-size: 18px;
    }

    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #ccc;
    }

    /* New styling for bottom link */
    .top-link {
      position: absolute;
      bottom: 30px;
      left: 20px;
      font-size: 14px;
    }

    .top-link a {
      color: #00d1c1;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      Let’s Make it Happen Together!
    </div>
    <div class="right">
      <!-- Fixed section with the link on the bottom-left -->
      <div class="top-link">
        Already have an account? <a href="login.php">Sign in here!</a>
      </div>

      <h2>Create An Account</h2>
      <div class="form-row">
      <form action="" method="POST">
  <div class="form-row">
    <select id="role-select" name="usertype" required>
      <option value="" disabled selected>Select User Type</option>
      <option value="admin">Admin</option>
      <option value="client">Client</option>
    </select>
  </div>

  <div class="form-row">
    <input type="text" name="firstname" placeholder="First Name" required>
    <input type="text" name="lastname" placeholder="Last Name" required>
  </div>

  <div class="form-row">
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="address" placeholder="Address" required>
  </div>

  <div class="form-row">
    <input type="password" name="password" placeholder="Create Password" required>
    <input type="password" name="cpassword" placeholder="Confirm Password" required>
  </div>

  <div class="terms">
    <input type="checkbox" required> Creating your account and you accepting
    <a href="#">Terms & Conditions</a>.
  </div>

  <button class="submit-btn" type="submit" name="submit">Create Account</button>
</form>

<script>
  const roleSelect = document.getElementById('role-select');
  const adminKeyRow = document.getElementById('admin-key-row');

  roleSelect.addEventListener('change', function () {
    if (this.value === 'admin') {
      adminKeyRow.style.display = 'flex';
    } else {
      adminKeyRow.style.display = 'none';
    }
  });
</script>

</script>
</body>
</html>
