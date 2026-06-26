document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       1. Delete Confirmation
    ========================= */

    document.querySelectorAll(".delete-post").forEach(button => {
        button.addEventListener("click", function (e) {
            if (!confirm("Are you sure you want to delete this post?")) {
                e.preventDefault();
            }
        });
    });


    /* =========================
       2. Image / Video Preview
    ========================= */

    const mediaInput = document.getElementById("media");
    const previewBox = document.getElementById("preview");

    if (mediaInput && previewBox) {

        mediaInput.addEventListener("change", function (event) {

            previewBox.innerHTML = "";

            Array.from(event.target.files).forEach(file => {

                const reader = new FileReader();

                reader.onload = function (e) {

                    if (file.type.startsWith("image")) {

                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.style.width = "120px";
                        img.style.margin = "5px";
                        img.style.borderRadius = "8px";

                        previewBox.appendChild(img);

                    }

                    if (file.type.startsWith("video")) {

                        const video = document.createElement("video");
                        video.src = e.target.result;
                        video.controls = true;
                        video.style.width = "150px";
                        video.style.margin = "5px";

                        previewBox.appendChild(video);

                    }

                };

                reader.readAsDataURL(file);

            });

        });

    }


    /* =========================
       3. Post Card Hover Effect
    ========================= */

    document.querySelectorAll(".card").forEach(card => {

        card.addEventListener("mouseenter", function () {
            card.style.transform = "scale(1.02)";
            card.style.transition = "0.3s";
        });

        card.addEventListener("mouseleave", function () {
            card.style.transform = "scale(1)";
        });

    });


    /* =========================
       4. Scroll To Top Button
    ========================= */

    const scrollBtn = document.createElement("button");

    scrollBtn.innerHTML = "↑";
    scrollBtn.id = "scrollTopBtn";

    scrollBtn.style.position = "fixed";
    scrollBtn.style.bottom = "30px";
    scrollBtn.style.right = "30px";
    scrollBtn.style.padding = "10px 15px";
    scrollBtn.style.border = "none";
    scrollBtn.style.background = "#dc3545";
    scrollBtn.style.color = "white";
    scrollBtn.style.borderRadius = "50%";
    scrollBtn.style.cursor = "pointer";
    scrollBtn.style.display = "none";

    document.body.appendChild(scrollBtn);

    window.addEventListener("scroll", function () {

        if (window.scrollY > 300) {
            scrollBtn.style.display = "block";
        } else {
            scrollBtn.style.display = "none";
        }

    });

    scrollBtn.addEventListener("click", function () {

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });


    /* =========================
       5. Character Counter
    ========================= */

    const bodyField = document.getElementById("body");

    if (bodyField) {

        const counter = document.createElement("small");

        counter.style.display = "block";
        counter.style.marginTop = "5px";
        counter.style.color = "gray";

        bodyField.parentNode.appendChild(counter);

        bodyField.addEventListener("input", function () {

            counter.innerText = bodyField.value.length + " characters";

        });

    }


    /* =========================
       6. Auto Close Alerts
    ========================= */

    document.querySelectorAll(".alert").forEach(alert => {

        setTimeout(() => {
            alert.style.display = "none";
        }, 4000);

    });


    /* =========================
       7. Navbar Active Link
    ========================= */

    const currentURL = window.location.href;

    document.querySelectorAll(".nav-link").forEach(link => {

        if (currentURL.includes(link.getAttribute("href"))) {
            link.classList.add("active");
        }

    });


    /* =========================
       8. Simple Live Search
    ========================= */

    const searchInput = document.getElementById("searchInput");

    if (searchInput) {

        searchInput.addEventListener("keyup", function () {

            const value = this.value.toLowerCase();

            document.querySelectorAll(".post-card").forEach(post => {

                const text = post.textContent.toLowerCase();

                post.style.display = text.includes(value) ? "block" : "none";

            });

        });

    }


    /* =========================
       9. Fade In Animation
    ========================= */

    const fadeElements = document.querySelectorAll(".fade-in");

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.style.opacity = 1;
                entry.target.style.transform = "translateY(0)";

            }

        });

    });

    fadeElements.forEach(el => {

        el.style.opacity = 0;
        el.style.transform = "translateY(20px)";
        el.style.transition = "0.6s";

        observer.observe(el);

    });

});