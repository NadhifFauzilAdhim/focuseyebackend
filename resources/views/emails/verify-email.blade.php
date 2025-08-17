<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f0ff;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 30px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .header {
      background: linear-gradient(135deg, #8a2be2, #9370db);
      color: white;
      padding: 20px;
      text-align: center;
    }
    .content {
      padding: 25px;
      color: #333;
    }
    .btn {
      display: inline-block;
      background: #8a2be2;
      color: white !important;
      text-decoration: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-weight: bold;
      margin: 20px 0;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #888;
      padding: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Verifikasi Email FocusEye Anda</h2>
    </div>
    <div class="content">
      <p>Halo <b>{{ $user->name }}</b>,</p>
      <p>Terima kasih telah bergabung dengan <b>FocusEye</b> 🎉</p>
      <p>Klik tombol di bawah untuk memverifikasi email Anda:</p>

      <p style="text-align: center;">
        <a href="{{ $url }}" class="btn">Verifikasi Email</a>
      </p>

      <p>Jika tombol tidak berfungsi, salin link berikut:</p>
      <a href="{{ $url }}" style="word-break: break-all;">{{ $url }}</a>
    </div>
    <div class="footer">
      © 2025 FocusEye | NDFProject
    </div>
  </div>
</body>
</html>
