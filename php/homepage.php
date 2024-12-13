<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$userId = $_SESSION['user_id'];
$namaLengkap = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : "Guest"; 
?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PandawaraHub</title>
  <link rel="stylesheet" href="../css/homepagestyle.css">
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

nav.Icon {
  display: flex;
  align-items: center; 
  gap: 15px; 
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

.lorem-ipsum-button {
background: linear-gradient(to bottom, #D2ECF9, #456ECE); 
border-radius: 20px; 
padding: 5px 30px; 
border: none; 
cursor: pointer; 
font-family: 'Poppins', sans-serif; 
font-size: 18px; 
color: #253B6E; 

display: inline-block; 
margin-left: 100px;
}

.article-card {
  transition: transform 0.3s, box-shadow 0.3s; 
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
}

.article-card:hover {
  transform: scale(1.05); 
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2); 
}

.lorem-ipsum-button {
  transition: background-color 0.3s, transform 0.2s;
}

.lorem-ipsum-button:hover {
  background: linear-gradient(to bottom, #456ECE, #D2ECF9); 
  transform: scale(1.1);
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); 
}

.bell-icon, .profile-icon {
  transition: transform 0.3s; 
}

.bell-icon:hover, .profile-icon:hover {
  transform: rotate(10deg) scale(1.1); 
}

.feature-card {
  background: linear-gradient(to bottom, #436BC9, #000000);
  border-radius: 20px;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 25%;
  margin: 30px;
  color: #D2ECF9;
  box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
  -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
  font-size: 25px;
  transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
}

.feature-card:hover {
  transform: scale(1.05); 
  background-color: #f0f4fa; 
  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
}

.feature-card img {
  transition: transform 0.3s, filter 0.3s; 
  border-radius: 5px;
}

.feature-card:hover img {
  transform: scale(1.1); 
  filter: brightness(1.2); 
}

.feature-card h3 {
  transition: color 0.3s; 
}

.feature-card:hover h3 {
  color: #456ECE; 
}

.feature-card p {
  transition: color 0.3s; 
}

.feature-card:hover p {
  color: #253B6E; 
}

.feature-card .lorem-ipsum-button {
  transition: transform 0.2s, background-color 0.3s; 
}

.feature-card:hover .lorem-ipsum-button {
  transform: scale(1.1); 
  background: linear-gradient(to bottom, #456ECE, #D2ECF9); 
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); 
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
        <a href="../html/donasi.html">Donation</a>

        <div class="menu-item">
            <a href="#" onclick="toggleDropdown(event, 'ecoDropdown')">Eco-Market</a>
            <ul id="ecoDropdown" class="dropdown">
                <li><a href="../html/sell.html">Jual</a></li>
                <li><a href="../php/buy.php">Beli</a></li>
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


  <section class="hero">
    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/0d004010ecb5602b7c6a001e68306500494f367671ae7dd61a8cfe80a1f01197" alt="Background Image" class="hero-bg">
    <div class="hero-content">
      <h1 class="hero-title">Make Every Action Count for the Earth</h1>
      <div class="hero-description">
        <p>Bergabunglah dengan komunitas peduli lingkungan <br> untuk beraksi nyata! Mulai dari kegiatan volunteer <br> membersihkan lingkungan, donasi untuk reboisasi, <br> hingga transaksi jual beli bahan daur ulang. Kami <br> menyediakan platform bagi Anda untuk berkontribusi <br> dalam menjaga keberlanjutan alam. Setiap langkah <br> kecil yang Anda ambil akan berdampak besar bagi <br> bumi kita.</p>
      </div>
    </div>
  </section>
</body>

  <section class="support">
    <img src="../image/logounep.png" alt="Support Icon" class="support-icon">
    <img src="../image/logowwf.png" alt="Support Icon" class="support-icon">
    <img src="../image/walhi.png" alt="Support Icon" class="support-icon">
  </section>

  <section class="features">
    <div class="feature-card">
      <h3>Daftar Kegiatan</h3>
      <img src="../image/pngwing.com.png" alt="Feature 1">
      <p>Bergabunglah dengan <br> komunitas peduli lingkungan <br> untuk beraksi</p>
      <a href="../php/daftarkegiatan.php"><button class="lorem-ipsum-button">Daftar </button></a>
    </div>

    <div class="feature-card">
      <h3>Donasi Reboisasi</h3>
      <img src="../image/pngwing.com (1).png" alt="Feature 2">
      <p>Bersama kita wujudkan hutan lestari demi <br> masa depan yang <br> lebih hijau</p>
      <a href="../html/donasi.html"><button class="lorem-ipsum-button">Donasi </button></a>
    </div>

    <div class="feature-card">
      <h3>Eco Market</h3>
      <img src="../image/pngwing.com (2).png" alt="Feature 3">
      <p>Beli barang bekas berkualitas untuk dukung daur ulang yang berkelanjutan</p>
      <a href="../php/buy.php"><button class="lorem-ipsum-button">Beli </button></a>
    </div>
</section>


  <section class="tulisan-artikel">
    <hi>Artikel</hi>
  </section>

  <section class="articles">
    <a href="https://ppid.menlhk.go.id/berita/siaran-pers/6444/aksi-bersih-pantai-upaya-bangkitkan-kesadaran-kolektif-tangani-sampah" target="_blank" class="article-card">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/2d2fb5fc3ac929b9e468aaada61b5d0323d0eade185c0f294e78c5d25b7bf79d" alt="Article 1">
      <time>Jumat, 13/09/2024</time>
      <h3>Kegiatan bersih pantai atau coastal clean up, di kawasan pantai Tanjung Pasir</h3>
    </a>
    <a href="https://www.kompasiana.com/masriodwinurzulim6549/664b61fb1470931fc0476e04/kegiatan-reboisasi-hutan-tretes-desa-wonorejo" target="_blank" class="article-card">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/a26227d62056d80a0c6a1d3a062c3402f763d6275c2da3b5892aa8f4126224ca" alt="Article 2">
      <time>Senin, 30/08/2024</time>
      <h3>Reboisasi di hutan tretes bersama dengan mahasiswa KKN dari Universitas Negeri Malang</h3>
    </a>
    <a href="https://dlh.sulbarprov.go.id/?p=7701" target="_blank" class="article-card">
      <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/a2d71771e300ed86d0cc614fa96046dd09972e9fef426d42e40130c3c00c770a" alt="Article 3">
      <time>Kamis, 23/08/2024</time>
      <h3>Dinas Lingkungan Hidup (DLH) Sulawesi Barat (Sulbar) melaksanan aksi bersih-bersih pantai di Pantai Arteri Mamuju</h3>
    </a>
</section>

  <footer>
    <p>© 2024 PandawaraHub. All rights reserved.</p>
  </footer>
  <script src="../js/homepage.js"></script>
</body>

</html>