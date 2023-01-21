<?php 
    $title = "shop | rustic";
    $cssfile = "../../assets/css/shop.css";
    include("../fixed/header.php");
    include("../fixed/nav.php");

    $param="";
    $catId="";
    $matId="";
    $price="";

    if(isset($_GET['ddlPrice'])) {
        $price=$_GET['ddlPrice'];
        $param.="&ddlPrice=$price";
    }

    if(isset($_GET['ddlCat'])) {
        $catId=$_GET['ddlCat'];
        $param.="&ddlCat=$catId";
    }
    
    if(isset($_GET['ddlMat'])) {
        $matId=$_GET['ddlMat'];
        $param.="&ddlMat=$matId";
    }

    $query_cat = "SELECT * FROM category";
    $stmt_cat = $konekcija->prepare($query_cat);
    $result_cat = $stmt_cat->execute();
    $get_cat = $stmt_cat->fetchAll(PDO::FETCH_OBJ);

    $cat=!empty($catId) ? "INNER JOIN prod_cat pc ON p.id_p=pc.id_p WHERE pc.id_c=$catId AND" : "WHERE";
    
    $query_mat = "SELECT * FROM material";
    $stmt_mat = $konekcija->prepare($query_mat);
    $result_mat = $stmt_mat->execute();
    $get_mat = $stmt_mat->fetchAll(PDO::FETCH_OBJ);

    $mat=!empty($matId) ? "INNER JOIN prod_mat pm ON p.id_p=pm.id_p WHERE pm.id_m=$matId AND" : "WHERE";

    $page=0;
    if(isset($_GET['n']) && $_GET['n']!=""){
        $page = ($_GET['n']-1)*6;
    }

    $query_all_products_filtered = "SELECT * FROM product p INNER JOIN img i ON p.id_p=i.id_p" . ($catId? " INNER JOIN prod_cat pc ON p.id_p=pc.id_p" : " "). ($matId? " INNER JOIN prod_mat pm ON p.id_p=pm.id_p" : " ") . " WHERE " . ($catId ? "pc.id_c = $catId" : " 1 ") . " AND " . ($matId ? "pm.id_m = $matId" : " 1 ") . " GROUP BY p.id_p " . ($price? "ORDER BY price $price" : "ORDER BY p.id_p");
    $stmt_all_products_filtered = $konekcija->prepare($query_all_products_filtered);
    $result_all_products_filtered = $stmt_all_products_filtered->execute();
    $filtered_product_count = $stmt_all_products_filtered->rowCount();

    $query_products_per_page = "SELECT * FROM product p INNER JOIN img i ON i.id_p=p.id_p" . ($catId? " INNER JOIN prod_cat pc ON p.id_p=pc.id_p" : " "). ($matId? " INNER JOIN prod_mat pm ON p.id_p=pm.id_p" : " ") . " WHERE " . ($catId ? "pc.id_c = $catId" : " 1 ") . " AND " . ($matId ? "pm.id_m = $matId" : " 1 ") . " GROUP BY p.id_p " . ($price? "ORDER BY price $price" : "ORDER BY p.id_p") . " LIMIT $page,6";
    $stmt_products_per_page = $konekcija->prepare($query_products_per_page);
    $result_products_per_page = $stmt_products_per_page->execute();
    $get_products_per_page = $stmt_products_per_page->fetchAll(PDO::FETCH_OBJ);
    $pagecount = ceil($filtered_product_count/6);
?>
    <div class=container>
        <div id="divshop">
        <h1>Shop our latest arrivals</h1>
        <div id="filtershop">
            <form id="filter-form" method="GET" action="">
            <button id="btnBasket"><a href="basket.php" id="basketlink"><i class="fas fa-shopping-cart"></i>&nbsp;cart</a></button>
            <select id="ddlPrice" name="ddlPrice">
                <option value="0" selected>price</option>
                <option value="ASC">ascending</option>
                <option value="DESC">descending</option>
            </select>
            <select id="ddlCat" name="ddlCat">
                <option selected value="0">category</option>
                <?php foreach($get_cat as $c):?>
                    <option value="<?= $c->id_c ?>" <?=$catId==$c->id_c?"selected":""?>><?= $c->name ?></option>
                <?php endforeach?>
            </select>
            <select id="ddlMat" name="ddlMat">
                <option value="0">material</option>
                <?php foreach($get_mat as $m):?>
                    <option value="<?= $m->id_m ?>"><?= $m->name ?></option>
                <?php endforeach?>
            </select>
            <button type="submit" class="btnFilter" name="btnFilter">apply</button>
            </form>
        </div>
        <div id="containershop">
        <?php foreach($get_products_per_page as $s): ?>
            <div class="product">
                <div class="pictureBlock">
                    <div class="picture">
                    <a href="product.php?product_id=<?=$s->id_p;?>">
                   <img src="../../assets/<?=$s->src;?>" alt="<?=$s->alt;?>"/>
                    </a>
                    </div>
                </div>
                <div class="descriptionBlock">
                    <h1><?=$s->name;?></h1>
                    <p>&euro;<?=$s->price;?></p>
                    <button class="addtobasket" value="<?=$s->id_p;?>" data-id="<?=$s->id_p;?>">Add to cart</button>
                </div>
            </div>
        <?php endforeach;?>
        
        </div>
        <div id="stranicenje_shop">
                <?php for($i=1; $i<=$pagecount; $i++):?>
                    <a class="pagelink" href="<?php echo 'shop.php?n='.$i.$param;?>"><?=$i?></a>
                <?php endfor?>
            </div>
        </div>
    </div>
    <button id="scrollbtn" title="Go to top"><i class="fas fa-angle-up"></i></button>
<?php 
    $jsfile="../../assets/js/main.js";
    include("../fixed/footer.php");
?>