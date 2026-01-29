<?php
require_once('db.php');
$con = getConnection();

$id = intval($_GET['id'] ?? 0);

$product = false;
$r = mysqli_query($con, "select * from products where id={$id} limit 1");
if($r && mysqli_num_rows($r) == 1){
    $product = mysqli_fetch_assoc($r);
}

if(!$product){
    die('Product not found.');
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    mysqli_query($con, "delete from products where id={$id}");
    header('Location: display.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Product</title>
</head>
<body>

<p>
    <a href="display.php">Back to Display</a>
</p>

<fieldset>
    <legend><b>DELETE PRODUCT</b></legend>
    <p>
        Name: <?php echo htmlspecialchars($product['name']); ?><br>
        Buying Price: <?php echo htmlspecialchars($product['buying_price']); ?><br>
        Selling Price: <?php echo htmlspecialchars($product['selling_price']); ?><br>
        Displayable: <?php echo htmlspecialchars($product['display']); ?>
    </p>
    <hr>
    <form method="post" action="delete.php?id=<?php echo $id; ?>">
        <input type="submit" value="Delete" />
    </form>
</fieldset>
</body>
</html>
