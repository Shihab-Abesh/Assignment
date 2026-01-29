<?php
require_once('db.php');
$con = getConnection();

$sql = "select * from products where display='Yes' order by id desc";
$result = mysqli_query($con, $sql);

$products = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Display</title>
</head>
<body>

<p>
    <a href="AddProduct.php">Add Product</a> |
    <a href="search.php">Search</a>
</p>

<fieldset>
    <legend><b>DISPLAY</b></legend>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>NAME</th>
            <th>PROFIT</th>
            <th></th>
        </tr>

        <?php foreach($products as $p){
            $profit = floatval($p['selling_price']) - floatval($p['buying_price']);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td><?php echo $profit; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $p['id']; ?>">edit</a>
                &nbsp;&nbsp;
                <a href="delete.php?id=<?php echo $p['id']; ?>">delete</a>
            </td>
        </tr>
        <?php } ?>

        <?php if(count($products) == 0){ ?>
        <tr><td colspan="3">No products .</td></tr>
        <?php } ?>
    </table>
</fieldset>

</body>
</html>
