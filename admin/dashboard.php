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
    height:100vh;
    padding:20px;
}
.sidebar a{
    display:block;
    padding:10px;
    background:#add8e6;
    margin-bottom:10px;
    text-decoration:none;
    color:black;
    border-radius:6px;
    text-align:center;
    font-weight:bold;
}
.sidebar a:hover{
    background:#add8e6;
}
.content{
    flex:1;
    padding:20px;
}
</style>
</head>

<body>
<header style="background:#add8e6; padding:15px; text-align:center;">
    <div style="float:center;">
    <img src="../images/velvet_vogue_logo_8.png" alt="Velvet Vogue Logo" style="height:150px;">
    </div>
</header>

<div class="admin-layout">

<!-- LEFT MENU -->
<div class="sidebar">
    <h3 style="text-align:center;"><b><u>Admin Dashboard</u></b></h3>
    <a href="add_product.php"><button type="button"><b>Add New Product</b></button></a>
    <a href="../products.php"><button type="button"><b>View All Products</b></button></a>
    <a href="admin_logout.php"><button type="button"><b>Logout</b></button></a>
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
