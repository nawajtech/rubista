<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<h2>Pay ₹500</h2>
<button id="payBtn">Pay Now</button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById('payBtn').onclick = function () {

    fetch('/create-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ amount: 500 })
    })
    .then(res => res.json())
    .then(data => {

        var options = {
            "key": data.key,
            "amount": data.amount,
            "currency": "INR",
            "name": "Your Company",
            "description": "Test Payment",
            "order_id": data.order_id,
            "handler": function (response) {

                fetch('/payment-success', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(response)
                })
                .then(res => res.text())
                .then(result => alert(result));
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    });
}
</script>

</body>
</html>
