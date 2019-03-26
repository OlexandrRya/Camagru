<!DOCTYPE html>
<html>
<head>
    <title>Camagru - General page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <?php include 'header.blade.php';  ?>
    <?php isset($contentPathBlade) ? include "$contentPathBlade" : NULL?>
    <?php include 'footer.blade.php';  ?>
</body>
</html>