<?php
$parool="admin";
$cool="superpaev";
$krypt=crypt($parool,$cool);
echo $krypt;
