<?php


$servidor ="localhost";
$usuario ="root";
$senha ="";
$db="datashop";


$conexao=mysqli_connect($servidor, $usuario, $senha, $db);


if(!$conexao){
    die("falha ao se comunicar com o banco de dados: ".mysqli_connect_error());
}


?>