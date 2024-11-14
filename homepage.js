function toggleDropdown(event, dropdownId) {
    event.preventDefault(); // Mencegah perilaku default link (navigasi)

    var dropdown = document.getElementById(dropdownId);

    // Cek apakah dropdown sudah ditampilkan, jika iya sembunyikan
    if (dropdown.classList.contains("show")) {
        dropdown.classList.remove("show");
    } else {
        // Sembunyikan dropdown lainnya jika ada
        var allDropdowns = document.querySelectorAll('.dropdown');
        allDropdowns.forEach(function(d) {
            d.classList.remove("show");
        });

        // Tampilkan dropdown yang diklik
        dropdown.classList.add("show");
    }
}

// Event listener untuk klik di luar dropdown
document.addEventListener('click', function(event) {
    var dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function(dropdown) {
        // Cek jika klik terjadi di luar dropdown dan tombol dropdown
        if (!dropdown.contains(event.target) && !event.target.closest('.menu-item')) {
            dropdown.classList.remove('show');
        }
    });
});