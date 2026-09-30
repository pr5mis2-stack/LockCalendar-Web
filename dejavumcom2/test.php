<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * [관리자용 업체 리스트]
 * "업체코드" => "업체명(주석용)"
 */
$clientList = array(
    "7171"    => "드마리스 부천점",
    "1100"    => "더블유파티",
    "1900"    => "더클래식 춘천점",
    "6700"    => "더파티하우스인판교",
    "0500"    => "파티올 청주점",
    "8233"    => "페리스타 구로점",
    "4456"    => "더파티원 스퀘어원점",
    "5252"    => "리움하우스",
    "6585300" => "아이스타",
    "1141"    => "파티하우스더엘",
    "1910"    => "더클래식N",
    "4603"    => "라띠움 세종점",
    "3391"    => "퍼스트클래스 문정점",
    "4604"    => "라띠움 송도점",
    "3243"    => "더블유페스타 서초점",
    "a4005"   => "엔젤스데이",
    "6668"    => "오월뷔페",
    "5558"    => "시엠프레 청주점",
    "6600"    => "퍼스트클래스 강서점",
    "1953"    => "더블유페스타 일산점",
    "7546114" => "플로렌스 가천대역점",
    "4106114" => "플로렌스 안산점",
    "8522114" => "플로렌스 의정부점",
    "7949114" => "플로렌스 하남점",
    "3338"    => "초대파티하우스 원주점",
    "8577900" => "베이비파스텔 경기북부점",
    "9534"    => "초대파티하우스 강릉점",
    "6745"    => "더파티하우스 디테라스점"
);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dejavu_id'])) {
    $inputId = trim($_POST['dejavu_id']);

    if (array_key_exists($inputId, $clientList)) {
        // 주소창에 업체명 대신 오직 '업체코드(숫자)'만 표시되도록 이동
        $redirectUrl = "https://dejavuweb.duckdns.org/" . $inputId . "/";
        header("Location: " . $redirectUrl);
        exit;
    } else {
        echo "<script>alert('일치하는 업체코드가 없습니다.'); history.back();</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dejavu 시안 확인</title>
    <style>
        :root { color-scheme: light !important; }
        body { font-family: 'Malgun Gothic', sans-serif; background: #f0f2f5 !important; display: flex; justify-content: center; padding-top: 100px; margin: 0; color: #333 !important; }
        .card { background: white !important; padding: 40px 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); width: 100%; max-width: 360px; text-align: center; }
        h2 { color: #222; margin-bottom: 25px; font-size: 22px; }
        input { width: 100%; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 16px; text-align: center; }
        button { width: 100%; padding: 15px; background: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 17px; font-weight: bold; }
        .info { font-size: 13px; color: #888; margin-top: 20px; line-height: 1.6; }
    </style>
</head>
<body>
<div class="card">
    <h2>시안 확인 로그인</h2>
    <form method="post" action="test.php">
        <input type="text" name="dejavu_id" placeholder="업체코드를 입력하세요" required autofocus autocomplete="off">
        <button type="submit">확인</button>
    </form>
    <div class="info">♣ 업체코드를 입력하시면 해당 시안으로 연결됩니다.</div>
</div>
</body>
</html>