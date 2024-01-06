<?php include 'views/header-no-auth.php'; ?>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="d-flex flex-column gap-5">
    <div class="logo-container row">
      <div class="col text-center">
        <div class="d-flex align-items-end justify-content-center my-2">
          <img src="../assets/pictures/fundy-logo.svg" alt="Fundy Logo" class="img-fluid">
          <h2> Fundy </h2>
        </div>
        <span>Get Funded!</span>
      </div>
    </div>
        <h1>You are logged out</h1>
        <a href= "<?= $config->baseUrlEnd; ?>/login" class="btn btn-primary"> Go back to login</a>

    </div>
</div>