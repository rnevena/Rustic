<?php
    $title = "basket | rustic";
    $cssfile = "../../assets/css/style.css";
    include("../fixed/header.php");
    include("../fixed/nav.php");
    if(isset($_SESSION['user'])){
    echo "<input type=\"hidden\" id=\"user_order\" name=\"user_order\" value=\"" . $_SESSION['user']->id_u ."\">";
    }
?>
<div class=container>
    <div class="basket-wrap">
        <h1 id="hidden-basket"></h1>
    <div class="basket2"><div class="basket">
        <h1 id="basket-msg"></h1>
    </div>
    <div class="basket3">
    <?php
         if(isset($_SESSION['user'])){
            $user=$_SESSION['user'];
            if($user->id_r==1){
                echo "<button type='submit' id='btn-order'>order</button>";
            }
            else if($user->id_r==2) {
                echo "<button type='submit' id='btn-order'>order</button>";
            }
        }
        else{
            echo "<h1 id='basket-msg-2'><a href='register.php'>Log in or register</a> to order.</h1>";
        }
        ?>
        
        <?php
        $jsfile="../../assets/js/basket.js";
        include("../fixed/footer.php");
        ?>
    </div>
    </div>
    </div>
</div>
