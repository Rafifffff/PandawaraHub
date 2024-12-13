    <?php
    session_start();
    include 'koneksi.php';

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../html/login.html");
        exit();
    }

    if (isset($_GET['id'])) {
        $commentId = intval($_GET['id']);
        $userId = $_SESSION['user_id'];

        $query = "SELECT * FROM comments WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $commentId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $queryDelete = "DELETE FROM comments WHERE id = ? AND user_id = ?";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bind_param("ii", $commentId, $userId);
            
            if ($stmtDelete->execute()) {
                $idPabrik = isset($_GET['id_pabrik']) ? intval($_GET['id_pabrik']) : 0;
                header("Location: komentar.php?id_pabrik=" . $idPabrik);
                exit();
            } else {
                echo "Gagal menghapus komentar.";
            }
        } else {
            echo "Komentar tidak ditemukan atau Anda tidak memiliki izin untuk menghapus komentar ini.";
        }
    } else {
        die("ID komentar tidak ditemukan.");
    }
    ?>