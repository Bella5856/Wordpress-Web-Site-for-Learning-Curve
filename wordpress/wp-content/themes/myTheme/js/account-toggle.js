document.addEventListener("DOMContentLoaded", function () {
  const showLoginBtn = document.getElementById("show-login");
  const showRegisterBtn = document.getElementById("show-register");
  const loginForm = document.querySelector(".u-column1.col-1");
  const registerForm = document.querySelector(".u-column2.col-2");

  // Function to show login form
  function showLogin() {
    showLoginBtn.classList.add("active");
    showRegisterBtn.classList.remove("active");
    loginForm.style.display = "block";
    registerForm.style.display = "none";
  }

  // Function to show register form
  function showRegister() {
    showRegisterBtn.classList.add("active");
    showLoginBtn.classList.remove("active");
    registerForm.style.display = "block";
    loginForm.style.display = "none";
  }

  // Event Listeners
  showLoginBtn.addEventListener("click", showLogin);
  showRegisterBtn.addEventListener("click", showRegister);

  // Initialize the default state
  showLogin();
});
