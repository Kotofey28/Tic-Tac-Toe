<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Game history</title>
</head>
<link rel="stylesheet" type="text/css" href="Style2.css" />
<body>
    <div class="header">
        <h1>Game history</h1>
    </div>
    <div class="page">
        <form method="post">
            <div class="cleaner">
            <input type="submit" name="clean" class="clean" value="Clear" />
            </div>
            <?php
            //чтение из файла
            $file = fopen('C:\Users\user\PhpstormProjects\untitled4\\gaga.txt', 'r');
            while (!feof($file)) {
                echo fgets($file);
                echo '<br>';
            }
            fclose($file);
            ?>
        </form>
    </div>
</body>
</html>

<?php
if( isset( $_POST['clean'] ) )
{
    $f = fopen('C:\Users\user\PhpstormProjects\untitled4\\gaga.txt', 'w');
    fclose($f);
    header("Refresh:0");
}
?>