<?php
    include("../../config/connection.php");
    $stmt = $konekcija->prepare("SELECT * FROM `footer` WHERE href NOT LIKE 'sitemap.xml' AND href NOT LIKE 'dokumentacija.pdf'");
    $stmt2 = $konekcija->prepare("SELECT * FROM `footer` WHERE href LIKE 'sitemap.xml' OR href LIKE 'dokumentacija.pdf'");
    $rezultat = $stmt->execute();
    $rezultat2 = $stmt2->execute();
    $ispis = "";
    foreach($stmt as $s){
        $ispis .= "<a href='$s->href'><i class='$s->class'></i></a> ";
    }
    foreach($stmt2 as $s2){
        $ispis .= "<a href='../../$s2->href'><i class='$s2->class'></i></a> ";
    }
    echo $ispis;
    // dva različita upita zato što običan upit "SELECT * FROM `footer`" ispred svega što nisu linkovi ka mrežama doda putanju views/pages/ a to ne vodi nigde
?>