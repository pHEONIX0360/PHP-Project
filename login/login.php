<?php
session_start();
include '../db.php'; // Go one level up to include db.php
 


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
            header("Location:./welcomeshopowner.php");
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

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="assets/css/styles.css">
      
      <title>SupaBask Login</title>
   </head>
   <body>
      <!--=============== LOGIN IMAGE ===============-->
      <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
         <mask id="mask0" mask-type="alpha">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
         </mask>
      
         <g mask="url(#mask0)">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
      
            <!-- Insert your image (recommended size: 1000 x 1200) -->
            <!-- <image class="login__img" id="bgImage" href="assets/img/carts.jpg"/> -->
            <image class="login__img" id="bgImage" href="assets/img/bowl.jpg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>

         </g>
      </svg>      

      <!--=============== LOGIN ===============-->
      <div class="login container grid" id="loginAccessRegister">
         <!--===== LOGIN ACCESS =====-->
         <div class="login__access">

            <img src="assets/img/SupaBask.png" alt="Logo" class="login__logo"/> <!-- Add this line -->


            <h1 class="login__title">Log in to your <span class="supa">Supa</span><span class="bask">Bask</span>
               account.</h1>
            
            <div class="login__area">
               <form action="" class="login__form">
                  <div class="login__content grid">
                     <div class="login__box">
                        <input type="username" id="username" required placeholder=" " class="login__input">
                        <label for="username" class="login__label">User Name</label>
            
                        <i class="ri-mail-fill login__icon"></i>
                     </div>
         
                     <div class="login__box">
                        <input type="password" id="password" required placeholder=" " class="login__input">
                        <label for="password" class="login__label">Password</label>
            
                        <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                     </div>
                  </div>
         
                  <a href="#" class="login__forgot">Forgot your password?</a>
         
                  <button type="submit" class="login__button">Login</button>
               </form>
      
               <div class="login__social">
                  <p class="login__social-title">Or login with</p>
      
                  <div class="login__social-links">
                     <a href="#" class="login__social-link">
                        <img src="assets/img/icon-google.svg" alt="image" class="login__social-img">
                     </a>
      
                     <a href="#" class="login__social-link">
                        <img src="assets/img/icon-facebook.svg" alt="image" class="login__social-img">
                     </a>
      
                     <a href="#" class="login__social-link">
                        <img src="assets/img/icon-apple.svg" alt="image" class="login__social-img">
                     </a>
                  </div>
               </div>
      
               <p class="login__switch">
                  Don't have an account? 
                  <button id="loginButtonRegister">Create Account</button>
               </p>
            </div>
         </div>

         <!--===== LOGIN REGISTER =====-->
         <?php
include '../db.php'; // Include your database connection

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
                header("url=../home.php");
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
         <div class="login__register">

            <img src="assets/img/SupaBask.png" alt="Logo" class="login__logo"/> <!-- Add this line -->

            <h1 class="login__title">Create new <span class="supa">Supa</span><span class="bask">Bask</span>
               account.</h1>

            <div class="login__area">
               <form action="" class="login__form">
                  <div class="login__content grid">
                     <div class="login__group grid">
                        <div class="login__box">
                           <input type="text" id="username" required placeholder=" " class="login__input">
                           <label for="username" class="login__label">User Names</label>
      
                           <i class="ri-id-card-fill login__icon"></i>
                        </div>
      
                        <div class="login__box">
                           <input type="text" id="shop_name" required placeholder=" " class="login__input">
                           <label for="shop_name" class="login__label">shopname</label>
      
                           <i class="ri-id-card-fill login__icon"></i>
                        </div>
                     </div>
   
                     <div class="login__box">
                        <input type="email" id="email" required placeholder=" " class="login__input">
                        <label for="email" class="login__label">Email</label>
   
                        <i class="ri-mail-fill login__icon"></i>
                     </div>
   
                     <div class="login__box">
                        <input type="password" id="password" required placeholder=" " class="login__input">
                        <label for="password" class="login__label">Password</label>
   
                        <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordCreate"></i>
                     </div>
                  </div>
   
                  <button type="submit" class="login__button">Create account</button>
               </form>
   
               <p class="login__switch">
                  Already have an account? 
                  <button id="loginButtonAccess">Log In</button>
               </p>
            </div>
         </div>
      </div>
      
      <!--=============== MAIN JS ===============-->
      <script src="assets/js/main.js"></script>
   </body>
</html>