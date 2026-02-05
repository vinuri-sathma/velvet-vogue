<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user'];   // ✅ CORRECT
$total = 0;

// Calculate cart total
if(isset($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $item){
        $total += $item['price'] * $item['qty'];
    }
} elseif(isset($_SESSION['checkout_total'])){
    // fallback to checkout total set by checkout.php (DB-based cart)
    $total = floatval($_SESSION['checkout_total']);
}

$msg = "";

if(isset($_POST['pay_now'])){
    // Personal details
    $cust_name = trim($_POST['cust_name'] ?? '');
    $cust_email = trim($_POST['cust_email'] ?? '');
    $cust_phone = trim($_POST['cust_phone'] ?? '');
    $cust_address = trim($_POST['cust_address'] ?? '');

    // Payment method and card (demo only)
    $method = $_POST['payment_method'] ?? '';
    $card_name = trim($_POST['card_name'] ?? '');
    $card_number = trim($_POST['card_number'] ?? '');
    $card_expiry = trim($_POST['card_expiry'] ?? '');
    $card_cvv = trim($_POST['card_cvv'] ?? '');

    // Basic validations
    if($method == ''){
        $msg = "<p style='color:red;'>Please select a payment method.</p>";
    } elseif($cust_name == '' || $cust_email == '' || $cust_phone == '' || $cust_address == ''){
        $msg = "<p style='color:red;'>Please fill in all personal details.</p>";
    } else {
        // If Card Payment selected, validate card demo fields
        if($method === 'Card Payment'){
            // very basic demo validation: card number 13-19 digits, cvv 3-4 digits
            $digitsOnly = preg_replace('/\D/', '', $card_number);
            if($card_name == '' || $card_number == '' || $card_expiry == '' || $card_cvv == ''){
                $msg = "<p style='color:red;'>Please fill in all card details for Card Payment.</p>";
            } elseif(strlen($digitsOnly) < 13 || strlen($digitsOnly) > 19){
                $msg = "<p style='color:red;'>Please enter a valid card number.</p>";
            } elseif(!preg_match('/^\d{3,4}$/', $card_cvv)){
                $msg = "<p style='color:red;'>Please enter a valid CVV (3 or 4 digits).</p>";
            }
        }
    }

    // If no error so far, demo mode - just redirect (no database save)
    if($msg == ''){
        // Clear cart and checkout total
        unset($_SESSION['cart']);
        unset($_SESSION['checkout_total']);

        // Redirect to order success page
        header("Location: order_success.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - Velvet Vogue</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .payment-box{
            max-width:540px;
            margin:40px auto;
            background:#f7fbff;
            padding:20px 24px;
            border-radius:8px;
            box-shadow:0 4px 18px rgba(0,0,0,0.08);
            font-family:Arial,Helvetica,sans-serif;
        }
        .payment-box h2{margin-top:0}
        label{display:block; font-weight:600; margin-bottom:6px}
        input, select, textarea{
            width:100%;
            padding:10px 12px;
            margin-bottom:12px;
            border:1px solid #d7e3ef;
            border-radius:6px;
            box-sizing:border-box;
            font-size:14px;
        }
        .two-col{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        button{
            width:100%;
            padding:12px;
            background:#0066cc;
            color:#fff;
            border:none;
            border-radius:6px;
            font-weight:700;
            cursor:pointer;
            font-size:15px;
        }
        button:hover{ opacity:0.95 }
        .muted{color:#6b7280;font-size:13px}
    </style>

    <script>
        function toggleCardFields(){
            var method = document.getElementById("method").value;
            var cardFields = document.getElementById("cardFields");
            var show = (method === "Card Payment");
            cardFields.style.display = show ? "block" : "none";

            // toggle required attributes for card inputs
            ['card_name','card_number','card_expiry','card_cvv'].forEach(function(id){
                var el = document.getElementById(id);
                if(!el) return;
                if(show) el.setAttribute('required','required'); else el.removeAttribute('required');
            });
        }
    </script>
</head>
<body>

<header style="background:#add8e6; padding:15px; text-align:center;">
    <h1>Velvet Vogue</h1>
</header>

<div class="payment-box">
    <h2>Payment Page</h2>
    <h3>Total Amount: Rs <?php echo $total; ?></h3>

    <?php echo $msg; ?>

    <?php if($total > 0){ ?>
    <form method="post">

        <h4>Personal Details</h4>
        <label>Full Name</label>
        <input type="text" name="cust_name" id="cust_name" placeholder="Your full name" required>

        <div class="two-col">
            <div>
                <label>Email</label>
                <input type="email" name="cust_email" placeholder="you@example.com" required>
            </div>
            <div>
                <label>Phone</label>
                <input type="tel" name="cust_phone" placeholder="0123456789" required>
            </div>
        </div>

        <label>Delivery Address</label>
        <textarea name="cust_address" rows="3" placeholder="Street, City, PIN" required></textarea>

        <label>Select Payment Method</label>
        <select name="payment_method" id="method" onchange="toggleCardFields()" required>
            <option value="">-- Select Method --</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="Card Payment">Card Payment</option>
            <option value="Online Transfer">Online Bank Transfer</option>
        </select>

        <!-- Card Fields -->
        <div id="cardFields" style="display:none;">
            <h4>Card Details (Demo)</h4>
            <label>Cardholder Name</label>
            <input type="text" name="card_name" id="card_name" placeholder="Name on card">

            <label>Card Number</label>
            <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" maxlength="23" pattern="[0-9\s]+">

            <div class="two-col">
                <div>
                    <label>Expiry (MM/YY)</label>
                    <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/YY">
                </div>
                <div>
                    <label>CVV</label>
                    <input type="text" name="card_cvv" id="card_cvv" placeholder="123" maxlength="4">
                </div>
            </div>

            <p class="muted">This is a demo form — do not enter real card data on a public site.</p>
        </div>

        <button type="submit" name="pay_now">Pay Now</button>
    </form>
    <?php } else { ?>
        <p>Your cart is empty.</p>
    <?php } ?>

</div>

<footer style="background:#add8e6; text-align:center; padding:10px; margin-top:40px;">
    © <?php echo date('Y'); ?> Velvet Vogue
</footer>

</body>
</html>
