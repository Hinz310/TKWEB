document.addEventListener("DOMContentLoaded", function () {

    const menuButton = document.querySelector(".menu-button");
    const menuIcon = document.querySelector(".menu-icon");
    const sideMenu = document.querySelector(".side-menu");

    const categoryToggle = document.querySelector(".category-toggle");
    const categorySubmenu = document.querySelector(".category-submenu");

    const accountButton = document.querySelector(".account-button");
    const accountDropdown = document.querySelector(".account-dropdown");


    // MỞ / ĐÓNG MENU
    menuButton.addEventListener("click", function (event) {
        event.stopPropagation();

        const isOpen = sideMenu.classList.toggle("show");

        menuIcon.textContent = isOpen ? "×" : "☰";
        menuButton.setAttribute("aria-expanded", isOpen);

        // Đóng tài khoản nếu đang mở
        accountDropdown.classList.remove("show");
        accountButton.setAttribute("aria-expanded", "false");
    });


    // MỞ / ĐÓNG DANH MỤC CON
    categoryToggle.addEventListener("click", function (event) {
        event.stopPropagation();

        const isOpen = categorySubmenu.classList.toggle("show");

        categoryToggle.setAttribute("aria-expanded", isOpen);
    });


    // MỞ / ĐÓNG HỘP TÀI KHOẢN
    accountButton.addEventListener("click", function (event) {
        event.stopPropagation();

        const isOpen = accountDropdown.classList.toggle("show");

        accountButton.setAttribute("aria-expanded", isOpen);

        // Đóng menu nếu đang mở
        sideMenu.classList.remove("show");
        menuIcon.textContent = "☰";
        menuButton.setAttribute("aria-expanded", "false");
    });


    // Không đóng khi click bên trong menu
    sideMenu.addEventListener("click", function (event) {
        event.stopPropagation();
    });


    // Không đóng khi click trong hộp tài khoản
    accountDropdown.addEventListener("click", function (event) {
        event.stopPropagation();
    });


    // CLICK RA NGOÀI → ĐÓNG
    document.addEventListener("click", function () {

        sideMenu.classList.remove("show");
        menuIcon.textContent = "☰";
        menuButton.setAttribute("aria-expanded", "false");

        accountDropdown.classList.remove("show");
        accountButton.setAttribute("aria-expanded", "false");
    });

});