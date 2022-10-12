<?php
include_once("connect.php");


#$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<style>
    tr {
        border-bottom: 1px solid #ddd;
    }
</style>

<head>
    <meta charset="UTF-8">
    <title>HOME</title>
</head>

<body>

    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <h2> ATENDIMENTO </h2>
    </div>
    <hr>

    <?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['function'])) { // aqui é onde vai decorrer a chamada se houver um *request* POST
        $function = $_POST['function'];
        if ( $function = "inserirDemanda") {
            inserirDemanda();
        } else {
            echo 'Erro na verificação da função!';
        }
    }
    ?>

    <div>
        <?php $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente;";

        $resultado = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
        ?>

        <table style="width:100%">
            <tr>
                <th>#</th>
                <th>Descrição</th>
                <th>Custo</th>
                <th>Usuário</th>
                <th>Atendente</th>
                <th>Data de abertura</th>
                <th>Previsão de atendimento</th>
                <th>Data de término</th>
                <th>Observações</th>
            </tr>
            <?php $count = 1 ?>
            <?php while ($obj = sqlsrv_fetch_object($resultado)) { ?>

                <tr>
                    <td><?php echo $count++ ?></td>
                    <td><?php echo $obj->descricao_demanda ?></td>
                    <td><?php echo $obj->custo ?></td>
                    <td><?php echo $obj->nomeUsuario ?></td>
                    <td><?php echo $obj->nomeAtendente ?></td>
                    <td><?php echo $obj->data_cadastro->format('d/m/Y'); ?></td>
                    <td><?php echo $obj->data_previsao_atendimento->format('d/m/Y'); ?></td>
                    <td><?php echo $obj->data_termino_atendimento->format('d/m/Y'); ?></td>
                    <td><?php echo $obj->observacoes ?></td>

                    <!--TODO função deletarDemanda e clickDeletar-->
                    <td> <a href="index.php?action=edit&id_demanda='$obj->id_demanda'">Alterar</a> </td>
                    <td> <button type="" onclick="clickDeletar();">Deletar</button> </td>
                </tr>
            <?php } ?>
        </table>



        <form>

        </form>
    </div>

    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <nav>
            <a style="margin-right: 30px" href="index.php">Home</a>

            <a style="margin-right: 30px" href="index.php?action=add">Incluir</a>

            <a style="margin-right: 30px" href="index.php?action=edit">Alterar</a>

            <a href="index.php?action=delete">Deletar</a>
        </nav>
    </div>

    <div>
        <?php switch ($action):
                #!-- INCLUIR-->
            case "add": ?>
                <div>
                    <h2>Nova demanda:</h2>
                    <br>
                </div>
                <div>
                    <form action="index.php" method="post">

                        <input type="hidden" name="function" value="inserirDemanda">

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
                        <input type="date" name="data_termino" value="">
                        <hr>

                        <label>Observações</label><br>
                        <input type="text" name="observacoes_add" placeholder="...">
                        <br><br>

                        <input type="submit" name="submit" value="Adicionar">

                    </form>
                </div>
                <?php break; ?>

                <!-- EDITAR-->

            <?php
            case "edit": ?>
                <script>
                    console.log("AQUI EDITAR");
                </script>
                <div>
                    <?php $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente;";

                    $resultado = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
                    ?>

                    <table style="width:100%">
                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Custo</th>
                            <th>Usuário</th>
                            <th>Atendente</th>
                            <th>Data de abertura</th>
                            <th>Previsão de atendimento</th>
                            <th>Data de término</th>
                            <th>Observações</th>
                        </tr>
                        <?php $count = 1 ?>
                        <?php while ($obj = sqlsrv_fetch_object($resultado)) { ?>

                            <tr>
                                <td><?php echo $count++ ?></td>
                                <td><?php echo $obj->descricao_demanda ?></td>
                                <td><?php echo $obj->custo ?></td>
                                <td><?php echo $obj->nomeUsuario ?></td>
                                <td><?php echo $obj->nomeAtendente ?></td>
                                <td><?php echo $obj->data_cadastro->format('d/m/Y'); ?></td>
                                <td><?php echo $obj->data_previsao_atendimento->format('d/m/Y'); ?></td>
                                <td><?php echo $obj->data_termino_atendimento->format('d/m/Y'); ?></td>
                                <td><?php echo $obj->observacoes ?></td>

                                <!--TODO função deletarDemanda e clickDeletar-->
                                <td> <button type="" onclick="deletarDemanda('123')">Alterar</button> </td>
                                <td> <a href="index.php?action=edit">BLA</a> </td>
                                <td> <button type="" onclick="clickDeletar();">Deletar</button> </td>
                            </tr>
                        <?php } ?>
                    </table>



                    <form>

                    </form>
                </div>

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
    if (mb_strpos($resultado, "Falha") == false) {
        echo "<script>
                alert('Dados adicionados com sucesso!');
             </script>";
             #TODO parei aqui
             #setcookie("sucessoInserir",);
             header("location: index.php");
        exit;
    } else {
        echo "<script>
                alert('Falha' + <?php echo $query ?>);
            </script>";
        exit;
    }
}

#TODO funcoes para deletar
function deletarDemanda($id_demanda)
{
    $query = "DELETE FROM atendimentos WHERE id_demanda = '$id_demanda'";
    var_dump($query);
    die();
}

?>

<script>
    function clickDeletar() {
        var result = "";

        console.log("AQUI");
    }
</script>


<!-- 
 Atendimento hr
 plotar tabela
 hr -> HOME 

-->



<!-- 
<!DOCTYPE html>
<html>
<body>

<h2>JavaScript Confirm Box</h2>


<button onclick="myFunction()">Try it</button>

<p id="demo"></p>

<script>
function myFunction() {
  var txt;
  if (confirm("Press a button!")) {
    txt = "You pressed OK!";
  } else {
    txt = "You pressed Cancel!";
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>

</body>
</html>





-->