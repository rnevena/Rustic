<?php

    include("../../config/connection.php");
    header('Content-Type:application/json');

    $query = "SELECT * FROM product p INNER JOIN img i ON p.id_p=i.id_p";  
    $stmt = $konekcija->prepare($query);
    $rezultat = $stmt->execute();
    $dohvati = $stmt->fetchAll(PDO::FETCH_OBJ);

    $status=200;
    echo json_encode($dohvati);

?>