<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarks</title>
</head>
<body>
<h2>Añadir Enlace</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Título: <input type="text" name="titulo"><br>
        URL: <input type="text" name="url"><br>
        Categoría: <input type="text" name="categoria"><br>
        <input type="submit" name="submit" value="Añadir">
    </form>

    <hr>

    <h2>Listar Todos los Enlaces</h2>
    <ul>
        <?php
        // Para establecer la conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password ="";
        $dbname = "proyecto";

        $connection = mysqli_connect($servername, $username, $password, $dbname);

        // Compruebo la conexión
        if (!$connection) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        // Añadir enlace si se ha enviado el formulario
        if(isset($_POST['submit'])) {
            $titulo = $_POST['titulo'];
            $url = $_POST['url'];
            $categoria = $_POST['categoria'];

            $sql = "INSERT INTO enlaces (titulo, url, categoria) VALUES ('$titulo', '$url', '$categoria')";
            if (mysqli_query($connection, $sql)) {
                echo "Enlace añadido correctamente";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connection);
            }
        }

        // Consultar y mostrar todos los enlaces
        $sql = "SELECT * FROM enlaces";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<li><a href='".$row["url"]."'>".$row["titulo"]."</a> - Categoría: ".$row["categoria"]."</li>";
            }
        } else {
            echo "0 resultados";
        }
        ?>
    </ul>

    <hr>

    <h2>Listar Enlaces por Categoría</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Categoría: <input type="text" name="categoria">
        <input type="submit" name="submit_categoria" value="Buscar">
    </form>

    <ul>
        <?php
        if(isset($_POST['submit_categoria'])) {
            $categoria = $_POST['categoria'];

            // Consultar y mostrar enlaces por categoría
            $sql = "SELECT * FROM enlaces WHERE categoria LIKE '%$categoria%'";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<li><a href='".$row["url"]."'>".$row["titulo"]."</a> - Categoría: ".$row["categoria"]."</li>";
                }
            } else {
                echo "No se encontraron enlaces para esta categoría";
            }
        }

        mysqli_close($connection);
        ?>
    </ul>
</body>
</html>
