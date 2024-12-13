<?php
session_start();
include 'koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$userId = $_SESSION['user_id'];

$query = "SELECT * FROM pabrik";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PandawaraHub - Beli Produk</title>
    <link rel="stylesheet" href="../css/buy.css">
    <link rel="stylesheet" href="../css/review.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
.profile-container {
  position: relative;
}

.profile-dropdown {
  position: absolute;
  top: 90%; 
  right: 0px; 
  background-color: #253B6E;
  padding: 10px 0;
  border-radius: 5px;
  min-width: 150px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 10;
  display: none;
}

.menu-item {
  position: relative; 
}

.dropdown {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #253B6E;
  padding: 10px 0;
  border-radius: 5px;
  min-width: 150px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 10;
}

.dropdown, .profile-dropdown {
  display: none; 
  position: absolute;
  top: 100%;
  background-color: #253B6E;
  padding: 10px 0;
  border-radius: 5px;
  min-width: 150px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 10;
}

.dropdown li, .profile-dropdown li {
  list-style: none;
}

.dropdown li a, .profile-dropdown li a {
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  display: block;
  font-size: 16px;
  transition: background-color 0.3s;
}

.dropdown li a:hover, .profile-dropdown li a:hover {
  background-color: #5a5a5a;
}

.show {
  display: block;
}

.Icon {
  display: flex;
  align-items: center; 
  gap: 0px; 
}

.bell-icon,
.profile-icon {
  width: 25px;
  height: 25px;
  cursor: pointer;
}


.profile-dropdown li {
  list-style: none;
  text-align: center; 
}

.profile-dropdown li span,
.profile-dropdown li a {
  display: block;
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  font-size: 16px;
  transition: background-color 0.3s;
}

.profile-dropdown li a:hover {
  background-color: #5a5a5a;
}

button.show-comments {
    background-color: #253B6E; 
    color: white; 
    padding: 10px 20px; 
    border: none; 
    border-radius: 5px; 
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

button.show-comments:hover {
    background-color: #405d9b; 
}

.articles {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
    gap: 0px;
    margin: 0px;
}

.article-card {
  width: 300px;
    height: 600px;
    background-color: white;
    border-radius: 15px;
    box-shadow: 0px 16px 28px rgba(0, 0, 0, 4);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.article-card:hover {
    transform: translateY(-10px); 
    box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.4); 
}

.article-card button.tombol:hover {
    background-color: #1F5F8B; 
    transform: scale(1.05); 
}

.article-card button.tombol.registered {
    background-color: #cccccc; 
    cursor: not-allowed; 
}

.article-card img {
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
    border-bottom: 2px solid #ddd;
}

.tulisannya {
    padding: 15px;
    flex: 1; 
}

.tulisannya h1 {
    font-size: 1.25rem;
    margin: 10px 0;
}

.tulisannya h3 {
    font-size: 1rem;
    color: #555;
    margin-bottom: 15px;
}

.lokasi {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px;
    background-color: #f8f8f8;
    width: 100%;
    border-top: 1px solid #ddd;
}

.lokasi img {
    width: 30px; 
    height: 30px; 
    margin-bottom: 5px; 
}

.lokasi span {
    font-size: 1rem;
    color: #333;
}

.review .stars {
    margin-top: 10px;
    font-size: 1.25rem;
}

.review .stars span {
    cursor: pointer;
    color: #f1c40f; 
}

button.show-comments {
    background-color: #253B6E;
    color: white; 
    padding: 9px 19px; 
    border: none; 
    border-radius: 5px; 
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

button.show-comments:hover {
    background-color: #405d9b; 
}

.review .stars {
    display: flex; 
    justify-content: center; 
    align-items: center; 
    margin-top: 10px;
    font-size: 1.25rem;
    gap: 5px; 
}

.review .stars span {
    cursor: pointer;
    color: #f1c40f; 
}

.bell-icon, .profile-icon {
  transition: transform 0.3s; 
}

.bell-icon:hover, .profile-icon:hover {
  transform: rotate(10deg) scale(1.1); 
}   


  </style>
</head>
<body>

  <header class="header">
    <div class="logo-container">
        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/4738a78adc5bc986a5461aca0c1c13605d88c36fe58a8a534122ed4d303b3300" alt="Logo" class="logo">
        <span class="logo-text">PANDAWARAHUB</span>
    </div>
    
    <nav class="nav">
        <a href="../php/homepage.php">Home</a>
        <a href="../php/daftarkegiatan.php">Event</a>
        <a href="/donation">Donation</a>

        <div class="menu-item">
            <a href="#" onclick="toggleDropdown(event, 'ecoDropdown')">Eco-Market</a>
            <ul id="ecoDropdown" class="dropdown">
                <li><a href="../html/sell.html">Jual</a></li>
                <li><a href="#">Beli</a></li>
            </ul>
        </div>

        <div class="menu-item">
            <a href="#" onclick="toggleDropdown(event, 'reportDropdown')">Report</a>
            <ul id="reportDropdown" class="dropdown">
                <li><a href="/report/event">Event</a></li>
                <li><a href="/report/donasi">Donasi</a></li>
                <li><a href="/report/dampak">Dampak</a></li>
            </ul>
        </div>
        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/607d8cac62200f80fdfc7872e2de376266c5a8b1f93e34d08255a25bd3c0a838" alt="Report Icon" class="report-icon">
    </nav>
    
    <nav class="Icon">
        <img src="../image/bell.png" alt="Bell Icon" class="bell-icon">
        <div class="profile-container">
            <img src="../image/profile.png" alt="Profile Icon" class="profile-icon" onclick="toggleDropdown(event, 'profileDropdown')">
            <ul id="profileDropdown" class="profile-dropdown">
                <li><span><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></span></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>

  <section class="articles">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="article-card">
        <img src="../uploads/<?php echo htmlspecialchars($row['image_url']); ?>" alt="Gambar Pabrik">
        <div class="tulisannya">
            <h1><?php echo htmlspecialchars($row['nama']); ?></h1>
            <h3><?php echo htmlspecialchars($row['deskripsi_pabrik']); ?></h3>

            <div class="review">
                <div class="stars" data-product-id="<?php echo $row['id_pabrik']; ?>">
                    <span data-value="1">☆</span>
                    <span data-value="2">☆</span>
                    <span data-value="3">☆</span>
                    <span data-value="4">☆</span>
                    <span data-value="5">☆</span>
                </div>
            </div>
       
            <form action="komentar.php" method="get">
              <button type="submit" class="show-comments">
                Lihat Komentar
              </button>
             <input type="hidden" name="id_pabrik" value="<?php echo $row['id_pabrik']; ?>">
            </form>

        </div>
        <div class="lokasi">
            <img src="../image/lokasi.png" alt="Lokasi">
            <span><?php echo htmlspecialchars($row['lokasi']); ?></span>
        </div>
    </div>
    <?php endwhile; ?>
</section>

  <script src="../js/review.js"></script>
  <script src="../js/homepage.js"></script>
</body>
</html>
