<?php
require_once('db.php');

$msg = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $con = getConnection();

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

        $sql = "insert into products (name, buying_price, selling_price, display)
                values('{$nameEsc}', {$bp}, {$sp}, '{$display}')";

        if(mysqli_query($con, $sql)){
            $msg = 'Product saved successfully.';
        }else{
            $error = 'Insert failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Product</title>
</head>
<body>

<p>
    <a href="display.php">Display</a> |
    <a href="search.php">Search</a>
</p>

<fieldset>
    <legend><b>ADD PRODUCT</b></legend>

    <?php if($msg != ''){ echo '<p>' . $msg . '</p>'; } ?>
    <?php if($error != ''){ echo '<p>' . $error . '</p>'; } ?>

    <form method="post" action="AddProduct.php">
    <p>
        Name<br>
        <input type="text" name="name" value="" />
    </p>

    <p>
        Buying Price<br>
        <input type="text" name="buying_price" value="" />
    </p>
    <p>
        Selling Price<br>
        <input type="text" name="selling_price" value="" />
    </p>
    <hr>
    <p>
        <input type="checkbox" name="display" id="display" />
       <label for="display">Display</label>
    </p>

    <hr>

        <input type="submit" value="SAVE" />
    </form>
</fieldset>

</body>
</html>
