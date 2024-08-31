<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_de_registro = $_POST['fecha_de_registro'];
    $fecha_culminacion = $_POST['fecha_culminacion'];
    $fecha_finalizacion = $_POST['fecha_finalizacion'];
    $responsable = $_POST['responsable'];
    $estado = $_POST['estado'];
    $eliminado = $_POST['eliminado'];

    // Manejo del archivo adjunto
    $adjunto = '';
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $fileInfo = pathinfo($_FILES['adjunto']['name']);
        $fileExt = strtolower($fileInfo['extension']);
        $fileSize = $_FILES['adjunto']['size'];

        if (in_array($fileExt, $allowed)) {
            if (($fileExt == 'pdf' && $fileSize <= 1048576) || ($fileExt != 'pdf' && $fileSize <= 512000)) {
                $adjunto = uniqid() . '-' . date('YmdHis') . '.' . $fileExt;
                move_uploaded_file($_FILES['adjunto']['tmp_name'], 'files/' . $adjunto);
            } else {
                echo "El archivo es demasiado grande.";
                exit();
            }
        } else {
            echo "Tipo de archivo no permitido.";
            exit();
        }
    }

    $sql = "UPDATE tareas SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion', fecha_de_registro='$fecha_de_registro', fecha_culminacion='$fecha_culminacion', fecha_finalizacion='$fecha_finalizacion', responsable='$responsable', estado='$estado' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>