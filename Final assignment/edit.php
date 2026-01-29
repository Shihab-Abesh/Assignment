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

$msg = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');
    $buying_price = trim($_POST['buying_price'] ?? '');
    $selling_price = trim($_POST['selling_price'] ?? '');
    $display = isset($_POST['display']) ? 'Yes' : 'No';

if($name === '' || $buying_price === '' || $selling_price === ''){
    $error = 'All fields are required.';
    }elseif(!is_numeric($buying_price) || !is_numeric($selling_price)){
   $error = 'Prices must be numeric.';
    }else{
 $nameEsc = mysqli_real_escape_string($con, $name);
    $bp = floatval($buying_price);
    $sp = floatval($selling_price);
    $sql = "update products set
            name='{$nameEsc}',
            buying_price={$bp},
            selling_price={$sp},
            display='{$display}'
            where id={$id}";

        if(mysqli_query($con, $sql)){
            header('Location: display.php');
            exit;
        }else{
            $error = 'Update failed.';
        }
    }

$product['name'] = $name;
$product['buying_price'] = $buying_price;
$product['selling_price'] = $selling_price;
$product['display'] = $display;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Product</title>
</head>
<body>
<p>
    <a href="display.php">Back to Display</a> |
    <a href="AddProduct.php">Add Product</a>
</p>

<fieldset>
    <legend><b>EDIT PRODUCT</b></legend>
    <?php if($error != ''){ echo '<p>' . $error . '</p>'; } ?>
    <form method="post" action="edit.php?id=<?php echo $id; ?>">
     <p>
      Name  <br>
     <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" />
    </p>
    <p>
      Buying Price<br>
         <input type="text" name="buying_price" value="<?php echo htmlspecialchars($product['buying_price']); ?>" />
    </p>

    <p>
        Selling Price<br>
        <input type="text" name="selling_price" value="<?php echo htmlspecialchars($product['selling_price']); ?>" />
    </p>
    <hr>
    <p>
        <?php $checked = ($product['display'] === 'Yes') ? 'checked' : ''; ?>
        <input type="checkbox" name="display" id="display" <?php echo $checked; ?> />
            <label for="display">Display</label>
    </p>
    <hr>
    <input type="submit" value="SAVE" />
    </form>
</fieldset>
</body>
</html>
