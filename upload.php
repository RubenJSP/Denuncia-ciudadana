<?php
    require_once 'insertData.php';
    require_once 'userData.php';

 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$message = ''; 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Registrar')
{
    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
    {
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'gif', 'png');
        if (in_array($fileExtension, $allowedfileExtensions)){
            $uploadFileDir = './uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;
            if(move_uploaded_file($fileTmpPath, $dest_path)){
                $message ='OK';
            }
            else{
                $message = 'Error en el directorio.';
            }
        }
        else{
        $message = 'Carga Fallida, Formato de archivo no permitido. Formatos Disponibles: ' . implode(',', $allowedfileExtensions);
        }
    }
    else{
        if($_FILES['uploadedFile']['error']==4){
            $message = 'OK';
        }else{
            $message = 'Ha ocurrido un error subiendo el archivo.';
            $message .= 'Error:' . $_FILES['uploadedFile']['error']; 
        }
        
    }
}else{
    $message = 'Archivo demasiado grande. ';
}
$_SESSION['message'] = $message;
foreach($_POST as $campo => $valor){
    echo "<br />- ". $campo ." = ". $valor;
}

if($message==='OK'){
    $fecha = date("Y-m-d H:i:s");
    $lt=$_POST['lat'];
    $lg=$_POST['long'];
    if(strlen($lt)<1){
        $lt = '24.142582';
        $lg = '-110.312658';
    }

    if(strlen($newFileName)<1){
        $newFileName = "default.png";
    }
    saveReport($lt, $lg,$_POST['option'],$_POST['comentary'],$newFileName,$fecha ,$datos['idUser'],'Pendiente');
    header("Location: mapa.php");
}else{
    header("Location: addreport.php");
}
?>
