document.addEventListener("DOMContentLoaded", function () {
   // Password toggle functionality
   const passwordAccess = (loginPass, loginEye) => {
       const input = document.getElementById(loginPass),
           iconEye = document.getElementById(loginEye);

       if (input && iconEye) {
           iconEye.addEventListener('click', () => {
               input.type = input.type === 'password' ? 'text' : 'password';
               iconEye.classList.toggle('ri-eye-fill');
               iconEye.classList.toggle('ri-eye-off-fill');
           });
       } else {
           console.warn(`Elements with IDs ${loginPass} or ${loginEye} not found.`);
       }
   };
   passwordAccess('password', 'loginPasswordCreate'); // Password toggle for registration

   // Toggle between login and register views
   const loginAccessRegister = document.getElementById('loginAccessRegister'),
       buttonRegister = document.getElementById('loginButtonRegister'),
       buttonAccess = document.getElementById('loginButtonAccess');
   
   if (buttonRegister && loginAccessRegister) {
       buttonRegister.addEventListener('click', () => {
           loginAccessRegister.classList.add('active');
       });
   } else {
       console.warn("Button for 'Create Account' or form container not found.");
   }
   
   if (buttonAccess && loginAccessRegister) {
       buttonAccess.addEventListener('click', () => {
           loginAccessRegister.classList.remove('active');
       });
   } else {
       console.warn("Button for 'Log In' or form container not found.");
   }

   // Form submission for login and registration
   const loginForm = document.querySelector('.login__form');
   if (loginForm) {
       loginForm.addEventListener('submit', function (e) {
           e.preventDefault(); // Prevent default form submission

           const formData = new FormData(loginForm);
           const action = formData.get('submit') === 'Create account' ? 'register' : 'login';

           // Validate inputs before submission
           if (validateForm(formData)) {
               fetch('auth.php', {
                   method: 'POST',
                   body: formData
               })
               .then(response => response.text())
               .then(data => {
                   // Process response from PHP
                   alert(data); // Display the message returned from PHP
                   if (action === 'register') {
                       // Optionally clear the form or redirect after registration
                       loginForm.reset();
                   } else {
                       // Redirect after successful login (assuming response contains a redirect)
                       window.location.href = './welcomeshopowner.php';
                   }
               })
               .catch(error => console.error('Error:', error));
           } else {
               alert("Please fill in all required fields.");
           }
       });
   }

   // Validate form data
   function validateForm(formData) {
       for (let [key, value] of formData.entries()) {
           if (!value) {
               return false; // If any field is empty, validation fails
           }
       }
       return true; // All fields are filled
   }

   // Background image rotation
   const bgImage = document.getElementById("bgImage");
   const images = ["assets/img/carts.jpg", "assets/img/fruits.jpg", "assets/img/cartoonfloor.jpg"];
   let currentIndex = 0;

   if (bgImage) {
       function changeBackgroundImage() {
           currentIndex = (currentIndex + 1) % images.length;
           bgImage.setAttribute("href", images[currentIndex]);
       }
       setInterval(changeBackgroundImage, 5000);
   } else {
       console.warn("Background image element not found.");
   }
});
