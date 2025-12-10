<?php
require_once "main.php";

// Endpoint para marcar un horario como eliminado (no borra la fila)
// Recibe: ?id=NN o POST id
$id = null;
if(isset($_POST['id'])) $id = intval($_POST['id']);
elseif(isset($_GET['id'])) $id = intval($_GET['id']);

if(!$id){
    echo json_encode(["success"=>false, "message"=>"ID de horario no proporcionado"]);
    exit;
}

try{
    $db = conexion();
    $stmt = $db->prepare("SELECT id FROM horario WHERE id = :id LIMIT 1");
    $stmt->execute([":id" => $id]);
    if($stmt->rowCount() != 1){
        echo json_encode(["success"=>false, "message"=>"Horario no encontrado"]);
        exit;
    }

    $u = $db->prepare("UPDATE horario SET status = 'eliminado' WHERE id = :id");
    $u->execute([":id" => $id]);

    if($u->rowCount() == 1){
        echo json_encode(["success"=>true, "message"=>"Horario marcado como eliminado"]);
    }else{
        echo json_encode(["success"=>false, "message"=>"No se actualizó el horario"]);
    }
    $db = null;
}catch(PDOException $e){
    echo json_encode(["success"=>false, "message"=>"Error DB: " . $e->getMessage()]);
}

?>
