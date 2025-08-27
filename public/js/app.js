// =================
// Header interactions
// =================

// Smooth scrolling for all anchor links with hashes to sections on the same page
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    // Skip header nav links; those are handled with offset below
    if (anchor.closest(".desktop-nav")) return;
    anchor.addEventListener("click", function onAnchorClick(e) {
        const targetId = this.getAttribute("href");
        if (targetId && targetId.length > 1) {
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        }
    });
});

// Header reveal animation on first paint
const siteHeader = document.getElementById("site-header");
if (siteHeader) {
    requestAnimationFrame(() => {
        siteHeader.classList.remove("-translate-y-6", "opacity-0");
    });
}

// Simple client-side include for header/footer partials
async function includePartials() {
    const placeholders = document.querySelectorAll("[data-include]");
    if (placeholders.length) {
        await Promise.all(
            Array.from(placeholders).map(async (el) => {
                const url = el.getAttribute("data-include");
                if (!url) return;
                try {
                    const res = await fetch(url, { cache: "no-cache" });
                    const html = await res.text();
                    el.outerHTML = html;
                } catch (e) {
                    // eslint-disable-next-line no-console
                    console.warn("Failed to include", url, e);
                }
            })
        );
    }
    // Initialize interactions even if there were no placeholders
    setupHeaderInteractions();
    setupMediaMarquee();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", includePartials);
} else {
    includePartials();
}

function setupHeaderInteractions() {
    const headerEl =
        document.getElementById("site-header") ||
        document.querySelector("header");
    if (headerEl) headerEl.classList.remove("-translate-y-6", "opacity-0");

    // Mobile menu is handled by inline JavaScript in header

    // Desktop active indicator + click smooth scroll with header offset
    const links = Array.from(
        document.querySelectorAll(".desktop-nav .nav-link")
    );
    const activeClasses = ["text-red-600", "bg-red-50", "font-semibold"];

    const applyActive = (matchHref) => {
        const homeLink = document.getElementById("home-link");

        // Clear all active states first
        links.forEach((a) => {
            a.classList.remove(...activeClasses);
            const indicator = a.querySelector(".active-indicator");
            if (indicator) indicator.style.display = "none";
        });

        if (homeLink) {
            homeLink.classList.remove(...activeClasses);
            const indicator = homeLink.querySelector(".active-indicator");
            if (indicator) indicator.style.display = "none";
        }

        if (matchHref && matchHref !== "#" && matchHref !== "#hero") {
            // Hash link is active (but not hero)
            links.forEach((a) => {
                const target = a.getAttribute("href");
                if (target === matchHref) {
                    const indicator = a.querySelector(".active-indicator");
                    if (indicator) indicator.style.display = "block";
                    a.classList.add(...activeClasses);
                }
            });
        } else {
            // No hash, empty hash, or hero hash - activate home link
            if (homeLink) {
                homeLink.classList.add(...activeClasses);
                const indicator = homeLink.querySelector(".active-indicator");
                if (indicator) indicator.style.display = "block";
            }
        }
    };

    const setActiveFromHash = () => {
        // Only apply hash-based active states if we're on the home page
        const isHomePage =
            window.location.pathname === "/" ||
            window.location.pathname.includes("home");
        if (isHomePage) {
            applyActive(window.location.hash || "");
        }
    };
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

    // Shadow on scroll for included header
    const updateShadow = () => {
        const h =
            document.getElementById("site-header") ||
            document.querySelector("header");
        if (!h) return;
        const scrolled = window.scrollY > 2;
        h.classList.toggle("shadow", scrolled);
        h.classList.toggle("shadow-soft", scrolled);
    };
    updateShadow();
    window.addEventListener("scroll", updateShadow, { passive: true });
}

// Ensure media coverage slider loops seamlessly by cloning items until width >= 2x viewport
function setupMediaMarquee() {
    const track = document.getElementById("media-track");
    if (!track) return;
    const wrapper = track.parentElement;
    if (!wrapper) return;

    const baseChildren = Array.from(track.children).map((n) =>
        n.cloneNode(true)
    );

    const ensureLoopWidth = () => {
        let guard = 0;
        while (track.scrollWidth < wrapper.clientWidth * 2 && guard < 20) {
            baseChildren.forEach((n) => track.appendChild(n.cloneNode(true)));
            guard += 1;
        }
    };

    ensureLoopWidth();

    // Recalculate on resize (debounced)
    let resizeTimer;
    window.addEventListener("resize", () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            while (track.children.length > baseChildren.length) {
                track.removeChild(track.lastElementChild);
            }
            ensureLoopWidth();
        }, 150);
    });
}

// Active nav link highlighting based on section in view
const navLinks = document.querySelectorAll(".nav-link");
const linkMap = new Map();
navLinks.forEach((link) => {
    const href = link.getAttribute("href");
    if (href && href.startsWith("#")) {
        linkMap.set(href.slice(1), link);
    }
});

// Match home link active styling
const activeClass = ["text-red-600", "bg-red-50", "font-semibold"];
const sections = Array.from(linkMap.keys())
    .map((id) => document.getElementById(id))
    .filter(Boolean);

// Add hero section for home link activation
const heroSection = document.getElementById("hero");
if (heroSection && !sections.includes(heroSection)) {
    sections.unshift(heroSection); // Add to beginning
}

const updateActive = (id) => {
    // Only update active states if we're on the home page
    const isHomePage =
        window.location.pathname === "/" ||
        window.location.pathname.includes("home");
    if (!isHomePage) return;

    // Get the home link
    const homeLink = document.getElementById("home-link");

    // Clear all active states first (including home link)
    navLinks.forEach((l) => {
        l.classList.remove(...activeClass);
        const ind = l.querySelector(".active-indicator");
        if (ind) ind.style.display = "none";
    });

    if (homeLink) {
        homeLink.classList.remove(...activeClass);
        const ind = homeLink.querySelector(".active-indicator");
        if (ind) ind.style.display = "none";
    }

    if (id === "hero" || !id) {
        // At hero section or top - activate home link
        if (homeLink) {
            homeLink.classList.add(...activeClass);
            const ind = homeLink.querySelector(".active-indicator");
            if (ind) ind.style.display = "block";
        }
    } else {
        // A specific section is active - activate that section's link
        const link = linkMap.get(id);
        if (link) {
            link.classList.add(...activeClass);
            const ind = link.querySelector(".active-indicator");
            if (ind) ind.style.display = "block";
        }
    }
};

if (sections.length) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const sectionId = entry.target.id;
                    // If hero section is in view, treat it as home
                    if (sectionId === "hero") {
                        updateActive("hero");
                    } else {
                        updateActive(sectionId);
                    }
                }
            });
        },
        {
            rootMargin: "-40% 0px -50% 0px",
            threshold: [0, 0.25, 0.5, 0.75, 1],
        }
    );
    sections.forEach((section) => observer.observe(section));

    // Initialize with Home active if at top of page
    if (window.scrollY < 100) {
        updateActive("hero");
    }
}

// ==============================
// Shuffle Hero (vanilla JS port)
// ==============================
const squareData = [
    {
        id: 1,
        src: "https://images.unsplash.com/photo-1547347298-4074fc3086f0?auto=format&fit=crop&w=1740&q=80",
    },
    {
        id: 2,
        src: "https://images.unsplash.com/photo-1510925758641-869d353cecc7?auto=format&fit=crop&w=687&q=80",
    },
    {
        id: 3,
        src: "https://images.unsplash.com/photo-1629901925121-8a141c2a42f4?auto=format&fit=crop&w=687&q=80",
    },
    {
        id: 4,
        src: "https://images.unsplash.com/photo-1580238053495-b9720401fd45?auto=format&fit=crop&w=687&q=80",
    },
    {
        id: 5,
        src: "https://images.unsplash.com/photo-1569074187119-c87815b476da?auto=format&fit=crop&w=1325&q=80",
    },
    {
        id: 6,
        src: "https://images.unsplash.com/photo-1556817411-31ae72fa3ea0?auto=format&fit=crop&w=1740&q=80",
    },
    {
        id: 7,
        src: "https://images.unsplash.com/photo-1599586120429-48281b6f0ece?auto=format&fit=crop&w=1740&q=80",
    },
    {
        id: 8,
        src: "https://plus.unsplash.com/premium_photo-1671436824833-91c0741e89c9?auto=format&fit=crop&w=1740&q=80",
    },
    {
        id: 9,
        src: "https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?auto=format&fit=crop&w=1740&q=80",
    },
    {
        id: 10,
        src: "https://images.unsplash.com/photo-1610768764270-790fbec18178?auto=format&fit=crop&w=687&q=80",
    },
    {
        id: 11,
        src: "https://images.unsplash.com/photo-1507034589631-9433cc6bc453?auto=format&fit=crop&w=684&q=80",
    },
    {
        id: 12,
        src: "https://images.unsplash.com/photo-1533107862482-0e6974b06ec4?auto=format&fit=crop&w=882&q=80",
    },
    {
        id: 13,
        src: "https://images.unsplash.com/photo-1560089000-7433a4ebbd64?auto=format&fit=crop&w=870&q=80",
    },
    {
        id: 14,
        src: "https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=686&q=80",
    },
    {
        id: 15,
        src: "https://images.unsplash.com/photo-1606244864456-8bee63fce472?auto=format&fit=crop&w=681&q=80",
    },
    {
        id: 16,
        src: "https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=1820&q=80",
    },
];

function shuffle(array) {
    const a = array.slice();
    let currentIndex = a.length;
    while (currentIndex !== 0) {
        const randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;
        [a[currentIndex], a[randomIndex]] = [a[randomIndex], a[currentIndex]];
    }
    return a;
}

function calculateGridLayout(imageCount) {
    // For even numbers of images, create a balanced grid
    if (imageCount <= 0) return { cols: 4, rows: 4 }; // fallback

    if (imageCount === 2) return { cols: 2, rows: 1 };
    if (imageCount === 4) return { cols: 2, rows: 2 };
    if (imageCount === 6) return { cols: 3, rows: 2 };
    if (imageCount === 8) return { cols: 4, rows: 2 };
    if (imageCount === 10) return { cols: 5, rows: 2 };
    if (imageCount === 12) return { cols: 4, rows: 3 };
    if (imageCount === 14) return { cols: 7, rows: 2 };
    if (imageCount === 16) return { cols: 4, rows: 4 };

    // For other even numbers, try to make a balanced rectangle
    const sqrt = Math.sqrt(imageCount);
    const cols = Math.ceil(sqrt);
    const rows = Math.ceil(imageCount / cols);

    return { cols, rows };
}

function renderShuffleGrid() {
    const container = document.getElementById("shuffle-grid");
    if (!container) return;

    // Get dynamic image data from the container
    const hasImages = container.dataset.hasImages === "true";
    let images = [];
    let fallbackImages = [];

    if (hasImages) {
        try {
            images = JSON.parse(container.dataset.images || "[]");
        } catch (e) {
            console.warn("Failed to parse image data:", e);
            images = [];
        }
    }

    // Try to get fallback images from data attribute
    try {
        fallbackImages = JSON.parse(container.dataset.fallbackImages || "[]");
    } catch (e) {
        console.warn("Failed to parse fallback image data:", e);
        fallbackImages = [];
    }

    // Use database images first, then fallback images, then hardcoded data
    let dataToUse;
    if (images.length > 0) {
        dataToUse = images.map((src, index) => ({ id: index + 1, src }));
    } else if (fallbackImages.length > 0) {
        dataToUse = fallbackImages.map((src, index) => ({
            id: index + 1,
            src,
        }));
    } else {
        dataToUse = squareData;
    }

    const shuffled = shuffle(dataToUse);

    // Calculate grid layout based on image count
    const layout = calculateGridLayout(shuffled.length);

    // Update container classes for dynamic grid
    container.className = `grid h-[450px] gap-1 overflow-hidden rounded-xl grid-cols-${layout.cols} grid-rows-${layout.rows}`;

    container.innerHTML = "";
    shuffled.forEach((sq, i) => {
        const tile = document.createElement("div");
        tile.className =
            "rounded-md bg-slate-200/60 transition-opacity duration-700 ease-in-out opacity-0";
        tile.style.width = "100%";
        tile.style.height = "100%";
        tile.style.backgroundImage = `url(${sq.src})`;
        tile.style.backgroundSize = "cover";
        tile.style.backgroundPosition = "center";
        // Staggered fade-in
        setTimeout(() => tile.classList.remove("opacity-0"), i * 30);
        container.appendChild(tile);
    });
}

let shuffleTimeoutId = null;
function startShuffleLoop() {
    renderShuffleGrid();
    if (shuffleTimeoutId) clearTimeout(shuffleTimeoutId);
    shuffleTimeoutId = setTimeout(startShuffleLoop, 3000);
}

// Kick off after DOM ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", startShuffleLoop);
} else {
    startShuffleLoop();
}

// ==============================
// Count-up for Cultural Celebrations
// ==============================
function animateCount(el, target, suffix) {
    const durationMs = 1400;
    const start = 0;
    const startTime = performance.now();

    function tick(now) {
        const progress = Math.min(1, (now - startTime) / durationMs);
        const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
        const value = Math.round(start + (target - start) * eased);
        el.textContent = String(value) + (suffix || "");
        if (progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
}

function setupCountUps() {
    const metrics = document.querySelectorAll("#metrics-counts .countup");
    if (!metrics.length) return;

    let done = false;
    // Trigger when the floating card metrics container enters the viewport
    const section = document.getElementById("metrics-counts");
    const run = () => {
        if (done) return;
        metrics.forEach((el) => {
            const target = Number(el.getAttribute("data-target") || "0");
            const suffix = el.getAttribute("data-suffix") || "";
            animateCount(el, target, suffix);
        });
        done = true;
        observer.disconnect();
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) run();
            });
        },
        { root: null, threshold: 0.25 }
    );
    if (section) observer.observe(section);
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", setupCountUps);
} else {
    setupCountUps();
}
