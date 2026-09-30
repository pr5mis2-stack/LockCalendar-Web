<?php
/**
 * Dejavu Web Design - Client Draft Access System
 * Version: 20260410_Final_Direct
 */

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8');

// 1. 업체 리스트 (기존과 동일)
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
    "6777"    => "더파티하우스 디테라스"
);

// 2. 로그인 처리
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dejavu_id'])) {
    $inputId = trim($_POST['dejavu_id']);
    
    if (array_key_exists($inputId, $clientList)) {
        // [수정포인트] 강제로 https:// 로 보내고 포트 없이 깔끔하게 연결
       $targetUrl = "https://www.dejavu-view.com/" . $inputId . "/?v=202608013";
       //$targetUrl = "https://dejavuweb.duckdns.org/" . $inputId . "/?v=202608012";
        
        // 브라우저 캐시 때문에 꼬이는 걸 방지하기 위해 자바스크립트로 이동
        echo "<script>location.replace('$targetUrl');</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dejavu 시안 확인</title>
    <style>
        :root { color-scheme: light !important; }
        body { font-family: 'Malgun Gothic', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: flex-start; padding-top: 60px; margin: 0; }
        .card { background: white; padding: 35px 25px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); width: 100%; max-width: 360px; box-sizing: border-box; text-align: center; }
        .notice-container { background: #f8faff; border-radius: 14px; padding: 18px; margin-bottom: 25px; border-left: 4px solid #007bff; text-align: left; }
        .notice-header { font-weight: bold; font-size: 15px; color: #007bff; margin-bottom: 8px; }
        .notice-body { font-size: 13px; color: #555; line-height: 1.6; margin: 0; }
        h2 { color: #222; margin: 0 0 25px 0; font-size: 22px; letter-spacing: -1px; }
        input { width: 100%; padding: 16px; margin-bottom: 15px; border: 2px solid #eee; border-radius: 12px; box-sizing: border-box; font-size: 17px; text-align: center; }
        button { width: 100%; padding: 16px; background: #007bff; color: white; border: none; border-radius: 12px; cursor: pointer; font-size: 17px; font-weight: bold; }
        .footer-info { font-size: 14px; color: #777; margin-top: 25px; line-height: 1.5; word-break: keep-all; }
    </style>
</head>
<body>
<div class="card">
    <div class="notice-container">
        <div class="notice-header">📢 업무 및 상담 안내</div>
        <p class="notice-body">
            <b>업무시간:</b> 월~목요일 10:00 ~ 17:30<br>
            <b>휴무안내:</b> 금·토·일 및 공휴일 휴무
        </p>
    </div>
    <h2>시안 확인 로그인</h2>
    <form method="post">
        <input type="text" name="dejavu_id" placeholder="업체코드를 입력하세요" required autofocus>
        <button type="submit">확인</button>
    </form>
    <div class="footer-info">♣ 업체코드를 입력하시면<br>해당 시안으로 연결됩니다.</div>
</div>
</body>
</html>