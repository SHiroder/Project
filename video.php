<?php
// เปิดใช้งานการรับคำขอ Cross-Origin Resource Sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// ตรวจสอบว่ามีค่าพารามิเตอร์ 'videoId' ที่ถูกส่งมาหรือไม่
if (isset($_GET['videoId'])) {
    $videoId = $_GET['videoId'];

    // ตรวจสอบว่าไฟล์วิดีโอสำหรับ videoId ที่กำหนดมีอยู่หรือไม่
    $videoPath = "http://10.232.4.111:8080/project/video/" . $videoId . ".mp4";
    if (file_exists($videoPath)) {
        // ตั้งค่าส่วนหัวของระเบียนตอบกลับเป็นวิดีโอ
        header("Content-Type: video/mp4");
        header("Content-Length: " . filesize($videoPath));

        // อ่านและส่งข้อมูลวิดีโอไปยังไคลเอ็นต์
        readfile($videoPath);
        exit;
    }
}

// หากไม่มีการระบุ videoId หรือไม่พบไฟล์วิดีโอที่กำหนด
// ส่งรหัส HTTP 404 Not Found กลับไปยังไคลเอ็นต์
http_response_code(404);
