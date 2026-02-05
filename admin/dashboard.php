<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$res = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/style.css">

<style>
.admin-layout{
    display:flex;
}
.sidebar{
    width:220px;
    background: #80c1c1;
    height:100vh;
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

<body>
<header>
    <h1>Velvet Vogue</h1>
    <p>EMBRACE THE ELEGANCE WITHIN YOU</P>
</header>

<div class="admin-layout">

<!-- LEFT MENU -->
<div class="sidebar">
    <h3 style="text-align:center;"><b>Admin Dashboard</b></h3>
    <a href="add_product.php">Add Product</a><br>
    <a href="../products.php" target="_blank">View Products</a><br>
    <a href="admin_logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="content">

<h2 style="text-align:center;">Product List</h2>

<table border="1" width="100%" cellpadding="10">
<tr style="background:#add8e6;">
    <th>ID</th>
    <th>Name</th>
    <th>Price</th>
    <th>Category</th>
    <th>Action</th>
</tr>

<?php
while($p = $res->fetch_assoc()){
?>
<tr>
    <td><?php echo $p['id']; ?></td>
    <td><?php echo $p['name']; ?></td>
    <td>Rs <?php echo $p['price']; ?></td>
    <td><?php echo $p['category']; ?></td>
    <td>
        <!-- THIS IS THE IMPORTANT PART -->
        <a href="edit_product.php?id=<?php echo $p['id']; ?>">
            Update
        </a>
        <a href="delete_product.php?id=<?php echo $p['id']; ?>"
            onclick="return confirm('Are you sure you want to delete this product?');">
            Delete
        </a>

    </td>
</tr>
<?php } ?>

</table>

</div>
</div>

<div style="width: 1520px; background:#add8e6; padding:09px; border-radius:10px;">
<footer>
    <p style="text-align:center;">© <?php echo date('Y'); ?> Velvet Vogue. All Rights Reserved.</p>
</footer>
</div>

</body>
</html>
