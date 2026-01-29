<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Search</title>
</head>
<body>
<p>
  <a href="AddProduct.php">Add Product</a> |
  <a href="display.php">Display</a>
</p>

<fieldset>
    <legend><b>SEARCH</b></legend>
<input type="text" id="q" placeholder="type a name" />
    <input type="button" value="Search By Name" onclick="doSearch()" />
<hr>
    <div id="result">Loading...</div>
</fieldset>
<script>
function doSearch(){
    var q = document.getElementById('q').value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'AjaxSearch.php?q=' + encodeURIComponent(q), true);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            document.getElementById('result').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
(document.getElementById('q')).addEventListener('keyup', function(){
 doSearch();
});
 doSearch();
</script>
</body>
</html>
