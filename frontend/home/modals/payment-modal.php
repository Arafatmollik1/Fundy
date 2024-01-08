<?php if ($serverData->paymentStatus !== 'confirmed'): ?>
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
                                        placeholder="Your name (Required)" value="<?php echo $_SESSION['user_name']; ?>">
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
                                        value="<?= $_SESSION['user_reference_number']; ?>" readonly id="referenceNumber">
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
                                    <input type="text" class="form-control bg-gray" name="paymentAmount"
                                        id="total_amount_paid" value="0" readonly>
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