$(document).ready(function() {
    $(document).on('click', '.btn-add-to-cart', function() {
        $('#cover-spin').show();
        var current = $(this);
        var eventId = current.attr('data-event-id');
        if (current.attr('data-type') == 'product') {
            var data = {
                'id': current.attr('data-id'),
                'quantity': $('.product-quantity').val(),
                'type': 'product',
                'event_id': eventId
            };
        } else {
            var data = {
                'id': current.attr('data-id'),
                'type': 'plan',
                'event_id': eventId
            };
        }
        $.ajax({
            url: current.attr('data-url'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#cover-spin').hide();
                if(response.status) {
                toastr.success(response.message);
                setTimeout(function() {
                    window.location = response.data.redirect_url;
                }, 500);
                } else {
                    toastr.success(response.message);
                }
            }
        });
    });
    $(document).on('click', '.btn-increase-quantity', function() {
        var current = $(this);
        current.prev('[name="quantity"]').val(parseInt(current.prev('[name="quantity"]').val()) + 1);
    });
    $(document).on('click', '.btn-decrease-quantity', function() {
        var current = $(this);
        if (parseInt(current.next('[name="quantity"]').val()) > 1) {
            current.next('[name="quantity"]').val(parseInt(current.next('[name="quantity"]').val()) - 1);
            return true;
        } else {
            return false;
        }
    });
    $(document).on('click', '.btn-remove-cart', function() {
        var current = $(this)
        if (current.closest('.tab-pane').find('[name="id_cart[]"]:checked').length > 0) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to remove the selected from cart?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            var id = [];
                            current.closest('.tab-pane').find('[name="id_cart[]"]:checked').each(function() {
                                id.push($(this).val());
                            });

                            $.ajax({
                                url: current.attr('data-url'),
                                method: 'POST',
                                data: { '_token': $('meta[name="csrf-token"]').attr('content'), 'id': id, 'action': 'remove' },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window.location.href;
                                        }, 500);
                                    } else {
                                        $('#cover-spin').hide();
                                        toastr.error(response.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        } else {
            toastr.error('Please select record to process.');
        }
    });
    $(document).on('click', '.btn-remove-pending', function() {
        var current = $(this)
        if (current.closest('#pending').find('[name="id_cart[]"]:checked').length > 0) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to remove?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            var id = [];
                            current.closest('#pending').find('[name="id_cart[]"]:checked').each(function() {
                                id.push($(this).val());
                            });

                            $.ajax({
                                url: current.attr('data-url'),
                                method: 'POST',
                                data: { '_token': $('meta[name="csrf-token"]').attr('content'), 'id': id, 'action': 'remove' },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window.location.href;
                                        }, 500);
                                    } else {
                                        $('#cover-spin').hide();
                                        toastr.error(response.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        } else {
            toastr.error('Please select record to process.');
        }
    });
    $(document).on('click', '.btn-cancel-booking', function() {
        var current = $(this)
        if (current.closest('#confirmed').find('[name="id_cart[]"]:checked').length > 0) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to cancel booking?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            var id = [];
                            current.closest('#confirmed').find('[name="id_cart[]"]:checked').each(function() {
                                id.push($(this).val());
                            });

                            $.ajax({
                                url: current.attr('data-url'),
                                method: 'POST',
                                data: { '_token': $('meta[name="csrf-token"]').attr('content'), 'id': id, 'action': 'remove' },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window.location.href;
                                        }, 500);
                                    } else {
                                        $('#cover-spin').hide();
                                        toastr.error(response.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        } else {
            toastr.error('Please select record to process.');
        }
    });
    $(document).on('click', '.btn-add-to-shortlist', function() {
        var current = $(this)
        if (current.closest('.tab-pane').find('[name="id_cart[]"]:checked').length > 0) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to checkout?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            var id = [];
                            current.closest('.tab-pane').find('[name="id_cart[]"]:checked').each(function() {
                                id.push($(this).val());
                            });

                            $.ajax({
                                url: current.attr('data-url'),
                                method: 'POST',
                                data: { '_token': $('meta[name="csrf-token"]').attr('content'), 'id': id, 'action': 'remove' },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window.location.href;
                                        }, 500);
                                    } else {
                                        $('#cover-spin').hide();
                                        toastr.error(response.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        } else {
            toastr.error('Please select record to process.');
        }
    });
    $(document).on('click', '.btn-add-to-confirm', function() {
        var current = $(this)
        if (current.closest('.tab-pane').find('[name="id_cart[]"]:checked').length > 0) {
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure want to add confirm?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function() {
                            $('#cover-spin').show();
                            var id = [];
                            current.closest('.tab-pane').find('[name="id_cart[]"]:checked').each(function() {
                                id.push($(this).val());
                            });

                            $.ajax({
                                url: current.attr('data-url'),
                                method: 'POST',
                                data: { '_token': $('meta[name="csrf-token"]').attr('content'), 'id': id, 'action': 'remove' },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status) {
                                        toastr.success(response.message);
                                        setTimeout(function() {
                                            window.location = window.location.href;
                                        }, 500);
                                    } else {
                                        $('#cover-spin').hide();
                                        toastr.error(response.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        } else {
            toastr.error('Please select record to process.');
        }
    });
    $(document).on('click', '.btn-pay-now', function() {
        var current = $(this);
    });

    $(document).on('click', '.btn-checkout', function() {
        if ($('.shortlisted').find('[name="id_cart[]"]:checked').length == 0) {
            $.alert('Please select produt/plan to book a party');
        } else {
            var total_amount = 0;
            $('.show-hide-cart-product-plan').hide();
            $('.shortlisted').find('[name="id_cart[]"]:checked').each(function() {
                total_amount += parseFloat($(this).closest('tr').find('[data-amount]').attr('data-amount'));
                $('.show-hide-cart-product-plan[data-id-cart="' + $(this).val() + '"]').show();
            });
            $('.total-amount').text(total_amount);
            $('#checkout').modal('show');
        }
    });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const appId = SQUARE_APP_ID;
const locationId = SQUARE_LOCATION_ID;

async function initializeCard(payments) {
    const card = await payments.card();
    await card.attach('#card-container');

    return card;
}

async function createPayment(token, verificationToken) {
    var id_cart = [];
    $('.shortlisted').find('[name="id_cart[]"]:checked').each(function() {
        id_cart.push($(this).val());
    });
    $('#cover-spin').show();
    const body = JSON.stringify({
        locationId,
        sourceId: token,
        verificationToken,
        idempotencyKey: window.crypto.randomUUID(),
        id_cart: id_cart
    });

    const paymentResponse = await fetch(paymentTokenUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        body,
    });

    if (paymentResponse.status) {
        return paymentResponse.json();
    } else {
        $('#cover-spin').hide();
        const errorBody = await paymentResponse.text();
        throw new Error(errorBody);
    }
}

async function tokenize(paymentMethod) {
    const tokenResult = await paymentMethod.tokenize();
    if (tokenResult.status === 'OK') {
        return tokenResult.token;
    } else {
        $('#cover-spin').hide();
        let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
        if (tokenResult.errors) {
            errorMessage += ` and errors: ${JSON.stringify(
                tokenResult.errors,
            )}`;
        }
        throw new Error(errorMessage);
    }
}

// Required in SCA Mandated Regions: Learn more at https://developer.squareup.com/docs/sca-overview
async function verifyBuyer(payments, token) {
    const verificationDetails = {
        amount: '1.00',
        billingContact: {
            givenName: user_info.name,
            familyName: '',
            email: user_info.email,
            phone: '',
            addressLines: [],
            city: 'London',
            state: 'LND',
            countryCode: 'AU',
        },
        currencyCode: SQUARE_CURRENCY,
        intent: 'CHARGE',
    };

    const verificationResults = await payments.verifyBuyer(
        token,
        verificationDetails,
    );
    return verificationResults.token;
}

// status is either SUCCESS or FAILURE;
function displayPaymentResults(status) {
    const statusContainer = document.getElementById(
        'payment-status-container',
    );
    if (status === 'SUCCESS') {
        statusContainer.classList.remove('is-failure');
        statusContainer.classList.add('is-success');
    } else {
        statusContainer.classList.remove('is-success');
        statusContainer.classList.add('is-failure');
    }

    statusContainer.style.visibility = 'visible';
}

document.addEventListener('DOMContentLoaded', async function() {
    if (!window.Square) {
        $('#cover-spin').hide();
        throw new Error('Square.js failed to load properly');
    }

    let payments;
    try {
        payments = window.Square.payments(appId, locationId);
    } catch {
        const statusContainer = document.getElementById(
            'payment-status-container',
        );
        statusContainer.className = 'missing-credentials';
        statusContainer.style.visibility = 'visible';
        return;
    }

    let card;
    try {
        card = await initializeCard(payments);
    } catch (e) {
        console.error('Initializing Card failed', e);
        return;
    }

    async function handlePaymentMethodSubmission(event, card) {
        event.preventDefault();

        try {
            $('#cover-spin').show();
            // disable the submit button as we await tokenization and make a payment request.
            cardButton.disabled = true;
            const token = await tokenize(card);
            const verificationToken = await verifyBuyer(payments, token);
            const paymentResults = await createPayment(
                token,
                verificationToken,
            );
            // displayPaymentResults('SUCCESS');
            console.log(paymentResults);
            var current = $('#btn-pay-now');
            $('.custom-validation-message').remove();
            // if ($.trim($('[name="cardholder_name"]').val()) == '') {
            //     $('<p class="text-danger custom-validation-message">Please enter cardholder name.</p>').insertAfter($('[name="cardholder_name"]'));
            // } else if ($.trim($('[name="card_number"]').val()) == '') {
            //     $('<p class="text-danger custom-validation-message">Please enter card number.</p>').insertAfter($('[name="card_number"]'));
            // } else if ($.trim($('[name="expiry_date"]').val()) == '') {
            //     $('<p class="text-danger custom-validation-message">Please enter exipry date.</p>').insertAfter($('[name="expiry_date"]'));
            // } else if ($.trim($('[name="cvv"]').val()) == '') {
            //     $('<p class="text-danger custom-validation-message">Please enter cvv.</p>').insertAfter($('[name="cvv"]'));
            // } else 


            // if (!$('#terms').is(':checked')) {
            //     $('<p class="text-danger custom-validation-message">Please select terms.</p>').insertAfter($('#terms'));
            // } else {
            // $.confirm({
            //     title: 'Confirm!',
            //     content: 'Are you sure want to confirm this booking?',
            //     buttons: {
            //         confirm: {
            //             btnClass: 'btn-success',
            //             action: function () {
            $('#cover-spin').show();

            var id_cart = [];
            $('.shortlisted').find('[name="id_cart[]"]:checked').each(function() {
                id_cart.push($(this).val());
            });

            $.ajax({
                url: current.attr('data-url'),
                method: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id_events': $('.event-selection a.active').attr('data-id'),
                    'cardholder_name': $.trim($('[name="cardholder_name"]').val()),
                    'card_number': $.trim($('[name="card_number"]').val()),
                    'expiry_date': $.trim($('[name="expiry_date"]').val()),
                    'cvv': $.trim($('[name="cvv"]').val()),
                    'id_payment_token': paymentResults.data.id,
                    'id_cart': id_cart
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location = response.data.redirect_url;
                        }, 1000);
                    } else {
                        $('#cover-spin').hide();
                        toastr.error(response.message);
                    }
                }
            });
            //             }
            //         },
            //         cancel: function () { }
            //     }
            // });
            // }

            console.debug('Payment Success', paymentResults);
        } catch (e) {
            cardButton.disabled = false;
            // displayPaymentResults('FAILURE');
            // console.error(e.message);
            $('#cover-spin').hide();
            toastr.error(e.message);
        }
    }

    $('#btn-pay-now').attr('disabled', 'disabled');
    $('#terms').change(function() {
        if ($('#terms').is(':checked')) {
            $('#btn-pay-now').removeAttr('disabled');
        } else {
            $('#btn-pay-now').attr('disabled', 'disabled');
        }
    });

    const cardButton = document.getElementById('btn-pay-now');
    cardButton.addEventListener('click', async function(event) {
        $('#cover-spin').hide();
        await handlePaymentMethodSubmission(event, card);
        // if (!$('#terms').is(':checked')) {
        //     $('<p class="text-danger custom-validation-message">Please select terms.</p>').insertAfter($('#terms'));
        // } else {
        //     $.confirm({
        //         title: 'Confirm!',
        //         content: 'Are you sure want to confirm this booking?',
        //         buttons: {
        //             confirm: {
        //                 btnClass: 'btn-success',
        //                 action: function () {
        //                     $('#cover-spin').show();

        //                 }
        //             },
        //             cancel: function () { }
        //         }
        //     });
        // }
    });
});