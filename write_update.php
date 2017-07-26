<?php
    require_once ('./dbconfig.php');

    //$_POST['mno']이 있을 때만 $mno 선언
    if(isset($_POST['mno'])) {
        $mNo = $_POST['mno'];
    }

    //mno이 없다면(글 쓰기라면) 변수 선언
    if(empty($mNo)) {
        $date = date('Y-m-d H:i:s');
    }

    //항상 변수 선언
    $mPrice = $_POST['mPrice'];
    $mTitle = $_POST['mTitle'];
    $mContent = $_POST['mContent'];

//글 수정
if(isset($mNo)) {
    //수정 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
    $sql = 'select count(m_password) as cnt from market where m_password=password("' . $mPassword . '") and m_no = ' . $mNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    //비밀번호가 맞다면 업데이트 쿼리 작성
    if($row['cnt']) {
        $sql = 'update market set m_title="' . $mTitle . '", m_content="' . $mContent . '" where m_no = ' . $mNo;
        $msgState = '수정';
        //틀리다면 메시지 출력 후 이전화면으로
    } else {
        $msg = '비밀번호가 맞지 않습니다.';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
        <?php
        exit;
    }

    //글 등록
    } else {
        $sql = 'insert into market (m_no, m_price, m_title, m_content, m_date, m_hit) values(null, "'.$mPrice.'", "' . $mTitle . '", "' . $mContent . '", "' . $date . '", 0)';
        $msgState = '등록';
    }

    //메시지가 없다면 (오류가 없다면)
    if(empty($msg)) {
        $result = $db->query($sql);

        //쿼리가 정상 실행 됐다면,
        if($result) {
            $msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
            if(empty($mNo)) {
                $mNo = $db->insert_id;
            }
            $replaceURL = './view.php?mno=' . $mNo;
        } else {
            $msg = '글을 ' . $msgState . '하지 못했습니다.';
            ?>
            <script>
                alert("<?php echo $msg?>");
                history.back();
            </script>
            <?php
            exit;
        }
    }

    ?>
    <script>
        alert("<?php echo $msg?>");
        location.replace("<?php echo $replaceURL?>");
    </script>
?>