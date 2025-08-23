// Mobile menu toggle matching _header.blade.php ids
function toggleMobileMenu() {
    const menu = document.getElementById("mobile-menu");
    const button = document.getElementById("mobile-menu-button");
    const line1 = document.getElementById("line1");
    const line2 = document.getElementById("line2");
    const line3 = document.getElementById("line3");
    if (!menu || !button) return;
    const isClosed = menu.classList.contains("opacity-0");
    if (isClosed) {
        menu.classList.remove(
            "opacity-0",
            "-translate-y-full",
            "pointer-events-none"
        );
        menu.classList.add(
            "opacity-100",
            "translate-y-0",
            "pointer-events-auto"
        );
        if (line1 && line2 && line3) {
            line1.style.transform = "rotate(45deg) translate(5px, 5px)";
            line2.style.opacity = "0";
            line2.style.transform = "scale(0)";
            line3.style.transform = "rotate(-45deg) translate(5px, -5px)";
        }
    } else {
        menu.classList.add(
            "opacity-0",
            "-translate-y-full",
            "pointer-events-none"
        );
        menu.classList.remove(
            "opacity-100",
            "translate-y-0",
            "pointer-events-auto"
        );
        if (line1 && line2 && line3) {
            line1.style.transform = "rotate(0) translate(0, 0)";
            line2.style.opacity = "1";
            line2.style.transform = "scale(1)";
            line3.style.transform = "rotate(0) translate(0, 0)";
        }
    }
}
window.toggleMobileMenu = toggleMobileMenu;

// Desktop nav active state and smooth scroll
document.addEventListener("DOMContentLoaded", function () {
    const links = Array.from(
        document.querySelectorAll(".desktop-nav .nav-link")
    );
    const activeClasses = ["text-red-600", "bg-red-50", "font-semibold"];

    const applyActive = (matchHref) => {
        links.forEach((a) => {
            const indicator = a.querySelector(".active-indicator");
            const href = a.getAttribute("href") || "";
            // Normalize non-hash links to pathname for reliable comparison
            let targetPath = href;
            if (!href.startsWith("#")) {
                try {
                    targetPath = new URL(href, window.location.origin).pathname;
                } catch (_) {
                    targetPath = href; // fallback
                }
            }
            const currentPath = window.location.pathname || "";
            const isActive =
                href === matchHref ||
                (!matchHref && targetPath === currentPath);
            if (indicator)
                indicator.style.display = isActive ? "block" : "none";
            a.classList.toggle(activeClasses[0], isActive);
            a.classList.toggle(activeClasses[1], isActive);
            a.classList.toggle(activeClasses[2], isActive);
        });
    };

    const setActiveFromHash = () => applyActive(window.location.hash || "");
    setActiveFromHash();
    window.addEventListener("hashchange", setActiveFromHash);

    links.forEach((a) => {
        a.addEventListener("click", (e) => {
            const href = a.getAttribute("href") || "";
            if (href.startsWith("#")) {
                e.preventDefault();
                applyActive(href);
                const targetEl = document.querySelector(href);
                if (targetEl) {
                    const offset = 80;
                    const top =
                        targetEl.getBoundingClientRect().top +
                        window.pageYOffset -
                        offset;
                    window.scrollTo({ top, behavior: "smooth" });
                }
                if (window.location.hash !== href)
                    history.pushState(null, "", href);
            }
        });
    });

    // Close mobile menu when tapping any link, and smooth scroll
    const menu = document.getElementById("mobile-menu");
    if (menu) {
        const mobileLinks = Array.from(menu.querySelectorAll("a"));
        mobileLinks.forEach((link) => {
            link.addEventListener("click", function (e) {
                const href = link.getAttribute("href") || "";
                const isHash = href.startsWith("#");
                if (isHash) e.preventDefault();
                if (!menu.classList.contains("opacity-0")) toggleMobileMenu();
                if (isHash) {
                    const targetEl = document.querySelector(href);
                    if (targetEl) {
                        const offset = 80;
                        const top =
                            targetEl.getBoundingClientRect().top +
                            window.pageYOffset -
                            offset;
                        window.scrollTo({ top, behavior: "smooth" });
                        if (window.location.hash !== href)
                            history.pushState(null, "", href);
                    }
                }
            });
        });
    }

    // Header shadow on scroll
    const h = document.querySelector("header, nav");
    const updateShadow = () => {
        if (!h) return;
        const scrolled = window.scrollY > 2;
        h.classList.toggle("shadow", scrolled);
        h.classList.toggle("shadow-soft", scrolled);
    };
    updateShadow();
    window.addEventListener("scroll", updateShadow, { passive: true });

    // Media marquee: ensure enough items to loop visually
    const track = document.getElementById("media-track");
    if (track && track.parentElement) {
        const wrapper = track.parentElement;
        const baseChildren = Array.from(track.children).map((n) =>
            n.cloneNode(true)
        );
        const ensureLoopWidth = () => {
            let guard = 0;
            while (track.scrollWidth < wrapper.clientWidth * 2 && guard < 20) {
                baseChildren.forEach((n) =>
                    track.appendChild(n.cloneNode(true))
                );
                guard += 1;
            }
        };
        ensureLoopWidth();
        let resizeTimer;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                while (track.children.length > baseChildren.length)
                    track.removeChild(track.lastElementChild);
                ensureLoopWidth();
            }, 150);
        });
    }
});

// ==============================
// Shuffle Grid for About Section
// ==============================
(function () {
    const squareData = [
        {
            src: "https://images.unsplash.com/photo-1547347298-4074fc3086f0?auto=format&fit=crop&w=1740&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1510925758641-869d353cecc7?auto=format&fit=crop&w=687&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1629901925121-8a141c2a42f4?auto=format&fit=crop&w=687&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1580238053495-b9720401fd45?auto=format&fit=crop&w=687&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1569074187119-c87815b476da?auto=format&fit=crop&w=1325&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1556817411-31ae72fa3ea0?auto=format&fit=crop&w=1740&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1599586120429-48281b6f0ece?auto=format&fit=crop&w=1740&q=80",
        },
        {
            src: "https://plus.unsplash.com/premium_photo-1671436824833-91c0741e89c9?auto=format&fit=crop&w=1740&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?auto=format&fit=crop&w=1740&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1610768764270-790fbec18178?auto=format&fit=crop&w=687&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1507034589631-9433cc6bc453?auto=format&fit=crop&w=684&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1533107862482-0e6974b06ec4?auto=format&fit=crop&w=882&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1560089000-7433a4ebbd64?auto=format&fit=crop&w=870&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=686&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1606244864456-8bee63fce472?auto=format&fit=crop&w=681&q=80",
        },
        {
            src: "https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=1820&q=80",
        },
    ];

    function shuffle(arr) {
        const a = arr.slice();
        for (let i = a.length - 1; i > 0; i -= 1) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    }

    function renderShuffleGrid() {
        const container = document.getElementById("shuffle-grid");
        if (!container) return false;
        const images = shuffle(squareData).slice(0, 16);
        container.innerHTML = "";
        images.forEach((img, i) => {
            const tile = document.createElement("div");
            tile.className =
                "rounded-md bg-slate-200/60 transition-opacity duration-700 ease-in-out opacity-0";
            tile.style.width = "100%";
            tile.style.height = "100%";
            tile.style.backgroundImage = `url(${img.src})`;
            tile.style.backgroundSize = "cover";
            tile.style.backgroundPosition = "center";
            setTimeout(() => tile.classList.remove("opacity-0"), i * 25);
            container.appendChild(tile);
        });
        return true;
    }

    let shuffleTimer;
    function startShuffleLoop() {
        if (!renderShuffleGrid()) return; // grid not on page
        if (shuffleTimer) clearTimeout(shuffleTimer);
        shuffleTimer = setTimeout(startShuffleLoop, 3000);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", startShuffleLoop);
    } else {
        startShuffleLoop();
    }
})();
