<?php
    require_once ('./dbconfig.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>나눔</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./css/deal_style.css">
    <style>
    </style>
</head>
<body>
<div class="container">
    <hr>
    <h3>나눔</h3>
    <hr>
        <p>
            <button class="btn btn-default pull-right" onclick = "location.href = './write.php' ">물품 등록</button>
        </p>
        <p>
            물품이 존재 하지 않습니다.
        </p>
    <p style="margin-top: 50px;">
    <button class="btn btn-default pull-right" style="margin-left: 10px;" onclick = "location.href = './mypage.html' ">뒤로</button>
    </p>
</div>
</body>
</html>ee