<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$msg = "";

if(isset($_POST['add'])){

    $name  = $_POST['name'] ?? '';
    $cat   = $_POST['category'] ?? '';
    $price = $_POST['price'] ?? '';
    $des   = $_POST['description'] ?? '';
    $siz = $_POST['size'] ?? '';
    $col   = $_POST['color'] ?? '';

    $imgName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $path    = "../images/".$imgName;

    if($name && $cat && $price && $des && $imgName){

        move_uploaded_file($tmpName, $path);

        $conn->query("
            INSERT INTO products(name, category, price, description, image, size, color)
            VALUES('$name','$cat','$price','$des','$imgName','$siz','$col')
        ");

        $msg = "<p style='color:green;'>Product added successfully!</p>";

    }else{
        $msg = "<p style='color:red;'>All fields are required</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add New Product</title>
<link rel="stylesheet" href="../css/style.css">
<style>
 body{
        margin:0;
        padding:0;
        font-family: Arial, sans-serif;

        /* ADMIN page background image */
        background-image: url('../images/bg-fashion_3.jpg');
        background-size: cover;        /* cover whole screen */
        background-position: center;   /* center image */
        background-repeat: no-repeat;  /* no repeat */
        background-attachment: fixed;  /* fixed on scroll */
    }
.admin-layout{
    display:flex;
}
.sidebar{
    width:220px;
    background: #add8e6;
    height:130vh;
    padding:20px;
}
.sidebar a{
    display:block;
    padding:12px;
    background:#f8c8dc;
    margin-bottom:10px;
    text-decoration:none;
    color:black;
    border-radius:6px;
    text-align:center;
    font-weight:bold;
}
.sidebar a:hover{
    background:#ffb6c1;
}
.content{
    flex:1;
    padding:20px;
}
</style>
</head>

<div class="admin-layout">

<div class="sidebar">
    <br><br><br><br><br><br><h3 style="text-align:center;"><b><u>Admin Dashboard</u></b></h3>
    <a href="dashboard.php">Update Product</a><br>
    <a href="../products.php" target="_blank">View Products</a><br>
    <a href="admin_logout.php">Logout</a>
</div>

<body class="add-product-page">

<div class="form-box">

<h2>ADD NEW PRODUCT</h2>
<?php echo $msg; ?>

<form method="post" enctype="multipart/form-data">

    <label>Product Name</label>
    <input type="text" name="name" required>

    <label>Category</label>
    <select name="category" required>
        <option value="">-- Select Category --</option>
        <option>Men</option>
        <option>Women</option>
        <option>Casual</option>
        <option>Formal</option>
    </select>

    <label>Price (Rs)</label>
    <input type="number" name="price" required>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <label>Product Image</label>
    <input type="file" name="image" required>

    <label>size</label>
    <input type="text" name="size" required>

    <label>color</label>
    <input type="text" name="color" required>

    <br><br>
    
    <button type="submit" name="add">Add Product</button>
    <a href="dashboard.php">Cancel</a>

</form>

</div>


</body>
</html>
