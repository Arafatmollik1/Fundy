<?php if ($serverData->paymentStatus == 'confirmed'): ?>
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
                            <input class="form-check-input" type="checkbox" name="communityGuidelinesChecked"
                                id="communityGuidelinesChecked">
                            <label class="form-check-label text-secondary" for="flexCheckChecked">
                                I understand the community guidelines
                            </label>
                        </div>
                        <h6 class="mt-2">All Participants arrived(
                            <?= count($serverData->allParticipants); ?>)
                        </h6>
                        <?php foreach ($serverData->allParticipants as $key => $participants): ?>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="confirmedParticipants<?= $key; ?>"
                                    id="confirmedParticipants<?= $key; ?>" checked>
                                <label class="form-check-label" for="confirmedParticipants<?= $key; ?>">
                                    <?= $participants['name']; ?>
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