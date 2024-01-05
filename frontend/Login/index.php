<?php include 'views/header-no-auth.php'; ?>
<div class="container d-flex justify-content-center h-100">
  <div class="d-flex flex-column justify-content-evenly">
    <div class="logo-container row">
      <div class="col text-center">
        <div class="d-flex align-items-end justify-content-center my-2">
          <img src="assets/pictures/fundy-logo.svg" alt="Fundy Logo" class="img-fluid">
          <h2> Fundy </h2>
        </div>
        <span>Get Funded!</span>
      </div>
    </div>
    <div class="login-div">
      <div class="google-auth-container">
        <div id="gSignInWrapper">
          <div id="customBtn" class="customGPlusSignIn">
            <span class="icon"></span>
            <span class="buttonText">Sign in with google</span>
          </div>
        </div>
        <div id="name"></div>
      </div>
      <div class="login-separator">
        <span>OR</span>
      </div>

      <div class="basic-auth-container">
        <form class="py-4">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingName" placeholder="Name" required>
            <label for="floatingName">Name</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
            <label for="floatingEmail">Email</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary fs-6" type="submit">Sign In</button>
        </form>
      </div>
    </div>
  </div>
</div>