<!DOCTYPE html>
<html>

<head>
    <title>Lista de Usuarios</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="./estilos.css">

    <!-- JQUEY -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script> -->

</head>

<body>
    <div class="box">
        <form class="form">

            <h2>Lista de Usuarios Registrados</h2>
        
        <?php
        // Verificar si se enviaron los datos del formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los valores del formulario
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $edad = $_POST["edad"];
            $estado_civil = $_POST["estado_civil"];
            $sexo = $_POST["sexo"];
            $sueldo = $_POST["sueldo"];

            // Crear un arreglo con los datos del nuevo usuario
            $nuevoUsuario = array(
                "nombre" => $nombre,
                "apellido" => $apellido,
                "edad" => $edad,
                "estado_civil" => $estado_civil,
                "sexo" => $sexo,
                "sueldo" => $sueldo
            );

            // Agregar el nuevo usuario al arreglo de usuarios
            $usuarios = array();
            if (file_exists("usuarios.json")) {
                // Leer el archivo JSON existente si existe
                $usuarios = json_decode(file_get_contents("usuarios.json"), true);
            }
            $usuarios[] = $nuevoUsuario;

            // Guardar el arreglo de usuarios en el archivo JSON
            file_put_contents("usuarios.json", json_encode($usuarios));
        }


        // Verificar si existe el archivo de usuarios
        if (file_exists("usuarios.json")) {
            // Leer el archivo JSON de usuarios
            $usuarios = json_decode(file_get_contents("usuarios.json"), true);

            // Verificar si hay usuarios registrados
            if (!empty($usuarios)) {
                // Variables
                $totalMujeres = 0;
                $totalHombresCasados = 0;
                $totalMujeresViudas = 0;
                $totalEdadHombres = 0;
                $cantidadHombres = 0;



                // Recorrer el arreglo de usuarios y mostrar los datos
                echo "<table id='tableselect' class='table table-dark'>";
                echo "<thead>";
                echo "<tr>";
                echo "<td scope='col'>Nombre</td>";
                echo "<td scope='col'>Apellido</td>";
                echo "<td scope='col'>Edad</td>";
                echo "<td scope='col'>Estado Civil</td>";
                echo "<td scope='col'>Sexo</td>";
                echo "<td scope='col'>Sueldo</td>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($usuarios as $usuario) {

                    if ($usuario["sexo"] === "Femenino") {
                        $totalMujeres++;

                        if ($usuario["sueldo"] > 1000 && $usuario["estado_civil"] === "Viudo(a)") {
                            $totalMujeresViudas++;
                        }
                    } elseif ($usuario["sexo"] === "Masculino") {
                        $cantidadHombres++;
                        $totalEdadHombres += $usuario["edad"];

                        if ($usuario["estado_civil"] === "Casado(a)" && $usuario["sueldo"] > 2500) {
                            $totalHombresCasados++;
                        }
                    }

                    echo "<tr>";
                    echo "<td>" . $usuario["nombre"] . "</td>";
                    echo "<td>" . $usuario["apellido"] . "</td>";
                    echo "<td>" . $usuario["edad"] . "</td>";
                    echo "<td>" . $usuario["estado_civil"] . "</td>";
                    echo "<td>" . $usuario["sexo"] . "</td>";
                    echo "<td>" . $usuario["sueldo"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

                // Calcular promedio de edad de hombres
                $promedioEdadHombres = $totalEdadHombres / $cantidadHombres;

                // Mostrar resultados
                echo "<h3>Resultados</h3>";
                echo "<div class='alert alert-dark' role='alert'>Total de mujeres registradas: $totalMujeres</div>";
                echo "<div class='alert alert-dark' role='alert'>Total de mujeres viudas con sueldo mayor a 1000Bs.: $totalMujeresViudas</div>";
                echo "<div class='alert alert-dark' role='alert'>Promedio de edad de hombres: $promedioEdadHombres</div>";
                echo "<div class='alert alert-dark' role='alert'>Total de hombres casados con sueldo mayor a 2500Bs.: $totalHombresCasados</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>No hay usuarios registrados.</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>No existe el archivo de usuarios.</div>";
        }
        ?>
        <a href="./index.html"><button type="button" value="Registrar">Regresar</button></a>
        </form>
    </div>

</body>

</html>