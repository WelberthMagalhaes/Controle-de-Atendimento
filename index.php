<?php
#include_once("connect.php");




$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>HOME</title>
</head>

<body>

    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <h2> ATENDIMENTO </h2>
    </div>
    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <nav>
            <a style="margin-right: 30px" href="index.php">Home</a>
            
            <a style="margin-right: 30px" href="index.php?action=add">Incluir</a>

            <a style="margin-right: 30px" href="index.php?action=edit">Alterar</a>

            <a href="index.php?action=delete">Deletar</a>
        </nav>
    </div>

    <!--TODO Criar SwitchCase-->

</body>

</html>