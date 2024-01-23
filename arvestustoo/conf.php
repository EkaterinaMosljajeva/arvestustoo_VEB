<?php
//$kasutaja='ekaterinamosljajeva';
//$serverinimi='localhost';
//$parool='123456';
//$andmebaas='ekaterinamosljajevaa';
//$yhendus=mysqli_connect($serverinimi, $kasutaja, $parool,$andmebaas);
//$yhendus->set_charset('UTF8');

$kasutaja='d123183_ekaterin';
$serverinimi='d123183.mysql.zonevs.eu';
$parool='murarana2006123';
$andmebaas='d123183_andmebaas';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool,$andmebaas);
$yhendus->set_charset('UTF8');
