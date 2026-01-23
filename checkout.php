<?php include('includes/header.php'); ?>

<section class="checkout_section" style="padding: 100px 0; min-height: 60vh;">
    <div class="container">
        <div class="inner_container"
            style="display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center;">

            <div class="heading red" style="margin-bottom: 20px;">Complete Your Order</div>
            
            <div style="display: flex; gap: 30px; flex-wrap: wrap; justify-content: center; width: 100%; max-width: 1000px;">
                
                <!-- Billing Details Form -->
                <div class="card" style="flex: 1; min-width: 300px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 40px; border-radius: 10px; background: #fff; text-align: left;">
                    <h3 style="margin-bottom: 20px; color: #333; text-align: center;">Billing Details</h3>
                    <form id="billing-form">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; color: #666;">Full Name *</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; color: #666;">Email Address *</label>
                            <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; color: #666;">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; color: #666;">Address *</label>
                            <input type="text" id="address" name="address" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <div style="margin-bottom: 15px; flex: 1;">
                                <label style="display: block; margin-bottom: 5px; color: #666;">City *</label>
                                <input type="text" id="city" name="city" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            </div>
                            <div style="margin-bottom: 15px; flex: 1;">
                                <label style="display: block; margin-bottom: 5px; color: #666;">State *</label>
                                <input type="text" id="state" name="state" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            </div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; color: #666;">Pincode *</label>
                            <input type="text" id="pincode" name="pincode" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="card" style="flex: 0 0 350px; height: fit-content; box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 40px; border-radius: 10px; background: #fff;">
                    <h3 style="margin-bottom: 15px;">Order Summary</h3>
                    <p style="margin-bottom: 10px; color: #666;">Love & Her Sisters</p>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-weight: bold; color: #333;">
                        <span>Total</span>
                        <span><?php require_once 'config.php'; echo '₹' . PRODUCT_PRICE; ?></span>
                    </div>
                    
                    <button id="rzp-button1" class="primary_btn" style="cursor: pointer; width: 100%;">Pay Now</button>
                    <div id="loading" style="display: none; margin-top: 10px;">Processing...</div>
                </div>

            </div>

        </div>
    </div>
</section>

<div class="body_overlay">
    <div class="inner_box">
        <div class="request_overlay_box">
            <div class="form_wrapper">
                <!-- <div class="heading red">Enquire Now</div> -->
                <p class="center red"><b>Kindly enter your mobile number to proceed with the checkout process.</b></p>
                <form class="user_mobile_form" action="" method="POST">
                    <div class="form-error-user_mobile"></div>
                    <input type="text" name="user_mobile" maxlength="10" minlength="10">
                    <button type="submit" class="pink_btn">Submit</button>
                </form>
            </div>
            <!-- <a class="close_overlay"></a> -->
        </div>
    </div>
</div>

<script>
    
$(document).ready(function(){

$(".user_mobile_form").on("submit", function (e) {
    e.preventDefault();

    const $form = $(this);

    // ✅ Clear previous errors properly
    $form.find("[class^='form-error-']").html("").removeClass("alert alert-danger");

    var $submitButton = $form.find("[type=submit]");

    $submitButton.attr('disabled', 'disabled');
    $submitButton.addClass('spinners');

    $.ajax({
        type: "POST",
        url: "mail_process_checkout_popup.php",
        data: new FormData(this),
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,

        success: function (result) {
            $submitButton.removeAttr('disabled').removeClass('spinners');
            $('.body_overlay').fadeOut();
            $('[name=phone]').val(result.user_mobile);
            // alert("Mobile number submitted successfully");
            // $form[0].reset();
        },

        error: function (data) {

            if (data.status === 422 && data.responseJSON?.error?.errors) {

                let errors = data.responseJSON.error.errors;

                $.each(errors, function (key, message) {
                    $form
                        .find(".form-error-" + key)
                        .html(message)
                        .addClass("alert alert-danger");
                });

            } else {
                alert("Something went wrong. Please try again.");
                console.log(data);
            }
            $submitButton.removeAttr('disabled').removeClass('spinners');
        }
    });
});

});

</script>

<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('rzp-button1').onclick = function(e){
    e.preventDefault();
    
    // Validate Form
    var form = document.getElementById('billing-form');
    if(!form.checkValidity()){
        form.reportValidity();
        return;
    }

    var btn = this;
    var loading = document.getElementById('loading');
    
    // Get user details
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;

    btn.style.display = 'none';
    loading.style.display = 'block';

    // Fetch Order ID from backend
    fetch('create-order.php')
    .then(response => response.json())
    .then(data => {
        if(data.error) {
            alert('Error creating order: ' + data.error);
            btn.style.display = 'inline-block';
            loading.style.display = 'none';
            return;
        }

        var options = {
            "key": data.key, 
            "amount": data.amount, 
            "currency": data.currency,
            "name": data.name,
            "description": data.description,
            "image": "images/logo.png",
            "order_id": data.id, 
            "handler": function (response){
                // Submit payment details + form data to verify.php
                var submitForm = document.createElement("form");
                submitForm.setAttribute("method", "post");
                submitForm.setAttribute("action", "verify.php");

                // Razorpay Fields
                var fields = {
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature
                };

                for(var key in fields) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", fields[key]);
                    submitForm.appendChild(hiddenField);
                }

                // Billing Fields
                var billingData = new FormData(form);
                for (var [key, value] of billingData.entries()) {
                     var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", value);
                    submitForm.appendChild(hiddenField);
                }

                document.body.appendChild(submitForm);
                submitForm.submit();
            },
            "prefill": {
                "name": name,
                "email": email,
                "contact": phone
            },
            "theme": {
                "color": "#e24040"
            },
            "modal": {
                "ondismiss": function(){
                    btn.style.display = 'inline-block';
                    loading.style.display = 'none';
                }
            }
        };
        
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response){
            alert('Payment Failed: ' + response.error.description);
            btn.style.display = 'inline-block';
            loading.style.display = 'none';
        });
        
        rzp1.open();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
        btn.style.display = 'inline-block';
        loading.style.display = 'none';
    });
}
</script>

<?php include('includes/footer.php'); ?>