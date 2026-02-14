<?php
// Página de conexão
$connect = mysqli_connect('localhost', 'root', '', 'bmmo');

if (!$connect) {
    die('Erro de conexão: ' . mysqli_connect_error());
}
?>