<?php require_once('config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <!-- Stripe JavaScript library -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
    <form id="paymentFrm" action="charge.php" method="post">
        <!-- <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
              data-key="<?php echo $stripe['publishable_key']; ?>"
              data-description="Access for a year"
              data-amount="50"
              data-locale="auto"></script> -->
        <p>
            <label>Name</label>
            <input type="text" name="name" size="50" />
        </p>
        <p>
            <label>Email</label>
            <input type="text" name="email" size="50" />
        </p>
        <p>
            <label>Card Number</label>
            <input type="text" name="card_num" size="20" autocomplete="off" class="card-number" />
        </p>
        <p>
            <label>CVC</label>
            <input type="text" name="cvc" size="4" autocomplete="off" class="card-cvc" />
        </p>
        <p>
            <label>Expiration (MM/YYYY)</label>
            <input type="text" name="exp_month" size="2" class="card-expiry-month"/>
            <span> / </span>
            <input type="text" name="exp_year" size="4" class="card-expiry-year"/>
        </p>
        <p class="payment-errors"></p>
        <button type="submit" id="payBtn">Submit Payment</button>
    </form>

    <script type="text/javascript">
        //set your publishable key
        Stripe.setPublishableKey('pk_test_zyBMr9UGh1IaX89X2dACkdV4');

        //callback to handle the response from stripe
        function stripeResponseHandler(status, response) {
            if (response.error) {
                //enable the submit button
                $('#payBtn').removeAttr("disabled");
                //display the errors on the form
                $(".payment-errors").html(response.error.message);
            } else {
                var form$ = $("#paymentFrm");
                //get token id
                var token = response['id'];
                //insert the token into the form
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                //submit form to the server
                form$.get(0).submit();
            }
        }

        $(document).ready(function() {
            //on form submit
            $("#paymentFrm").submit(function(event) {
                event.preventDefault()
                //disable the submit button to prevent repeated clicks
                $('#payBtn').attr("disabled", "disabled");

                //create single-use token to charge the user
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);

                //submit from callback
                return false;
            });
        });

    </script>
</body>
</html>