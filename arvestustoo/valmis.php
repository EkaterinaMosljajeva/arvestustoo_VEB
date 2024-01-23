<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
require_once('conf.php');
//Hüppe lõpp
if (isset($_REQUEST["valmistamine"])) {
    global $yhendus;
    $kask = $yhendus->prepare("UPDATE suusahyppajad SET valmis=NOW() WHERE id=?");
    $kask->bind_param("i", $_REQUEST["valmistamine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}
//Kauguse lisamine
if (isset($_REQUEST["komment"])) {
    if (isset($_REQUEST['uuskomment']) && !empty($_REQUEST["uuskomment"])) {
        global $yhendus;
        $kask = $yhendus->prepare("UPDATE suusahyppajad SET kaugus=? WHERE id=?");
        $kommentplus = $_REQUEST["uuskomment"];
        $kask->bind_param("si", $kommentplus, $_REQUEST["komment"]);
        $kask->execute();
        header("Location: $_SERVER[PHP_SELF]");
        $yhendus->close();
        exit();
    }
}
?>

<!doctype html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Suusahüppevõistlus</title>
</head>
<body>
<button onclick="document.location='logout.php'">Logi välja</button>
<header>
    <h1>Suusahüppevõistlus</h1>
</header>
<?php include('nav.php'); ?>
<h2>Suusahüppaja lisamine</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nimi</th>
        <th>Alustanud</th>
        <th>Kaugus</th>
        <th>Valmis</th>
        <th>Tegevus</th>
    </tr>
    <?php
    global $yhendus;
    $kask = $yhendus->prepare("SELECT id,alustanud,kaugus,valmis,nimi FROM suusahyppajad");
    $kask->bind_result($id, $alus, $kaugus, $valmis, $nimi);
    $kask->execute();
    while ($kask->fetch()) {
        if ($valmis == null) {
            echo "<tr>";
            echo "<td>" . $id . "</td>";
            echo "<td>" . $nimi . "</td>";
            echo "<td>" . $alus . "</td>";
            echo "<td>" . $kaugus . "</td>";
            echo "<td>" . $valmis . "</td>";
            echo "<td>";
            if ($alus != null && $valmis == null) {
                echo "<a href='?valmistamine=$id'>Valmis</a>";
            }
            if ($valmis != null && $kaugus == null) {
                echo "
                    <form action='?'>
                    <input type='hidden' value='$id' name='komment'>
                    <input type='text' name='uuskomment' id='uuskomment'>
                    <input type='submit' value='OK'></form>";
            }
            echo "</td> </tr>";
        }
    }
    ?>
</table>
</body>
</html>
