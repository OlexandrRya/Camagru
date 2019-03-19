<!DOCTYPE html>
<html>
<head>
    <title>Camagru - General page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="/public/css/main.css">
</head>
<body>
    <?php include 'header.blade.php';  ?>
    <?php isset($contentPathBlade) ? include "$contentPathBlade" : NULL?>
    <?php include 'footer.blade.php';  ?>
</body>
</html>