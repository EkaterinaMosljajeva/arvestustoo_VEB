<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
require_once ('conf.php');
session_start();
$sort = "nimi";
$otsisona = "";
//Registreerimine|Tabelisse lisamine
if(isset($_REQUEST["suusahyppevoistlus"]) && !empty($_REQUEST["suusahyppevoistlus"])){

    if (is_numeric($_REQUEST["suusahyppevoistlus"])) {
        // Kui see ei ole numbriline, saame vea.
        echo "<script>alert('Viga: Sisestage ainult tähed, mitte numbrid!');</script>";
        echo "<script>window.location.href = '$_SERVER[PHP_SELF]';</script>";
        exit();
    }

    global $yhendus;
    $kask = $yhendus->prepare("INSERT INTO suusahyppajad (nimi) VALUES(?)");
    $kask->bind_param("s", $_REQUEST["suusahyppevoistlus"]);
    $kask->execute();
    //$id = mysqli_insert_id($yhendus);
    //echo "Sinu ID on: " .$id;
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    //exit();
}
//Sorteerimine
function kuvamine($sort="", $otsisona=""){
    global $yhendus;
    $sort_list = array("id", "alustanud", "kaugus", "valmis", "nimi");
    if(!in_array($sort, $sort_list)) {
        return "Seda tulpa ei saa sorteerida";
    }
    $paring = $yhendus->prepare("SELECT id,alustanud,kaugus,valmis,nimi FROM suusahyppajad WHERE 
    (id LIKE '%$otsisona%' OR alustanud LIKE '%$otsisona%' OR kaugus LIKE '%$otsisona%'OR valmis LIKE '%$otsisona%'OR nimi LIKE '%$otsisona%')
    ORDER by $sort");
    $paring->bind_result($id, $alustanud, $kaugus, $valmis, $nimi);
    $paring->execute();
    $andmed = array();
    while($paring->fetch()) {
        $inimene = new stdClass();
        $inimene->id = $id;
        $inimene->nimi = $nimi;
        $inimene->alustanud = $alustanud;
        $inimene->kaugus = $kaugus;
        $inimene->valmis = $valmis;
        array_push($andmed, $inimene);
    }
    return $andmed;
    header("Location: $_SERVER[PHP_SELF]");
}
//Kustutamine
if (isset($_REQUEST["kustuta"])) {
    global $yhendus;
    $kask=$yhendus->prepare("DELETE FROM suusahyppajad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}
$inimesed=kuvamine($sort, $otsisona);
//Kontrollida, kas admin
function isAdmin(){
    return $_SESSION['onAdmin'] && isset($_SESSION['onAdmin']);
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
<?php
    if(isset($_SESSION['kasutaja'])){
        ?>
        <button onclick="document.location='logout.php'">Logi välja</button>
        <?php
    } else {
        ?>
        <button onclick="document.location='register.php'">Register</button>
        <button onclick="document.location='login.php'">Logi sisse</button>
        <?php
    }
    ?>
<header>
    <h1>Suusahüppevõistlus</h1>
</header>
<?php
//Navigeerimise kuvamine ainult juhul, kui admin
    if (isset($_SESSION["kasutaja"])) {
        if (isAdmin()) {
            include ('nav.php');
    }}
    ?>
<h2>Suusahüppaja lisamine</h2>
<table border="1">
    <tr>
        <!--<th><a href="sussahuppajaLisa.php?sort=id">ID</a></th>
        <th><a href="sussahuppajaLisa.php?sort=nimi">Nimi</a></th>
        <th><a href="sussahuppajaLisa.php?sort=alustanud">Alustanud</a></th>
        <th><a href="sussahuppajaLisa.php?sort=kaugus">Kaugus</a></th>
        <th><a href="sussahuppajaLisa.php?sort=valmis">Valmis</a></th>-->
        <th>ID</th>
        <th>Nimi</th>
        <th>Alustanud</th>
        <th>Kaugus</th>
        <th>Valmis</th>
        <?php
        if (isset($_SESSION["kasutaja"])) {
        if (isAdmin()) {
            echo "<th>Tegevus</th>";
        }} ?>
    </tr>
<?php
global $yhendus;
$kask=$yhendus->prepare("SELECT id,alustanud,kaugus,valmis,nimi FROM suusahyppajad");
$kask->bind_result($id,$alus,$kaugus,$valmis,$nimi);
$kask->execute();
while ($kask->fetch()){
        echo "<tr>";
        echo "<td>".$id."</td>";
        echo "<td>".$nimi."</td>";
        echo "<td>".$alus."</td>";
        echo "<td>".$kaugus."</td>";
        echo "<td>".$valmis."</td>";
        if (isset($_SESSION["kasutaja"])) {
        if (isAdmin()) {
            echo "<td>";
            echo "<a href='?kustuta=$id'>Kustuta</a>";
            echo "</td>";
        }}
        echo "</tr>";
}
if(isset($_SESSION['kasutaja'])){
        ?>
    <form action="?">
        <input type="text" name="suusahyppevoistlus" id="suusahyppevoistlus">
        <input type="submit" value="Lisa">
    </form>
    <?php
    }
    ?>
</table>
</body>
</html>

