<?php
$hostDB = "localhost";
$userDB = "root";
$pwdDB = "";
$nameDB = "examen_pr2";

$conexDB = new mysqli($hostDB, $userDB, $pwdDB, $nameDB);
if ($conexDB->connect_error) {
    die("Error de conexión: " . $conexDB->connect_error);
}
?>
<?php
include 'conexiones.php';
$sql = "SELECT id, nombre, email, edad FROM personas";
$result = $conexDB->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Personas</title>
</head>
<body>
    <h2>Lista de Personas</h2>
    <table borde='1'>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Condición</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['edad']; ?></td>
                <td><?php echo ($row['edad'] >= 18) ? 'Mayor de edad' : 'Menor de edad'; ?></td>
                <td>
                    <a href='editar.php?id=<?php echo $row['id']; ?>'>Editar</a> |
                    <a href='eliminar.php?id=<?php echo $row['id']; ?>' onclick='return confirm("¿Seguro que deseas eliminar?")'>Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href='crear.php'>Agregar nueva persona</a>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexiones.php';
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $sql = "INSERT INTO personas (nombre, email, edad) VALUES ('$nombre', '$email', '$edad')";
    $conexDB->query($sql);
    header("Location: index.php");
}
?>
<form method='POST'>
    Nombre: <input type='text' name='nombre' required><br>
    Email: <input type='email' name='email' required><br>
    Edad: <input type='number' name='edad' required><br>
    <input type='submit' value='Guardar'>
</form>
<?php
include 'conexiones.php';
$id = $_GET['id'];
$result = $conexDB->query("SELECT * FROM personas WHERE id=$id");
$row = $result->fetch_assoc();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $conexDB->query("UPDATE personas SET nombre='$nombre', email='$email', edad='$edad' WHERE id=$id");
    header("Location: index.php");
}
?>
<form method='POST'>
    Nombre: <input type='text' name='nombre' value='<?php echo $row['nombre']; ?>' required><br>
    Email: <input type='email' name='email' value='<?php echo $row['email']; ?>' required><br>
    Edad: <input type='number' name='edad' value='<?php echo $row['edad']; ?>' required><br>
    <input type='submit' value='Actualizar'>
</form>

<?php
include 'conexiones.php';
$id = $_GET['id'];
$conexDB->query("DELETE FROM personas WHERE id=$id");
header("Location: index.php");
?>

