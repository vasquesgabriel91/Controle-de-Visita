<?php
$hostname='192.168.0.30';
$dbname = 'ELIPSE_E3';
$username='elipse';
$password='E#lipse#365#ic';

try {
        $dbDB  = new  PDO ("sqlsrv:Server=$hostname;Database=$dbname", $username, $password);
        // echo "conectado";
}catch (PDOException $e) {
        echo "erro";
}

?>

