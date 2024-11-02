<?php
session_start();
include 'db.php'; // Go one level up to include db.php
 


// if ($db_error) {
//     die("Temporary Error: Unable to connect to the database. Please try again later.");
// }
if (isset($_POST['submit'])) { 
    $username = $_POST['username'] ?? ''; // Use null coalescing operator to handle undefined index
    $password = $_POST['password'] ?? ''; // Use null coalescing operator

    $sql = $sql = "SELECT id, password FROM shopowners WHERE username = '$username'";
    $res = mysqli_query($conn,$sql);
      // Check if user exists
      if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];
        $stored_password = $row['password'];

        // Verify the password
        if (password_verify($password, $stored_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
        // if ($password === $stored_password) {
        //     // Password is correct, set session variables
        //     $_SESSION['user_id'] = $id;
        //     $_SESSION['username'] = $username;

            // Redirect to a welcome page or dashboard
            header("Location: welcomeshopowner.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        header("Location: registershopowner.php");
            exit();
    }
    mysqli_close($conn);

}

       

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="Login"> <!-- Include name attribute -->
    </form>
</body>
</html>
