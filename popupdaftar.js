// Fungsi untuk membuka popup konfirmasi
function openConfirmModal() {
    document.getElementById("confirmModal").style.display = "block";
  }
  
  // Fungsi untuk menutup popup dan menangani konfirmasi
  function confirmAction(isConfirmed) {
    if (isConfirmed) {
      alert("Anda telah terdaftar dalam kegiatan ini!");
    } else {
      alert("Pendaftaran dibatalkan.");
    }
    document.getElementById("confirmModal").style.display = "none";
  }
  
  // Tambahkan event listener ke semua tombol "Daftar"
  document.querySelectorAll('.tombol').forEach(button => {
    button.addEventListener('click', openConfirmModal);
  });
  