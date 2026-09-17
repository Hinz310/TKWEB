document.addEventListener("DOMContentLoaded", function () {

    const menuButton = document.querySelector(".menu-button");
    const menuIcon = document.querySelector(".menu-icon");
    const sideMenu = document.querySelector(".side-menu");

    const categoryToggle = document.querySelector(".category-toggle");
    const categorySubmenu = document.querySelector(".category-submenu");

    const accountButton = document.querySelector(".account-button");
    const accountDropdown = document.querySelector(".account-dropdown");


    // =========================
    // MENU
    // =========================
    if (menuButton && sideMenu) {

        menuButton.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = sideMenu.classList.toggle("show");

            if (menuIcon) {
                menuIcon.textContent = isOpen ? "×" : "☰";
            }

            menuButton.setAttribute("aria-expanded", isOpen ? "true" : "false");

            // Đóng tài khoản
            if (accountDropdown) {
                accountDropdown.classList.remove("show");
            }

            if (accountButton) {
                accountButton.setAttribute("aria-expanded", "false");
            }
        });


        // Click trong menu không làm menu đóng
        sideMenu.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    }


    // =========================
    // DANH MỤC CON
    // =========================
    if (categoryToggle && categorySubmenu) {

        categoryToggle.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = categorySubmenu.classList.toggle("show");

            categoryToggle.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );
        });
    }


    // =========================
    // TÀI KHOẢN
    // =========================
    if (accountButton && accountDropdown) {

        accountButton.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = accountDropdown.classList.toggle("show");

            accountButton.setAttribute(
                "aria-expanded",
                isOpen ? "true" : "false"
            );


            // Đóng menu
            if (sideMenu) {
                sideMenu.classList.remove("show");
            }

            if (menuIcon) {
                menuIcon.textContent = "☰";
            }

            if (menuButton) {
                menuButton.setAttribute("aria-expanded", "false");
            }
        });


        // Click bên trong tài khoản không đóng dropdown
        accountDropdown.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    }


    // =========================
    // CLICK RA NGOÀI
    // =========================
    document.addEventListener("click", function () {

        if (sideMenu) {
            sideMenu.classList.remove("show");
        }

        if (menuIcon) {
            menuIcon.textContent = "☰";
        }

        if (menuButton) {
            menuButton.setAttribute("aria-expanded", "false");
        }

        if (accountDropdown) {
            accountDropdown.classList.remove("show");
        }

        if (accountButton) {
            accountButton.setAttribute("aria-expanded", "false");
        }
    });


    // =========================
    // XEM THÊM SẢN PHẨM
    // =========================
    const products = document.querySelectorAll(".category-product");
    const loadMoreBtn = document.getElementById("loadMoreBtn");

    if (loadMoreBtn && products.length > 0) {

        let visibleCount = 8;

        products.forEach(function (product, index) {

            if (index < visibleCount) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }

        });


        if (products.length <= visibleCount) {
            loadMoreBtn.style.display = "none";
        }


        loadMoreBtn.addEventListener("click", function () {

            const nextCount = visibleCount + 4;

            for (
                let i = visibleCount;
                i < nextCount && i < products.length;
                i++
            ) {
                products[i].style.display = "block";
            }

            visibleCount = Math.min(nextCount, products.length);

            if (visibleCount >= products.length) {
                loadMoreBtn.style.display = "none";
            }
        });
    }

});