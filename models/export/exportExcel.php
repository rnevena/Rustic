<?php
require "../../config/connection.php";
$output='';
$query="SELECT * FROM product";
$query1="SELECT p.name as name, p.description as descr, c.name as cname, m.name as mname, p.price as price FROM product p INNER JOIN prod_cat pc ON p.id_p=pc.id_p INNER JOIN category c ON pc.id_c=c.id_c INNER JOIN prod_mat pm ON p.id_p=pm.id_p INNER JOIN material m ON pm.id_m=m.id_m";
$stmt = $konekcija->prepare($query);
$rezultat = $stmt->execute();
$products = $stmt->fetchAll();
    $output.="<table border='1px'>
    <tr>
    <td>product name</td>
    <td>description</td>
    <td>price</td>
    <td>categories</td>
    <td>materials</td>
    </tr>";

    foreach($products as $p) {
        $parts = explode(".",$p->price);

        $output.="<tr><td>".$p->name."</td><td>".$p->description."</td><td>".$parts[0].",".$parts[1]."e"."</td><td>"; 
        
        $q2 = "SELECT c.name FROM category c INNER JOIN prod_cat pc ON c.id_c=pc.id_c INNER JOIN product p ON p.id_p=pc.id_p WHERE p.id_p=$p->id_p";
        $stmt2 = $konekcija->prepare($q2);
        $rezultat2 = $stmt2->execute();
        $cat = $stmt2->fetchAll();
        foreach($cat as $c) {
            $output.=$c->name. "<br>";
        }
        $output.="</td><td>";
    
        $q3 = "SELECT m.name FROM material m INNER JOIN prod_mat pm ON m.id_m=pm.id_m INNER JOIN product p ON p.id_p=pm.id_p WHERE p.id_p=$p->id_p";
        $stmt3 = $konekcija->prepare($q3);
        $rezultat3 = $stmt3->execute();
        $mat = $stmt3->fetchAll();
        foreach($mat as $m) {
            $output.=$m->name. "<br>";
        }
        $output.="</td></tr>";
    }   
    $output.="</table>";

header("Content-Type:application/xls");
header("Content-Disposition:attachment;filename=products.xls");
echo $output;
?>