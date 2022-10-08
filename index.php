<?php
include_once("connect.php");


#$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

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

    <?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL;
    ?>
    <div>
        <?php switch ($action):
                #!-- INCLUIR-->
            case "add": ?>
                <div>
                    <h2>Nova demanda:</h2>
                    <br>
                </div>
                <div>
                    <!--TODO ação do form inserir-->
                    <form action="index.php" method="post">

                        <label>Descrição</label><br>
                        <input type="text" name="descricao_add" id="descricao_add" required>
                        <hr>

                        <label>Custo</label><br>
                        <input type="number" name="custo_add" placeholder="00,00" required>
                        <hr>

                        <label>Usuário</label><br>
                        <select name="id_usuario_add" required>
                            <option value="0">Escolha</option>
                            <?php $query = "SELECT * FROM usuarios ORDER BY nome";
                            $resultado = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

                            while ($obj = sqlsrv_fetch_object($resultado)) { ?>
                                <option value="<?php echo $obj->id_usuario ?>"> <?php echo $obj->nome ?> </option>

                            <?php } ?>

                        </select>
                        <hr>

                        <label>Atendente</label><br>
                        <select name="id_atendente_add" required>
                            <option value="0">Escolha</option>
                            <?php $query = "SELECT * FROM atendentes ORDER BY nome";
                            $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);

                            while ($obj = sqlsrv_fetch_object($resultado)) { ?>
                                <option value="<?php echo $obj->id_atendente ?>"> <?php echo $obj->nome ?> </option>

                            <?php } ?>

                        </select>
                        <hr>

                        <label>Data do cadastro</label><br>
                        <input type="date" name="data_add" required>
                        <hr>

                        <label>Previsão de atendimento</label><br>
                        <input type="date" name="data_previsao" required>
                        <hr>

                        <label>Data de encerramento</label><br>
                        <input type="date" name="data_termino">
                        <hr>

                        <label>Observações</label><br>
                        <input type="text" name="observacoes_add" placeholder="...">
                        <br><br>

                        <button type="submit" name="submit">Adicionar</button>

                    </form>
                </div>
                <?php break; ?>

                <!-- EDITAR-->
            <?php
            case "edit": ?>
                <div>
                    <form>

                    </form>
                </div>

                <!-- DELETAR-->
            <?php
            case "delete": ?>
                <div>
                    <form>

                    </form>
                </div>

                <?php break; ?>

        <?php endswitch; ?>
    </div>


</body>

</html>

<?php

function inserirDemanda()
{
    global $conn;
    $query = "INSERT INTO atendimentos(descricao_demanda,custo,id_usuario,id_atendente,data_cadastro,data_previsao_atendimento,data_termino_atendimento,observacoes)
                    VALUES (?,?,?,?,?,?,?,?)";
    
    $params = [
        $_POST["descricao_add"],
        $_POST["custo_add"],
        $_POST["id_usuario_add"],
        $_POST["id_atendente_add"],
        $_POST["data_add"],
        $_POST["data_previsao"],
        $_POST["data_termino"],
        $_POST["observacoes_add"]
    ];

    $resultado = sqlsrv_query($conn, $query, $params) or die("Falha " . $query);

}




?>