<?php include 'views/header.php'; ?>

<div class="container  vh-100 d-flex justify-content-center align-items-center">
    <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="<?= $serverData->imageURL; ?>" alt="Card image cap">
        <div class="card-body">
            <div class="mb-5">
                <h5 class="card-title">
                    <?= $serverData->postHeader; ?>
                </h5>
                <p class="fs-6">
                    <?= $serverData->postSubHeader; ?>
                </p>
            </div>
            <hr class="hr">
            <?php if ($serverData->paymentStatus == 'none'): ?>
                <div class="ticket-price">
                    <div class="tag-holder">
                        <span> Price </span>
                    </div>
                    <p class="m-0"> €8 </p>
                </div>
                <div class="text-center w-100">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy
                        ticket</button>
                </div>
            <?php elseif ($serverData->paymentStatus == 'pending'): ?>
                <div class="alert alert-warning fs-xxs" role="alert">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>
                        Your payment is pending, come back later!
                    </span>
                </div>
                <div class="text-center w-100">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy
                        more
                        tickets</button>
                </div>
            <?php elseif ($serverData->paymentStatus == 'confirmed'): ?>
                <div class="alert alert-success fs-xxs" role="alert">
                    You payment has been received!
                </div>
                <div class="w-100 text-center fs-xs text-secondary">
                    You are
                    <?= $serverData->confirmedParticipants; ?> participant<?= $serverData->confirmedParticipants > 1 ? 's' : ''; ?>
                </div>
                <div class="text-center w-100 mt-2">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#checkInModal">Check
                        in</button>
                </div>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payment Modal -->
    <?php include('modals/payment-modal.php');?>
    
    <!-- check in modal -->
    <?php include('modals/checkin-modal.php');?>
</div>