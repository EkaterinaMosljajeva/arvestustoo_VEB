<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
require_once ('conf.php');
//Kui keegi ei ole alustanud - see käivitub, kui mitte - see annab vea
if (isset($_REQUEST["alustamine"])) {
    global $yhendus;

    $check = $yhendus->query("SELECT COUNT(*) FROM suusahyppajad WHERE alustanud IS NOT NULL AND valmis IS NULL");
    if ($check && $check->fetch_row()[0] > 0) {
        echo "<script>alert('Keegi on juba alustanud! Oodake!');</script>";
    } else {
        $updateKask = $yhendus->prepare("UPDATE suusahyppajad SET alustanud=NOW() WHERE id=?");
        $updateKask->bind_param("i", $_REQUEST["alustamine"]);
        $updateKask->execute();
        $updateKask->close();

        header("Location: $_SERVER[PHP_SELF]");
        $yhendus->close();
        exit();
    }

    $check->close();
}?>

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
<?php include ('nav.php'); ?>
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
//Tabeli väljund
global $yhendus;
$kask=$yhendus->prepare("SELECT id,alustanud,kaugus,valmis,nimi FROM suusahyppajad");
$kask->bind_result($id,$alus,$kaugus,$valmis,$nimi);
$kask->execute();
while ($kask->fetch()){
    if ($alus == null || ($alus != null && $valmis ==null)) {
        echo "<tr>";
        echo "<td>".$id."</td>";
        echo "<td>".$nimi."</td>";
        echo "<td>".$alus."</td>";
        echo "<td>".$kaugus."</td>";
        echo "<td>".$valmis."</td>";
    if ($alus == null){
        echo "<td><a href='?alustamine=$id'>Alustanud</a></td>";
    }
        echo "</tr>";
    }
}
?>