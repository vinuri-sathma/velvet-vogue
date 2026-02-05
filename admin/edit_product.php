<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

// Fetch product
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $res->fetch_assoc();

if(!$product){
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['update'])){
    $name  = $_POST['name'];
    $cat   = $_POST['category'];
    $price = $_POST['price'];
    $des   = $_POST['description'];
    $siz  = $_POST['size'];
    $col   = $_POST['color'];

    if(!empty($_FILES['image']['name'])){
        $imgName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../images/".$imgName);

        $conn->query("
            UPDATE products SET
            name='$name',
            category='$cat',
            price='$price',
            description='$des',
            image='$imgName',
            size='$siz',
            color='$col'
            WHERE id=$id
        ");
    } else {
        $conn->query("
            UPDATE products SET
            name='$name',
            category='$cat',
            price='$price',
            description='$des',
            size='$siz',
            color='$col'
            WHERE id=$id
        ");
    }

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link rel="stylesheet" href="../css/style.css">
<style>
.admin-layout{
    display:flex;
}
.sidebar{
    width:220px;
    background: #80c1c1;
    height:165vh;
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

<!-- LEFT MENU -->
<div class="sidebar">
    <br><br><br><br><br><br><h3 style="text-align:center;"><b>Dashboard</b></h3>
    <a href="add_product.php">Add Product</a><br>
    <a href="../products.php" target="_blank">View Products</a><br>
    <a href="admin_logout.php">Logout</a>
</div>

<body class="add-product-page">

<div class="form-box">

<h2>Edit Product</h2>

<form method="post" enctype="multipart/form-data">

    <label>Product Name</label>
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

    <label>Category</label>
    <select name="category" required>
        <option <?php if($product['category']=="Men") echo "selected"; ?>>Men</option>
        <option <?php if($product['category']=="Women") echo "selected"; ?>>Women</option>
        <option <?php if($product['category']=="Casual") echo "selected"; ?>>Casual</option>
        <option <?php if($product['category']=="Formal") echo "selected"; ?>>Formal</option>
    </select>

    <label>Price (Rs)</label>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

    <label>Description</label>
    <textarea name="description" required><?php echo $product['description']; ?></textarea>

    <label>Current Image</label><br>
    <img src="../images/<?php echo $product['image']; ?>" width="120"><br><br>

    <label>Change Image (optional)</label>
    <input type="file" name="image">

    <label>size</label>
    <input type="text" name="size" value="<?php echo $product['name']; ?>">

    <label>color</label>
    <input type="text" name="color" value="<?php echo $product['name']; ?>">

    <br><br>
    <button type="submit" name="update">Update Product</button>
    <a href="dashboard.php">Cancel</a>

</form>

</div>
</body>
</html>
