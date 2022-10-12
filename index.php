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
        if ($function = "inserirDemanda") {
            inserirDemanda();
        } elseif ($function = "alterarDemanda") {
        } else {
            echo 'Erro na verificação da função!';
        }
    }

    ?>

    <div>
        <?php switch ($action):
                #!-- INCLUIR-->
            case "add": ?>
                <div>
                    <h4>Nova demanda:</h4>
                </div>
                <div>
                    <form action="index.php" method="post">

                        <input type="hidden" name="function" value="inserirDemanda">

                        <label>Descrição</label><br>
                        <input type="text" name="descricao_add" id="descricao_add" required>
                        <hr>

                        <label>Custo</label><br>
                        <input type="number" name="custo_add" placeholder="00,00" min="0" step="0.01" required>
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
                        <input type="date" name="data_add" value="<?php echo date_create()->format('Y-m-d')?>" required>
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


                <?php break; ?>

                <!-- DELETAR-->

            <?php
            case "delete":

                $id_demanda = (isset($_GET['id_demanda'])) ? $_GET['id_demanda'] : NULL;
                deletarDemanda($id_demanda);

                break;

            default:

            ?>
                <div>
                    <?php $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente;";

                    $resultado = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
                    ?>

                    <table style="width:100%">
                        <?php
                        if (!sqlsrv_has_rows($resultado)) { ?>
                            <tr>
                                Não há atendimentos para exibir.
                            </tr>
                        <?php
                        } else { ?>

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

                            <?php
                            $count = 1;
                            while ($obj = sqlsrv_fetch_object($resultado)) { ?>

                                <tr>
                                    <td><?php echo $count++ ?></td>
                                    <td><?php echo $obj->descricao_demanda ?></td>
                                    <td><?php echo "R$" . $obj->custo ?></td>
                                    <td><?php echo $obj->nomeUsuario ?></td>
                                    <td><?php echo $obj->nomeAtendente ?></td>
                                    <td><?php echo $obj->data_cadastro->format('d/m/Y'); ?></td>
                                    <td><?php echo $obj->data_previsao_atendimento->format('d/m/Y'); ?></td>
                                    <td><?php echo $obj->data_termino_atendimento->format('d/m/Y'); ?></td>
                                    <td><?php echo $obj->observacoes ?></td>

                                    <!--TODO função deletarDemanda e clickDeletar-->
                                    <td> <a href="index.php?action=edit&id_demanda= <?php echo $obj->id_demanda ?>">Alterar</a> </td>
                                    <td> <a href="index.php?action=delete&id_demanda=<?php echo $obj->id_demanda ?>" onclick="return confirm(" Confirmar exclusão do atendimento?")">Deletar</a> </td>
                                </tr>
                        <?php }
                        } ?>
                    </table>

                    <!--TODO refazer passo a passo deletar-->

                    <form>

                    </form>
                </div>

        <?php endswitch; ?>
    </div>

    <hr>

    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <nav>
            <a style="margin-right: 30px" href="index.php">Home</a>

            <a style="margin-right: 30px" href="index.php?action=add">Incluir</a>
        </nav>
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
    global $conn;
    $query     = "DELETE FROM atendimentos WHERE id_demanda = $id_demanda";
    $resultado = sqlsrv_query($conn, $query) or die("Falha: " . $query);

    if (mb_strpos($resultado, "Falha") == false) {
?>
        <script>
            alert('Atendimento excluído com sucesso!');
        </script>;
<?php
    } else {
        echo "<script>
                alert('Falha' + <?php echo $query ?>);
            </script>";
    }
    header("location: index.php");
    exit;
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