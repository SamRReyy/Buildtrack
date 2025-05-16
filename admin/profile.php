<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile Card</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(135deg, #f64f59, #c471ed);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 360px;
      padding: 20px;
      text-align: center;
      position: relative;
    }
    .profile-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 5px solid white;
      position: absolute;
      top: -50px;
      left: 50%;
      transform: translateX(-50%);
      box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    .card h2 {
      margin-top: 60px;
      font-size: 22px;
    }
    .card p.location {
      color: gray;
      font-size: 14px;
      margin: 5px 0 15px;
    }
    .card p.role {
      font-size: 14px;
      color: #666;
      margin: 5px 0;
    }
    .stats {
      display: flex;
      justify-content: space-around;
      margin: 20px 0;
    }
    .stats div {
      text-align: center;
    }
    .stats div span {
      display: block;
      font-weight: bold;
      font-size: 18px;
    }
    .btn {
      background: linear-gradient(135deg, #f64f59, #c471ed);
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 25px;
      font-size: 14px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: background 0.3s;
    }
    .top-actions {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
      color: #f64f59;
    }
    .top-actions span {
      cursor: pointer;
      display: flex;
      align-items: center;
    }
  </style>
</head>
<body>

  <div class="card">
    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Profile" class="profile-img">
    <div class="top-actions">
      <span>👥 Connect</span>
      <span>💬 Message</span>
    </div>
    <h2>Samantha Jones</h2>
    <p class="location">New York, United States</p>
    <p class="role">Web Producer - Web Specialist<br>Columbia University - New York</p>
    <div class="stats">
      <div><span>65</span>Friends</div>
      <div><span>43</span>Photos</div>
      <div><span>21</span>Comments</div>
    </div>
    <button class="btn">Show more</button>
  </div>

</body>
</html>
