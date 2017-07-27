<?php
    require_once ('./dbconfig.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>물품 구매</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./deal_style.css">
    <style>
    </style>
</head>
<body>
<div class="container">
    <hr>
    <h3>물품 구매</h3>
    <hr>
        <p>
            <button class="btn btn-default pull-right" onclick = "location.href = './write.php' ">물품 등록</button>
        </p>
    <div class="product">
        <div class="make3D">
            <div class="product-front">
                <div class="shadow"></div>
                <img src="http://localhost/img/bitnami.png" alt="" />
                <div class="image_overlay"></div>
                <a href="./view.php" class="view_gallery">자세히 보기</a>
                <div class="stats">
                    <div class="stats-container">
                        <span class="product_price"><?php echo $row['m_price'] ?>원</span>
                        <span class="product_name"><?php echo $row['m_title'] ?></span>
                        <p></p>
                        <div class="product-options">
                            <strong>Description</strong>
                            <span>봄가을 가장 인기있는 윗옷</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
