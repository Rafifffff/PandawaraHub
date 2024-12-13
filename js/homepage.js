function toggleDropdown(event, dropdownId) {
    event.preventDefault(); 

    var allDropdowns = document.querySelectorAll('.dropdown, .profile-dropdown');
    allDropdowns.forEach(function(d) {
        if (d.id !== dropdownId) {
            d.classList.remove("show");
        }
    });

    var dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle("show");
}

document.addEventListener('click', function(event) {
    var allDropdowns = document.querySelectorAll('.dropdown, .profile-dropdown');
    allDropdowns.forEach(function(dropdown) {
        if (!dropdown.contains(event.target) && !event.target.closest('.menu-item') && !event.target.closest('.profile-container')) {
            dropdown.classList.remove('show');
        }
    });
});
