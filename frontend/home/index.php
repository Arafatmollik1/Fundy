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
    <?php if($serverData->paymentStatus !== 'confirmed'): ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="home/setPaymentInfo" method="post" id="mainForm">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Pay for the ticket</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-0">
                            <div class="card-body">
                                <!-- Payer's Information -->
                                <h6>Payer's information</h6>
                                <div class="form-floating mb-3">
                                    <input type="text" name="payersName" class="form-control" id="floatingInputName"
                                        placeholder="Your name (Required)"
                                        value="<?php echo $_SESSION['user_name']; ?>">
                                    <label for="floatingInputName">Your name (required)</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="payersEmail" class="form-control" id="floatingInputEmail"
                                        value="<?php echo $_SESSION['user_email']; ?>" readonly>
                                    <label for="floatingInputEmail">Email address (Not editable)</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="tel" name="payersPhone" class="form-control" id="floatingPhone"
                                        placeholder="Phone number (Required)">
                                    <label for="floatingPhone">Phone number (required)</label>
                                </div>

                                <!-- Add Participants -->
                                <h6>Add participants</h6>
                                <div class="mb-3 d-flex gap-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-secondary" id="add_participant_adult">Add
                                        adult</button>
                                    <button type="button" class="btn btn-secondary" id="add_participant_child">Add
                                        child</button>
                                </div>
                                <div id="inputDiv" class="d-flex flex-column gap-2">
                                </div>

                                <!-- Payment Information -->
                                <h6 class="mt-2">Send money to this account</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control bg-gray"
                                        placeholder="Reference number (auto generated)"
                                        value="<?= $_SESSION['user_reference_number']; ?>" readonly
                                        id="referenceNumber">
                                    <button class="btn btn-outline-secondary copy-button" type="button"
                                        data-copy-target="#referenceNumber"><i class="bi bi-clipboard"></i></button>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control bg-gray" placeholder="Bank number"
                                        value="FI31 2341 1223 1212 12" readonly id="bankNumber">
                                    <button class="btn btn-outline-secondary copy-button " type="button"
                                        data-copy-target="#bankNumber"><i class="bi bi-clipboard"></i></button>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control bg-gray" placeholder="Name" value="Rakibul"
                                        readonly id="name">
                                    <button class="btn btn-outline-secondary copy-button" type="button"
                                        data-copy-target="#name"><i class="bi bi-clipboard"></i></button>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="tel" class="form-control bg-gray" placeholder="MobilePay"
                                        value="+35878481515" readonly id="mobilePay">
                                    <button class="btn btn-outline-secondary copy-button" type="button"
                                        data-copy-target="#mobilePay"><i class="bi bi-clipboard"></i></button>
                                </div>


                                <!-- Total Participants and Amount -->
                                <h6>Total participants:</h6>
                                <div class="mb-3">
                                    <input type="number" class="form-control bg-gray" id="total_participant" value="0"
                                        readonly>
                                </div>
                                <h6>Total Amount To be paid</h6>
                                <div class="mb-3">
                                    <input type="text" class="form-control bg-gray" name="paymentAmount" id="total_amount_paid" value="0"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="mainForm" class="btn btn-primary">I have paid the amount</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- check in modal -->
    <?php if($serverData->paymentStatus == 'confirmed'): ?>
    <form action="home/userChecksIn" method="post" id="checkInForm">
        <div class="modal fade " id="checkInModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
            aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalScrollableTitle">check in</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-gray">
                        <p>Before you check in please read the community guidelines carefully.</p>
                        <div class="border border-dark rounded p-2">
                            <ul>
                                <li><strong>Littering:</strong> Do not leave trash around. Use provided bins or take your
                                    waste with you.</li>
                                <li><strong>Unruly Behavior:</strong> Aggressive, violent, or otherwise disruptive behavior
                                    will not be tolerated.</li>
                                <li><strong>Illegal Substances:</strong> The use or distribution of illegal drugs is
                                    strictly prohibited.</li>
                                <li><strong>Smoking:</strong> If smoking is allowed, use designated smoking areas and
                                    properly dispose of cigarette butts.</li>
                                <li><strong>Unsupervised Children:</strong> Children should be supervised by an adult at all
                                    times.</li>
                                <li><strong>Cleanliness:</strong> Please keep clean.</li>
                                <li><strong>Parking car:</strong> Please park you car accordingly.</li>
                            </ul>
                        </div>
                        <div class="form-check mt-3 mb-5">
                            <input class="form-check-input" type="checkbox" name="communityGuidelinesChecked" id="communityGuidelinesChecked">
                            <label class="form-check-label text-secondary" for="flexCheckChecked">
                                I understand the community guidelines
                            </label>
                        </div>
                        <h6 class="mt-2">All Participants arrived(<?= count($serverData->allParticipants); ?>)</h6>
                        <?php foreach($serverData->allParticipants as $key => $participants): ?>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="confirmedParticipants<?= $key;?>"  id="confirmedParticipants<?= $key;?>" checked>
                            <label class="form-check-label" for="confirmedParticipants<?= $key;?>">
                                <?= $participants['name'];  ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="checkInForm" class="btn btn-primary">Check in</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
</div>