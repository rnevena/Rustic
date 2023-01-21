<?php

if(isset($_POST['filter'])) {

    include("../config/connection.php");
    header("Content-Type:application/json");

    $idKat = $_POST['idKat'];

    $code=404; $err=0;

    if($idKat==0) {
        $err=1;
    }
    
    if($err==1) {
        $code=409;
    }
    else {
        $query="SELECT * FROM product WHERE id_p IN (SELECT id_p FROM prod_cat WHERE id_c IN (SELECT id_c FROM category WHERE id_c=:id))";
        $stmt=$konekcija->prepare($query);
        $stmt->bindParam(":id", $idKat);
        try {
            $code = $stmt->execute() ? 201 : 500;
            $dohvati=$stmt->fetchAll();
        }
        catch(PDOException $e) {
            $code=500;
        }
    }
    http_response_code($code);
    echo json_encode($dohvati);

}

?>