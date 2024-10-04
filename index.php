<?php
include 'config.php';
$url_not_found = false;
if (isset($_POST['long_url'])){
    $long_url = $_POST['long_url'];
    $result = $mysqli->prepare("SELECT short_code FROM urls where long_url = ?");
    $result->bind_param("s",$long_url);
    $result->execute();
    $result->store_result();

    if($result->num_rows>0){
        $result->bind_result($short_url);
        $result->fetch();
    } else{
        $code = md5(uniqid(rand(1,5000),true));
        $short_url = substr($code,0,6);
        $insert = $mysqli->prepare("INSERT into urls (long_url,short_code) VALUES (?,?)");
        $insert->bind_param("ss",$_POST['long_url'],$short_url);
        $insert->execute();
        $insert->close();
    } 
    $result->close();
    $shortened_url= "$short_url" ;
}

if (isset($_GET['short_code'])){
    $result = $mysqli->prepare("SELECT * FROM urls where short_code = ?");
    $result->bind_param("s",$_GET['short_code']);
    $result->execute();
    $goto = $result->get_result()->fetch_array();
    if ($goto) {
        $g = $goto['long_url'];
        header("Location: $g");
        exit();
    } else {
        $url_not_found=true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>URLshortener</title>
</head>
<body>
<?php if ($url_not_found): ?>
    <h1>URL Not Found</h1>
<?php else: ?>
    <div class="container">
    <h1>URL Shortener</h1>
    <form method="POST">
        <label for="long_url">Enter URL:</label>
        <input type="url" id="long_url" name="long_url" required>
        <button type="submit">Shorten URL</button>
    </form>
    <?php if ($shortened_url): ?>
        <p class="shortened-url">Shortened URL: <a href="<?php echo $shortened_url; ?>"><?php echo $shortened_url; ?></a></p>
    <?php endif; ?>
    </div>
<?php endif; ?>
</body>
</html>