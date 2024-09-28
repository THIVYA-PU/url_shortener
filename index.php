<?php
include 'config.php';
if (isset($_POST['long_url'])){
    $code = md5(uniqid(rand(1,5000),true));
    $short_url = substr($code,0,6);
    $result = $mysqli->prepare("INSERT into urls (long_url,short_code) VALUES (?,?)");
    $result->bind_param("ss",$_POST['long_url'],$short_url);
    $result->execute();
    $result->close(); 
}

if isset($_GET['short_code']){
    $result = $mysqli->prepare("SELECT * FROM urls where short_code = ?");
    $result->bind_param("s",$_GET['short_code']);
    $result->execute();
    $goto = $result->get_result()->ferch_array();
    $g = $goto[1];
    header("Location:$g");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URLshortener</title>
</head>
<body>
<h1>URL Shortener</h1>
    <form  method="POST">
        <label for="long_url">Enter URL:</label>
        <input type="url" id="long_url" name="long_url" required>
        <button type="submit">Shorten URL</button>
    </form>
</body>
</html>