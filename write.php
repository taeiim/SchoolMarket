<?php
    require_once ('./dbconfig.php');

    //$_GET['mno']이 있을 때만 $mno 선언
    if(isset($_GET['mno'])) {
        $mNo = $_GET['mno'];
    }

    if(isset($mNo)) {
        $sql = 'select m_price, m_title ,m_content from market where m_no = ' . $mNo;
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>게시글 작성</title>
	<link rel="stylesheet" href="write.css">
	<script src="js/jquery-3.2.1.min.js"></script>
</head>
<body>
	<div id="sell">
		<p>물품 판매</p>
		<p id="sta"> Home/ <strong>물품 판매</strong></p>
	</div>
	<hr width="1000rem;">
	<form action="gallery.html" method="post" enctype="multipart/form-data" id="img">
        <INPUT TYPE=hidden name=mode value=insert>
        <label>대표 이미지 등록</label><input type='file' name='image'>
        <input type='submit' value='이미지 전송 '>
    </form>
    <form action="./write_update.php" method="post">
        <?php
        if(isset($mNo)) {
            echo '<input type="hidden" name="mno" value="' . $mNo . '">';
        }
        ?>
	<table>
		<tbody>
			<tr>
				<th>거래 유형</th>
				<td>
					<select>
						<option value="일반 거래">일반 거래</option>
						<option value="나눔">나눔</option>
						<option value="분실물">분실물</option>
						<option value="교환">교환</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>카테고리</th>
				<td>
					<select>
						<option value="의류">의류</option>
						<option value="책">책</option>
						<option value="기타">기타</option>
					</select>
				</td>
			</tr>
			<tr>
                <th><label for="mTitle">제목</label></th>
                <td><input name="mTitle" id="mTitle" type="text" value="<?php echo isset($row['m_title'])?$row['m_title']:null?>"></td>
			</tr>
			<tr>
                <th><label for="mPrice">가격</label></th>
				<td><input type="text" name="mPrice" id="mPrice" placeholder="가격은 숫자로만 입력" value="<?php echo isset($row['m_price'])?$row['m_price']:null?>" class="input" required></td>
			</tr>
			<tr>
				<th><label for="mContent">내용</label></th>
					<td><textarea rows="10" placeholder="내용을 입력하세요." name="mContent" id="mContent" required><?php echo isset($row['m_content'])?$row['m_content']:null?></textarea></td>
				</tr>
		</tbody>
	</table>
        <div>
            <button type="submit" value="물품 등록" id="reg">
                <?php echo isset($mNo)?'수정':'작성'?>
            </button>
            <a href="./index.php">목록</a>
        </div>
	</form>
</body>
</html>