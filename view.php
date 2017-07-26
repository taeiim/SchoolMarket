<?php
require_once ('dbconfig.php');
$mNo = $_GET['mno'];

if(!empty($mNo) && empty($_COOKIE['market_' . $mNo])) {
    $sql = 'update market set m_hit = m_hit + 1 where m_no = ' . $mNo;
    $result = $db->query($sql);
    if(empty($result)) {
        ?>
        <script>
            alert('오류가 발생했습니다.');
            history.back();
        </script>
        <?php
    } else {
        setcookie('market_' . $mNo, TRUE, time() + (60 * 60 * 24), '/');
    }
}

$sql = 'select m_price, m_title, m_content, m_date, m_hit from market where m_no = ' . $mNo;
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>게시판</title>
    <script src="./js/jquery-3.2.1.min.js"></script>
</head>
<body>
<article class="boardArticle">
    <h3>게시판</h3>
    <div id="boardView">
        <h3 id="boardTitle"><?php echo $row['m_title']?></h3>
        <div id="boardInfo">
            <span id="boardID">작성자: </span>
            <span id="boardDate">작성일: <?php echo $row['m_date']?></span>
            <span id="boardHit">조회: <?php echo $row['m_hit']?></span>
        </div>
        <div id="boardContent"><?php echo $row['m_content']?></div>
        <div class="btnSet">
            <a href="./write.php?bno=<?php echo $mNo?>">수정</a>
            <a href="./delete.php?bno=<?php echo $mNo?>">삭제</a>
            <a href="./">목록</a>
        </div>
        <div id="boardComment">
            <?php require_once('./comment.php')?>
        </div>
    </div>
</article>
</body>
</html>