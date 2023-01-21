<?php 
    $title = "contact | rustic";
    $cssfile = "../../assets/css/style.css";
    include("../fixed/header.php");
    include("../fixed/nav.php");

    if(isset($_SESSION['user'])) {
        $URL="home.php";
        echo "<script>location.href='$URL'</script>";
    }  
?>
    <div class=container>
        <div id="contact">        
        </div>
    </div>
    <button id="scrollbtn" title="Go to top"><i class="fas fa-angle-up"></i></button>
<?php 
    $jsfile="../../assets/js/contact.js";
    include("../fixed/footer.php");
?>