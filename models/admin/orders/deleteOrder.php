<?php

    if($_SERVER['REQUEST_METHOD'] != "POST"){
        echo "You don't have permission to access this page";
    }   

    if(isset($_POST['id'])){

        $id = intval($_POST['id']);
        
        include("../../../config/connection.php");
        header("Content-type:application/json");

        $code=404;
        $data=null;

        $query = "DELETE FROM orders WHERE id_o = :id_o";
        $stmt = $konekcija->prepare($query);
        $stmt->bindParam(':id_o', $id);

        try{
            $code = $stmt->execute() ? 201 : 500;
            $data = 'success';
        }
        catch(PDOException $e){
            $code = 500;
            $data = $e;
        }

        http_response_code($code);
        echo json_encode($data);
    }
?>