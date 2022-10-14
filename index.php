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


    #Inserir/alterar/pesquisar
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['function'])) { // aqui é onde vai decorrer a chamada se houver um *request* POST
        $function = $_POST['function'];
        if ($function == "inserirDemanda") {
            inserirDemanda();
        } elseif ($function == "alterarDemanda") {
            $id_demanda = (isset($_GET['id_demanda'])) ? $_GET['id_demanda'] : NULL;
            alterarDemanda($id_demanda);
        } elseif ($function == "pesquisaPendentes") {
            pesquisaPendentes();
        } else {
            echo 'Erro na verificação da função!';
        }
    }



    ?>

    <div>
        <?php switch ($action):
                #INCLUIR
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
                        <input type="date" name="data_add" value="<?php echo date_create()->format('Y-m-d') ?>" required>
                        <hr>

                        <label>Previsão de atendimento</label><br>
                        <input type="date" name="data_previsao" required>
                        <hr>

                        <label>Data de encerramento</label><br>
                        <input type="date" name="data_termino" value="NULL">
                        <hr>

                        <label>Observações</label><br>
                        <input type="text" name="observacoes_add" placeholder="...">
                        <br><br>

                        <input type="submit" name="submit" value="Adicionar">

                    </form>
                </div>
            <?php break;

                #EDITAR
            case "edit": ?>
                <?php $id_demanda = (isset($_GET['id_demanda'])) ? $_GET['id_demanda'] : NULL;

                $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, a.id_usuario, a.id_atendente, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente
                                        WHERE a.id_demanda = $id_demanda;";

                $resultado = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
                $obj = sqlsrv_fetch_object($resultado);
                ?>


                <div>
                    <h4>Alterar:</h4>
                </div>
                <div>
                    <form action="index.php?id_demanda=<?php echo $obj->id_demanda ?>" method="post">

                        <input type="hidden" name="function" value="alterarDemanda">

                        <label>Descrição</label><br>
                        <input type="text" name="descricao" id="descricao_add" value="<?php echo $obj->descricao_demanda ?>" required>
                        <hr>

                        <label>Custo</label><br>
                        <input type="number" name="custo" placeholder="00,00" value="<?php echo $obj->custo ?>" min="0" step="0.01" required>
                        <hr>
                        <label>Usuário</label><br>
                        <select name="id_usuario" required>
                            <option value="<?php echo $obj->id_usuario ?>"> <?php echo $obj->nomeUsuario ?> </option>
                            <?php var_dump($obj->nomeUsuario) ?>
                            <?php $query = "SELECT * FROM usuarios ORDER BY nome";
                            $resultado = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

                            while ($obj2 = sqlsrv_fetch_object($resultado)) { ?>
                                <option value="<?php echo $obj2->id_usuario ?>"> <?php echo $obj2->nome ?> </option>

                            <?php } ?>

                        </select>
                        <hr>

                        <label>Atendente</label><br>
                        <select name="id_atendente" required>
                            <option value="<?php echo $obj->id_atendente ?>"> <?php echo $obj->nomeAtendente ?> </option>
                            <?php $query = "SELECT * FROM atendentes ORDER BY nome";
                            $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);

                            while ($obj3 = sqlsrv_fetch_object($resultado)) { ?>
                                <option value="<?php echo $obj3->id_atendente ?>"> <?php echo $obj3->nome ?> </option>

                            <?php } ?>

                        </select>
                        <hr>

                        <label>Data do cadastro</label><br>
                        <input type="date" name="data" value="<?php echo $obj->data_cadastro->format('Y-m-d') ?>" required>
                        <hr>

                        <label>Previsão de atendimento</label><br>
                        <input type="date" name="data_previsao" value="<?php echo $obj->data_previsao_atendimento->format('Y-m-d') ?>" required>
                        <hr>

                        <label>Data de encerramento</label><br>
                        <input type="date" name="data_termino" value="<?php if ($obj->data_termino_atendimento->format('d/m/Y') == '01/01/1900') {
                                                                            echo "";
                                                                        } else {
                                                                            echo $obj->data_termino_atendimento->format('Y-m-d');
                                                                        } ?>">
                        <hr>

                        <label>Observações</label><br>
                        <input type="text" name="observacoes" placeholder="..." value="<?php echo $obj->observacoes ?>">
                        <br><br>

                        <input type="submit" name="submit" value="Salvar">

                    </form>
                </div>

            <?php break;

                #DELETAR            
            case "delete":

                $id_demanda = (isset($_GET['id_demanda'])) ? $_GET['id_demanda'] : NULL;
                deletarDemanda($id_demanda);
                break;

                #PESQUISAR
            case "pesquisa": ?>

                <h3>Pesquisar Atendimentos</h3>
                <form name="pesquisar" method="post" action="index.php?action=pesquisaChave">
                    <table>
                        <tr>
                            <td>
                                <a href="index.php?action=pesquisaChave&pesquisa=pendentes">Atendimentos pendentes</a><br><br>
                                <a href="index.php?action=pesquisaChave&pesquisa=finalizados">Atendimentos finalizados</a>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table>
                        <tr>
                            <td>Usuário:</td>
                            <td><input type="text" name="usuario" size="40" placeholder="Inserir nome ou parte dele"></td>
                        </tr>
                        <tr>
                            <td>Data do cadastro:</td>
                            <td>
                                <input type="date" id="dataInicio" name="dataInicio">
                                <label>a</label>
                                <input type="date" id="dataFim" name="dataFim">
                                <small>Preencher os dois campos, ou nenhum!</small>
                            </td>
                        </tr>

                        <tr>
                            <td>Atendente:</td>
                            <td>
                                <select name="atendente">

                                    <option value="">Escolha</option>
                                    <?php $query = "SELECT * FROM atendentes ORDER BY nome";
                                    $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);

                                    while ($obj = sqlsrv_fetch_object($resultado)) { ?>
                                        <option value="<?php echo $obj->nome ?>"> <?php echo $obj->nome ?> </option>

                                    <?php } ?>

                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="finalizado">Atendimento finalizado</label>
                            </td>
                            <td>
                                <input type="checkbox" id="finalizado" name="finalizado" value="check"><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="pendente">Atendimento pendente</label>
                            </td>
                            <td>
                                <input type="checkbox" id="pendente" name="pendente" value="check"><br>
                            </td>
                        </tr>


                    </table>
                    <br>
                    <input type=submit class=bt Value=Pesquisar>
                </form>
                <br>
                <br>


            <?php break;

                # PAGINA PESQUISA                                        
            case "pesquisaChave":

                $pesquisa = (isset($_GET['pesquisa'])) ? $_GET['pesquisa'] : NULL;


                if ($pesquisa == "pendentes") {
                    $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente
										WHERE (a.data_termino_atendimento = '1900-01-01' OR a.data_termino_atendimento = '');";

                    $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);
                } elseif ($pesquisa == "finalizados") {
                    $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente
										WHERE NOT (a.data_termino_atendimento = '1900-01-01' OR a.data_termino_atendimento = '');";

                    $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);
                } elseif (($_POST['finalizado'] == ""      and $_POST['pendente'] == "") or  ($_POST['finalizado'] == "check" and $_POST['pendente'] == "check")) {
                    #var_dump('AQUI'); die(); #TODO verificar erro com dados Ela e pendente "check"

                    if ($_POST["dataInicio"] == "") {
                        $dataInicio = "1900-01-01";
                    } else {
                        $dataInicio = $_POST["dataInicio"];
                    }

                    if ($_POST["dataFim"] == "") {
                        $dataFim = date_create()->format('Y-m-d');
                    } else {
                        $dataFim = $_POST["dataFim"];
                    }

                    $usuario = $_POST["usuario"];
                    $atendente = $_POST["atendente"];

                    $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente
                                        WHERE (u.nome LIKE '%$usuario%')
                                              AND   (a.data_cadastro BETWEEN '$dataInicio' AND '$dataFim') 
                                              AND   (aten.nome LIKE '%$atendente%'); ";


                    $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);
                } elseif ($_POST['finalizado'] == "check" and $_POST['pendente'] == "") {

                    if ($_POST["dataInicio"] == "") {
                        $dataInicio = "1900-01-01";
                    } else {
                        $dataInicio = $_POST["dataInicio"];
                    }

                    if ($_POST["dataFim"] == "") {
                        $dataFim = date_create()->format('Y-m-d');
                    } else {
                        $dataFim = $_POST["dataFim"];
                    }
                    $usuario = $_POST["usuario"];
                    $atendente = $_POST["atendente"];

                    $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente
										WHERE NOT (a.data_termino_atendimento = '1900-01-01' OR a.data_termino_atendimento = '')
                                              AND (u.nome LIKE '%$usuario%')
                                              AND (a.data_cadastro BETWEEN '$dataInicio' AND '$dataFim') 
                                              AND (aten.nome LIKE '%$atendente%'); ";


                    $resultado = sqlsrv_query($conn, $query) or die("Falha " . $query);
                } elseif ($_POST['finalizado'] == ""      and $_POST['pendente'] == "check") {

                    if ($_POST["dataInicio"] == "") {
                        $dataInicio = "1900-01-01";
                    } else {
                        $dataInicio = $_POST["dataInicio"];
                    }

                    if (
                        $_POST["dataFim"] == ""
                    ) {
                        $dataFim = date_create()->format('Y-m-d');
                    } else {
                        $dataFim = $_POST["dataFim"];
                    }
                    $usuario = $_POST["usuario"];
                    $atendente = $_POST["atendente"];

                    $query = "SELECT  a.id_demanda, a.descricao_demanda, a.custo, u.nome AS 'nomeUsuario', aten.nome AS 'nomeAtendente', a.data_cadastro, a.data_previsao_atendimento, a.data_termino_atendimento, a.observacoes
	                                    FROM atendimentos AS a
		                                INNER JOIN usuarios   AS u    ON a.id_usuario = u.id_usuario
                                        INNER JOIN atendentes AS aten ON a.id_atendente = aten.id_atendente
										WHERE (a.data_termino_atendimento = '1900-01-01' OR a.data_termino_atendimento = '')
                                              AND (u.nome LIKE '%$usuario%')
                                              AND (a.data_cadastro BETWEEN '$dataInicio' AND '$dataFim') 
                                              AND (aten.nome LIKE '%$atendente%'); ";


                    $resultado = sqlsrv_query($conn, $query, $params) or die("Falha " . $query);
                }

            ?>

                <h3>Pesquisar Atendimentos</h3>

                <div>
                    <table style="width:100%">
                        <?php
                        if (!sqlsrv_has_rows($resultado)) { ?>
                            <tr>
                                <th>
                                    <h4> Dados não encontrados.</h4>
                                </th>
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
                                    <td><?php echo "R$" . $obj->custo;
                                        $somaCustos += $obj->custo ?></td>
                                    <td><?php echo $obj->nomeUsuario ?></td>
                                    <td><?php echo $obj->nomeAtendente ?></td>
                                    <td><?php echo $obj->data_cadastro->format('d/m/Y'); ?></td>
                                    <td><?php echo $obj->data_previsao_atendimento->format('d/m/Y'); ?></td>
                                    <td>
                                        <?php if ($obj->data_termino_atendimento->format('d/m/Y') == '01/01/1900') {
                                            echo "";
                                        } else {
                                            echo $obj->data_termino_atendimento->format('d/m/Y');
                                        } ?>
                                    </td>
                                    <td><?php echo $obj->observacoes ?></td>

                                    <td> <a href="index.php?action=edit&id_demanda=<?php echo $obj->id_demanda ?>">Alterar</a> </td>
                                    <td> <a href="index.php?action=delete&id_demanda=<?php echo $obj->id_demanda ?>">Deletar</a> </td>
                                </tr>
                        <?php }
                        } ?>
                        <tr>
                            <td></td>
                            <td><strong> Soma dos custos: </strong></td>
                            <td><strong> <?php echo "R$" . $somaCustos ?> </strong></td>
                        </tr>

                    </table>



                </div>


            <?php break;
                #HOME
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
                            $somaCustos = 0;
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
                                    <td>
                                        <?php if ($obj->data_termino_atendimento->format('d/m/Y') == '01/01/1900') {
                                            echo "";
                                        } else {
                                            echo $obj->data_termino_atendimento->format('d/m/Y');
                                        } ?>
                                    </td>
                                    <td><?php echo $obj->observacoes ?></td>

                                    <td> <a href="index.php?action=edit&id_demanda=<?php echo $obj->id_demanda ?>">Alterar</a> </td>
                                    <td> <a href="index.php?action=delete&id_demanda=<?php echo $obj->id_demanda ?>">Deletar</a> </td>
                                </tr>
                        <?php }
                        } ?>
                        
                    </table>
                </div>

        <?php endswitch; ?>
    </div>

    <hr>

    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <nav>
            <a style="margin-right: 30px" href="index.php">Home</a>

            <a style="margin-right: 30px" href="index.php?action=add">Incluir</a>

            <a style="margin-rigth: 30px" href="index.php?action=pesquisa">Pesquisar</a>
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
             </scrip>";
        header("location: index.php");
        exit;
    } else {
        echo "<script>
                alert('Falha' + <?php echo $query ?>);
            </script>";
        exit;
    }
}

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
        <?php header("location: index.php");
        exit; ?>
<?php
    } else {
        echo "<script>
                alert('Falha' + <?php echo $query ?>);
            </script>";
    }
}

function alterarDemanda($id_demanda)
{
    global $conn;
    $query = "UPDATE atendimentos SET descricao_demanda = ?,  custo = ?, id_usuario = ?, id_atendente = ?, data_cadastro = ?, data_previsao_atendimento = ?, data_termino_atendimento = ?, observacoes = ?
	            WHERE id_demanda = ?";

    if ($_POST["data_termino"] == "") {
        $data_termino = "1900-01-01";
    } else {
        $data_termino = $_POST["data_termino"];
    }
    $params = [
        $_POST["descricao"],
        $_POST["custo"],
        $_POST["id_usuario"],
        $_POST["id_atendente"],
        $_POST["data"],
        $_POST["data_previsao"],
        $data_termino,
        $_POST["observacoes"],
        $id_demanda
    ];
    $resultado = sqlsrv_query($conn, $query, $params) or die("Falha " . $query);
    header("location:index.php");
    exit;
}

#PESQUISAS
#PESQUISA PENDENTES
function pesquisaPendentes()
{
}


?>




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