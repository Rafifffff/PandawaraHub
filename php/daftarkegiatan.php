<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$userId = $_SESSION['user_id'];

$query = "
    SELECT e.event_id, e.title, e.date, e.description, e.image,
           (SELECT COUNT(*) FROM user_events ue WHERE ue.event_id = e.event_id AND ue.user_id = ?) AS is_registered
    FROM events e
    ORDER BY e.date DESC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan</title>
    <link rel="stylesheet" href="../css/styledaftarkegiatan.css">

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

  .articles {
    display: flex;
    justify-content: space-around;
    padding: 100px;
    background: linear-gradient(180deg, #1F5F8B 17%, #253B6E 50%, black 90%);
    color: white;
  }
  
  .articles h1 {
    margin-bottom: 30px;
    font-size: 22px;
    font-family: 'poppins', sans-serif;
  }
  
  .article-card {
    display: inline-block;
    width: 400px;
    height: 450px;
    margin: 20px;
    text-align: left;
    background: white;
    border-radius: 30px;
    padding: 20px;
    color: black; 
    box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
    -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
    font-family: 'poppins', sans-serif;
    font-weight: bold;
    font-size: 14px;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .article-card img {
    width: 100%;
    border-radius: 10px;
  }
  
  .article-card time {
    display: block;
    margin-top: 40px;
    font-size: 12px;
    color: black;
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

.bell-icon, .profile-icon {
  transition: transform 0.3s; 
}

.bell-icon:hover, .profile-icon:hover {
  transform: rotate(10deg) scale(1.1); 
}
  </style>

    <script>
function toggleDropdown(event, dropdownId) {
    event.preventDefault();
    
    const allDropdowns = document.querySelectorAll('.dropdown');
    allDropdowns.forEach(dropdown => {
        if (dropdown.id !== dropdownId) {
            dropdown.classList.remove('show');
        }
    });

    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('show');
}
</script>

    <script>
        function confirmRegistration(event) {
            if (!confirm("Apakah anda ingin berpartisipasi dalam kegiatan ini?")) {
                event.preventDefault(); 
            }
        }
    </script>

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

<section class="search">
    <a href="../php/kegiatandiikuti.php">
        <button class="tombol">Daftar Kegiatan</button>
    </a>  
    <div class="search-container">
        <input type="text" placeholder="Pilih Kota">
        <input type="date" placeholder="Pilih Tanggal">
    </div>
    <a href="../php/batalkegiatan.php">
        <button class="tombol">Pembatalan Partisipasi</button>
    </a>
</section>

<section class="articles">
    <?php if (count($events) > 0): ?>
        <?php foreach ($events as $event): ?>
            <div class="article-card">
                <img src="../image/<?= htmlspecialchars($event['image']); ?>" alt="<?= htmlspecialchars($event['title']); ?>">
                <h2><?= htmlspecialchars($event['title']); ?></h2>
                <p><?= htmlspecialchars($event['description']); ?></p>
                <time><?= date('l, d/m/Y', strtotime($event['date'])); ?></time>
                <?php if ($event['is_registered']): ?>
                    <button class="tombol registered" disabled>Terdaftar</button>
                <?php else: ?>
                    <form method="POST" action="../php/register_event.php" onsubmit="confirmRegistration(event)">
                        <input type="hidden" name="event_id" value="<?= $event['event_id']; ?>">
                        <button class="tombol" type="submit">Daftar</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada kegiatan yang tersedia saat ini.</p>
    <?php endif; ?>
</section>
</body>
</html>


