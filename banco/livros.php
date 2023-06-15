<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once("Connection.php");

    $conn = Connection ::getConnection();
    //print_r($conn);

    if(isset($_POST['submetido'])){
        $titulo = isset($_POST['titulo'])? $_POST['titulo']: null;
        $genero = isset($_POST['genero'])? $_POST['genero']: null;
        $qtd_paginas = isset($_POST['qtd_paginas'])? $_POST['qtd_paginas']: null;
        $autor = isset($_POST['autor'])? $_POST['autor']:null;

        $sql = 'INSERT INTO livros (titulo, genero, qtd_paginas, autor)' . ' VALUES (?, ?, ?, ?)';

        $stmt = $conn->prepare($sql);
        $stmt->execute([$titulo, $genero, $qtd_paginas, $autor]);

        header("location: livros.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros</title>
</head>
<body>
    <h1>Cadastro de livros</h1>

    <h3>Formulário de Livros</h3>

    <form action="" method="POST">
        <input type="text" name="titulo" placeholder="Informe o título"><br><br>
        <select name="genero">
            <option value="">--Selecione o gênero--</option>
            <option value="D"> Drama </option>
            <option value="F"> Ficção </option>
            <option value="R"> Romance </option>
            <option value="O"> Outros </option>
        </select><br><br>
        <input type="number" name="qtd_paginas" placeholder="Informe número de páginas"><br><br>
        <input type="text" name="autor" placeholder="Informe nome do autor(a)"><br><br>
        <button type="submit"> Cadastrar </button>&nbsp;&nbsp;
        <button type="reset"> Limpar </button>

        <input type="hidden" name="submetido" value="1">
    </form>

    <h3>Listagem de Livros</h3>
    <?php
        $sql = "SELECT * FROM livros";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll(); 
        //print_r($result);
    ?>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Título</td>
            <td>Gênero</td>
            <td>Páginas</td>
            <td>Autor(a)</td>
            <td>Excluir</td>
        </tr>
    <?php foreach($result as $reg):?>
        <tr>
            <td><?= $reg ['id']?></td>
            <td><?= $reg ['titulo']?></td>
            <td>
            <?php 
                switch( $reg ['genero']){
                    case 'D':
                        echo "Drama";
                        break;
                    case 'F':
                        echo "Ficção";
                        break;
                    case 'R';
                        echo "Romance";
                        break;
                    case 'O':
                        echo "Outros";
                        break;
                }
                ?>
            </td>
            <td><?= $reg ['qtd_paginas']?></td>
            <td><?= $reg ['autor']?></td>
            <td><a style="text-decoration:none; color:brown;" href="livrosDel.php?id=<?= $reg ['id']?>" onclick="return confirm('Deseja excluir registro?');">Excluir</a></td>
        </tr>
    <?php endforeach; ?>

    </table>
</body>
</html>