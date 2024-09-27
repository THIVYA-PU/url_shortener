<?php
include 'config.php';
if (isset($_POST['long_url'])){
    $code = md5(uniqid(rand(1,5000),true));
    $short_url = substr($code,0,6);
    echo "$short_url";

    $result = $mysqli->prepare("INSERT into urls (long_url,short_code) VALUES (?,?)");
    $result->bind_param("ss",$_POST['long_url'],$short_url);
    $result->execute();
    $result->close();
    
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