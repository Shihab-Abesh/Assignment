<?php
require_once('db.php');
$con = getConnection();

$q = trim($_GET['q'] ?? '');
$qEsc = mysqli_real_escape_string($con, $q);

if($q === ''){
    $sql = "select * from products where display='Yes' order by id desc";
}else{
    $sql = "select * from products where display='Yes' and name like '%{$qEsc}%' order by id desc";
}

$result = mysqli_query($con, $sql);
$products = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $products[] = $row;
    }
}
?>

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
    <tr><td colspan="3">No match found.</td></tr>
    <?php } ?>
</table>
