<?php
    require_once("./dbconfig.php");

    /* 페이징 시작 */
    //페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    /* 검색 시작 */

    if(isset($_GET['searchColumn'])) {
        $searchColumn = $_GET['searchColumn'];
        $subString .= '&amp;searchColumn=' . $searchColumn;
    }
    if(isset($_GET['searchText'])) {
        $searchText = $_GET['searchText'];
        $subString .= '&amp;searchText=' . $searchText;
    }

    if(isset($searchColumn) && isset($searchText)) {
        $searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
    } else {
        $searchSql = '';
    }
    /* 검색 끝 */

    $sql = 'select count(*) as cnt from market' . $searchSql;
    $result = $db->query($sql);
    $row = $result->fetch_assoc($result);

    $allPost = $row['cnt']; //전체 게시글의 수

    if(empty($allPost)) {
        $emptyData = '<tr><td class="textCenter" colspan="5">글이 존재하지 않습니다.</td></tr>';
    } else {

    $onePage = 15; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수

    if($page < 1 && $page > $allPage) {
        ?>
        <script>
            alert("존재하지 않는 페이지입니다.");
            history.back();
        </script>
        <?php
        exit;
    }

    $oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
    $currentSection = ceil($page / $oneSection); //현재 섹션
    $allSection = ceil($allPage / $oneSection); //전체 섹션의 수

    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

    if($currentSection == $allSection) {
        $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
    }

    $prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

    $paging = '<ul class="pagination">'; // 페이징을 저장할 변수

    //첫 페이지가 아니라면 처음 버튼을 생성
    if($page != 1) {
        $paging .= '<li><a href="./index.php?page=1' . $subString . '">처음</a></li>';
    }
    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) {
        $paging .= '<li><a href="./index.php?page=' . $prevPage . $subString . '">이전</a></li>';
    }

    for($i = $firstPage; $i <= $lastPage; $i++) {
        if($i == $page) {
            $paging .= '<li><a href="#">' . $i . '</a></li>';
        } else {
            $paging .= '<li><a href="./index.php?page=' . $i . $subString . '">' . $i . '</a></li>';
        }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) {
        $paging .= '<li><a href="./index.php?page=' . $nextPage . $subString . '">다음</a></li>';
    }

    //마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage) {
        $paging .= '<li><a href="./index.php?page=' . $allPage . $subString . '">끝</a></li>';
    }
    $paging .= '</ul>';

    /* 페이징 끝 */


    $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

    $sql = 'select * from market' . $searchSql . ' order by m_no desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
    $result = $db->query($sql);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <title>스쿨마켓 - 거래</title>
  <link rel="stylesheet" type="text/css" href="./deal_style.css">
</head>

<body>
<div class="container">
    <hr>
    <h3>자유게시판</h3>
    <hr>
    <table class="table table-hover">
        <caption>자유게시판</caption>
        <thead>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>작성일</th>
            <th>조회수</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($emptyData)) {
            echo $emptyData;
        } else {
            while($row = $result->fetch_assoc())
            {
                $datetime = explode(' ', $row['b_date']);
                $date = $datetime[0];
                $time = $datetime[1];
                if($date == Date('Y-m-d'))
                    $row['b_date'] = $time;
                else
                    $row['b_date'] = $date;
                ?>
                <tr>
                    <td><?php echo $row['b_no']?></td>
                    <td>
                        <a href="./view.php?bno=<?php echo $row['b_no']?>"><?php echo $row['b_title']?></a>
                    </td>
                    <td><?php echo $row['b_id']?></td>
                    <td><?php echo $row['b_date']?></td>
                    <td><?php echo $row['b_hit']?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <a href="./write.php" class="btn btn-default pull-right">글쓰기</a>
    <div class="text-center">
        <ul>
            <?php echo $paging ?>
        </ul>
    </div>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
  <div id="wrapper">
    <div id="grid">
        <a href="./write.php" class="util">물품등록</a>
        <input class="util" type="submit" value="검색">
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

        <!--
      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">1500원</span>
                <span class="product_name">헬로키티 펜</span>
                <p>학용품</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>아주 귀여운 헬로키티가 그려져 있는 펜</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!--
      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">50000원</span>
                <span class="product_name">노스페이스 패딩</span>
                <p>의류</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>한 때는 잘나갔던 패딩</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">500원</span>
                <span class="product_name">모나미 볼펜 검정색</span>
                <p>학용품</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>제일 많이 쓰는 심플한 펜</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">1000원</span>
                <span class="product_name">형광펜</span>
                <p>학용품</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>밑줄 칠 때 베스트</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">1500원</span>
                <span class="product_name">헬로키티 펜</span>
                <p>학용품</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>아주 귀여운 헬로키티가 그려져 있는 펜</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">50000원</span>
                <span class="product_name">노스페이스 패딩</span>
                <p>의류</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>한 때는 잘나갔던 패딩</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="product">
        <div class="make3D">
          <div class="product-front">
            <div class="shadow"></div>
            <img src="http://localhost/img/bitnami.png" alt="" />
            <div class="image_overlay"></div>
            <form action="test.html" method="post">
              <input class="view_gallery" type="submit" name="" value="자세히 보기">
            </form>
            <div class="stats">
              <div class="stats-container">
                <span class="product_price">500원</span>
                <span class="product_name">모나미 볼펜 검정색</span>
                <p>학용품</p>
                <div class="product-options">
                  <strong>Description</strong>
                  <span>제일 많이 쓰는 심플한 펜</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  -->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="./script.js"></script>
</body>

</html>
