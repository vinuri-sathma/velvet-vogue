<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Velvet Vogue</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        background-image: url('images/bg-fashion.jpg'); /* your image path */
        background-size: cover;        /* make image cover whole page */
        background-position: center;   /* center the image */
        background-repeat: no-repeat;  /* no repeating */
        background-attachment: fixed;  /* stay fixed when scrolling */
    }

        .dashboard{
            background:#add8e6;
            padding:20px;
            margin:20px auto;
            width:80%;
            text-align:center;
            border-radius:10px;
        }
        .dashboard a, .dashboard button{
            display:inline-block;
            margin:10px;
            padding:12px 20px;
            background:#f8c8dc;
            border:none;
            border-radius:6px;
            text-decoration:none;
            color:black;
            font-weight:bold;
            cursor:pointer;
        }
        .dashboard a:hover, .dashboard button:hover{
            background:#ffb6c1;
        }
        .products{
            display:flex;
            gap:20px;
            justify-content:center;
            flex-wrap:wrap;
        }
        .product{
            background:#fff;
            padding:15px;
            width:200px;
            text-align:center;
            border-radius:8px;
        }
        footer{
            background:#add8e6;
            text-align:center;
            padding:10px;
            margin-top:30px;
        }

        /* PROMOTION */
        .promo {
            background: linear-gradient(to right, #c3ffb6, #e6e6ad);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            color: #333333;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 2px 8px rgb(115, 240, 48);
        }
        
    </style>
</head>

<body>

<!-- HEADER -->
<header>
    <h1>Velvet Vogue</h1>
    <p>EMBRACE THE ELEGANCE WITHIN YOU </p>
    <nav>
        <?php if(!isset($_SESSION['user'])){ ?>
            <a href="login.php">Login</a> |
            <a href="products.php" target="_blank">All Products</a> |
            <a href="contact.php" target="_blank">Contact Us</a>
        <?php } ?>
    </nav>
</header>

<!-- WELCOME SECTION -->
<section style="text-align:center; padding:30px;">
    <h2>Welcome to Velvet Vogue</h2>
    <p>
        Velvet Vogue is your destination for elegant, modern, and affordable fashion.
        We bring you carefully selected styles for men and women, designed to match
        both casual and formal lifestyles. Shop with confidence and style.
    </p>
</section>
<!-- CUSTOMER DASHBOARD -->
<?php if(isset($_SESSION['user'])){ ?>
<div class="dashboard">
    <h2><b>Customer Dashboard</b></h2>

    <a href="products.php">All Products</a>
    <a href="cart.php">View Cart</a>

    <form method="post" action="logout.php" style="display:inline;">
        <button type="submit">Logout</button>
    </form>

    <form method="post" action="contact.php" style="display:inline;">
        <button type="submit">Contact Us</button>
    </form>
</div>
<?php } ?><br><br>

<!-- PROMOTIONS -->
<div class="section">

    <div class="card-grid">
        <div class="promo">
            <h2><b>🎊 TODAY SALEDAY 🎊</b></h2>
            <h3>BIG EVENT</h3>
            <h4>10% OFF </h4>
            <P> 26th of Jan 2026</p>
            <p><b>PROMO CODE:TYX2026</b></p>
        </div>
    </div>
</div><br><br>

<!-- NEW PRODUCTS -->
<h2 style="text-align:center;"><b>NEW PRODUCTS</b></h2>

<div class="products">
<?php
$res = $conn->query("SELECT * FROM products LIMIT 3");
while($row = $res->fetch_assoc()){
?>
    <div class="product">
        <h3><?php echo $row['name']; ?></h3>
        <p>Rs <?php echo $row['price']; ?></p>

        <!-- View is ONLY for highlighting -->
        <a href="products.php?highlight=<?php echo $row['id']; ?>">
            View
        </a>
    </div>
<?php } ?>
</div>


</div>

<!-- FOOTER -->
<footer>
    <p>© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>

</body>
</html>
