$(document).ready(function() {
    const pricePerAdult = 8;
    const pricePerChild = 0;

    function updateTotals() {
        var totalAdults = $('.adult-participant-counter').length;
        var totalChildren = $('.child-participant-counter').length;

        var totalParticipants = totalAdults + totalChildren;
        var totalPrice = (totalAdults * pricePerAdult) + (totalChildren * pricePerChild);

        $('#total_participant').val(totalParticipants);
        $('#total_amount_paid').val(totalPrice);
    }

    // Call updateTotals whenever a new participant is added or removed
    // Assuming you have some event to add or remove participants
    $('#add_participant_adult, #add_participant_child, .remove-participant-btn').click(updateTotals);

    var inputCounterForAdult = 1; 
    var inputCounterForChild = 1; 
    $('#add_participant_adult').click(function(event) {
        event.preventDefault();
    
        // Create a container for the new set of elements
        var newParticipantContainer = $('<div>', {
            class: 'participant-container'
        });
    
        // Create the heading for the adult input
        var sectionHeading = $('<h6>', {
            text: '+ Adult '
        }).appendTo(newParticipantContainer);
    
        // Create the new input and label elements
        var newInput = $('<input>', {
            type: 'text',
            class: 'form-control adult-participant-counter',
            id: 'floatingInputAdult' + inputCounterForAdult,
            name: 'newAdult' + inputCounterForAdult,
            placeholder: 'Adult Name ' + inputCounterForAdult
        });
    
        var newLabel = $('<label>', {
            for: 'floatingInputAdult' + inputCounterForAdult,
            text: 'Name'
        });
    
        // Wrap the input and label in a div with class form-floating
        var newInputDiv = $('<div>', {
            class: 'form-floating mb-3'
        }).append(newInput).append(newLabel);
    
        // Append the input div to the container
        newParticipantContainer.append(newInputDiv);
    
        // Create the close button
        var closeButton = $('<button>', {
            type: 'button',
            class: 'btn btn-outline-secondary',
            html: '<i class="bi bi-x-circle"></i>',
            click: function() {
                // Remove the closest .participant-container div that contains the h6 and form-floating div
                $(this).closest('.participant-container').remove();
                updateTotals();
            }
        }).appendTo(newInputDiv);
        // Style the close button to be positioned inside the input on the right
        closeButton.css({
            position: 'absolute',
            top: '50%',
            right: '10px',
            transform: 'translateY(-50%)',
            zIndex: 10
        });
    
        // Append the container to the main input div
        $('#inputDiv').append(newParticipantContainer);
    
        // Increment the counter for the next input
        inputCounterForAdult++;
        updateTotals();
    });
    

    
    $('#add_participant_child').click(function(event) {
        event.preventDefault();
    
        // Create a container for the new set of elements
        var newParticipantContainer = $('<div>', {
            class: 'participant-container'
        });
    
        // Create the heading for the adult input
        var sectionHeading = $('<h6>', {
            text: '+ Child '
        }).appendTo(newParticipantContainer);
    
        // Create the new input and label elements
        var newInput = $('<input>', {
            type: 'text',
            class: 'form-control child-participant-counter',
            id: 'floatingInputChild' + inputCounterForChild,
            name: 'newChild' + inputCounterForChild,
            placeholder: 'Child Name ' + inputCounterForChild
        });
    
        var newLabel = $('<label>', {
            for: 'floatingInputChild' + inputCounterForChild,
            text: 'Name'
        });
    
        // Wrap the input and label in a div with class form-floating
        var newInputDiv = $('<div>', {
            class: 'form-floating mb-3'
        }).append(newInput).append(newLabel);
    
        // Append the input div to the container
        newParticipantContainer.append(newInputDiv);
    
        // Create the close button
        var closeButton = $('<button>', {
            type: 'button',
            class: 'btn btn-outline-secondary',
            html: '<i class="bi bi-x-circle"></i>',
            click: function() {
                // Remove the closest .participant-container div that contains the h6 and form-floating div
                $(this).closest('.participant-container').remove();
                updateTotals();
            }
        }).appendTo(newInputDiv);
        // Style the close button to be positioned inside the input on the right
        closeButton.css({
            position: 'absolute',
            top: '50%',
            right: '10px',
            transform: 'translateY(-50%)',
            zIndex: 10
        });
    
        // Append the container to the main input div
        $('#inputDiv').append(newParticipantContainer);
    
        // Increment the counter for the next input
        inputCounterForChild++;
        updateTotals();
    });
});
$(document).ready(function() {
    $('.copy-button').click(function() {
        var target = $(this).data('copy-target');
        var textToCopy = $(target).val();

        // Use the Clipboard API
        if (navigator.clipboard && window.isSecureContext) {
            // navigator.clipboard is available
            navigator.clipboard.writeText(textToCopy).then(function() {
                // Optionally change the button text/icon or show a tooltip
            }).catch(function(error) {
            });
        } else {
            // Fallback for older browsers
            var textArea = document.createElement("textarea");
            textArea.value = textToCopy;
            // Make the textarea out of viewport
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                var successful = document.execCommand('copy');
                // Optionally change the button text/icon or show a tooltip
            } catch (err) {
            }
            document.body.removeChild(textArea);
        }
    });
});