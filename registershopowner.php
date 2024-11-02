<?php
include 'db.php'; // Include your database connection

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $shop_name = $_POST['shop_name'];
    $email = $_POST['email'];

    // Ensure all required fields are filled
    if (!empty($username) && !empty($password) && !empty($shop_name) && !empty($email)) {
        // Check if the username already exists
        $sql = "SELECT id FROM shopowners WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "Username already exists. Please choose a different one.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new shop owner into the database
            $sql = "INSERT INTO shopowners (username, password, shop_name, email) VALUES ('$username', '$hashed_password', '$shop_name', '$email')";

            if (mysqli_query($conn, $sql)) {
                // Show a success message
                echo "Registration successful! You will be redirected to the login page in 2 seconds.";
                
                // Redirect to the login page after a 2-second delay
                header("refresh:2;url=loginshopowner.php");
                exit();
            } else {
                echo "Error: Could not register. Please try again later.";
            }
        }
    } else {
        echo "Please fill in all the fields.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Shop Owner</title>
</head>
<body>
    <h2>Register Shop Owner</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="shop_name">Shop Name:</label>
        <input type="text" name="shop_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
