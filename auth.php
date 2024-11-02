<?php
session_start();
include 'db.php'; // Include the database connection file

// Handle login functionality
if (isset($_POST['login'])) { 
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT id, password FROM shopowners WHERE username = '$username'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];
        $stored_password = $row['password'];

        if (password_verify($password, $stored_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: ./welcomeshopowner.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Username not found. Please register first.";
    }
}

// Handle registration functionality
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $shop_name = $_POST['shop_name'];
    $email = $_POST['email'];

    if (!empty($username) && !empty($password) && !empty($shop_name) && !empty($email)) {
        $sql = "SELECT id FROM shopowners WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "Username already exists. Please choose a different one.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO shopowners (username, password, shop_name, email) VALUES ('$username', '$hashed_password', '$shop_name', '$email')";

            if (mysqli_query($conn, $sql)) {
                echo "Registration successful! Please log in with your new credentials.";
            } else {
                echo "Error: Could not register. Please try again later.";
            }
        }
    } else {
        echo "Please fill in all the fields.";
    }
}

mysqli_close($conn);
?>
