<?php
$target_dir = "Documentos/"; // Carpeta donde se guardarán los documentos
// Manejar la subida de archivos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documento'])) {
    $target_file = $target_dir . basename($_FILES['documento']['name']);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }
    // Verificar el tamaño del archivo
    if ($_FILES['documento']['size'] > 5000000) { // 5MB
        echo "Lo siento, el archivo es demasiado grande.";
        $uploadOk = 0;
    }
     // Permitir ciertos formatos de archivo
    if (!in_array($fileType, ['pdf', 'doc', 'docx', 'ppt', 'pptx'])) {
        echo "Lo siento, solo se permiten archivos PDF, DOC, DOCX, PPT y PPTX.";
        $uploadOk = 0;
    }
    // Verificar si $uploadOk es 0 por un error
    if ($uploadOk == 0) {
        echo "Lo siento, su archivo no fue subido.";
    } else {
        // Intentar subir el archivo
        if (move_uploaded_file($_FILES['documento']['tmp_name'], $target_file)) {
            echo "El archivo ". htmlspecialchars(basename($_FILES['documento']['name'])). " ha sido subido.";
        } else {
            echo "Lo siento, hubo un error al subir su archivo.";
        }
    }
}
// Manejar la descarga de archivos
if (isset($_GET['file'])) {
    $file = $target_dir . basename($_GET['file']);
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "El archivo no existe.";
    }
}
?>