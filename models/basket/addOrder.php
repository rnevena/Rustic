<?php
    session_start();
    include("../../config/connection.php");
    header("Content-type:application/json");
    $code=404;
    $data=null;
  
  if(isset($_POST['send'])){
      
    if(isset($_SESSION['user'])){
        $id=$_SESSION['user']->id_u;
      }
    $total = $_POST['total'];

    if($total>0) {
        $query1 = "INSERT INTO orders(`id_u`,`total`) VALUES ($id, $total)";

    try {
        $konekcija->beginTransaction();
        $konekcija->exec($query1);
        $id_o = $konekcija->lastInsertId();
        $konekcija->commit();
        $code=202;
    }
    catch(PDOException $e) {
        $konekcija->rollback();
        $code=500;
        echo $e->getMessage();
    }
    }
}
http_response_code($code);
echo json_encode($data);
?>