import "./bootstrap";
// =================
// Header interactions
// =================
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
// Mobile menu toggle
const mobileMenuButton = document.getElementById("mobileMenuButton");
const mobileMenu = document.getElementById("mobileMenu");

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });

    // Hide menu when clicking a link
    mobileMenu.querySelectorAll("a").forEach((anchor) => {
        anchor.addEventListener("click", () =>
            mobileMenu.classList.add("hidden")
        );
    });
}

// Smooth scrolling for all anchor links with hashes to sections on the same page
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
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

// Sticky header shadow on scroll
const header = document.querySelector("header");
const addShadowOnScroll = () => {
    if (!header) return;
    const scrolled = window.scrollY > 2;
    header.classList.toggle("shadow", scrolled);
    header.classList.toggle("shadow-soft", scrolled);
};

addShadowOnScroll();
window.addEventListener("scroll", addShadowOnScroll);

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
    if (!placeholders.length) return;
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
    // After includes are injected, initialize header interactions and reveal
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

    // Mobile menu wiring (match Blade ids)
    const mmBtn = document.getElementById("mobile-menu-button");
    const mm = document.getElementById("mobile-menu");
    if (mmBtn && mm && !mmBtn.dataset.bound) {
        mmBtn.addEventListener("click", toggleMobileMenu);
        mm.querySelectorAll("a").forEach((a) =>
            a.addEventListener("click", () => {
                if (!mm.classList.contains("opacity-0")) toggleMobileMenu();
            })
        );
        mmBtn.dataset.bound = "true";
    }

    // Desktop active indicator + click smooth scroll with header offset
    const links = Array.from(
        document.querySelectorAll(".desktop-nav .nav-link")
    );
    const activeClasses = ["text-red-600", "bg-red-50", "font-semibold"];

    const applyActive = (matchHref) => {
        links.forEach((a) => {
            const indicator = a.querySelector(".active-indicator");
            const target = a.getAttribute("href");
            const isActive =
                target === matchHref ||
                (!matchHref &&
                    target ===
                        "" +
                            (typeof route === "function"
                                ? route("home")
                                : "")) ||
                (!matchHref && target === document.location.pathname);
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

const activeClass = ["text-amber-600", "font-semibold"];
const sections = Array.from(linkMap.keys())
    .map((id) => document.getElementById(id))
    .filter(Boolean);

const updateActive = (id) => {
    navLinks.forEach((l) => l.classList.remove(...activeClass));
    const link = linkMap.get(id);
    if (link) link.classList.add(...activeClass);
};

if (sections.length) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) updateActive(entry.target.id);
            });
        },
        {
            rootMargin: "-40% 0px -50% 0px",
            threshold: [0, 0.25, 0.5, 0.75, 1],
        }
    );
    sections.forEach((section) => observer.observe(section));
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

function renderShuffleGrid() {
    const container = document.getElementById("shuffle-grid");
    if (!container) return;

    const shuffled = shuffle(squareData);
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
// Auto sliding hero (crossfade)
// ==============================
const heroSlides = [
    {
        title: "Celebrate Culture, Food, Art and Community",
        caption:
            "A three-day cultural fair featuring music, dance, workshops, and authentic cuisines — bringing communities together.",
        src: "https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=2070&auto=format&fit=crop",
    },
    {
        title: "Vibrant Parades and Live Performances",
        caption:
            "Experience colorful processions, traditional costumes, and captivating music from diverse cultures.",
        src: "https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop",
    },
    {
        title: "Taste Authentic Cuisines",
        caption:
            "Savor dishes from local chefs and global flavors at our curated food stalls and shows.",
        src: "https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?q=80&w=2069&auto=format&fit=crop",
    },
];

let heroIndex = 0;
let heroTimerId = null;

function mountHeroSlides() {
    const container = document.getElementById("hero-slider");
    if (!container) return;

    container.innerHTML = "";
    heroSlides.forEach((slide, i) => {
        const el = document.createElement("div");
        el.className =
            "absolute inset-0 opacity-0 transition-opacity duration-[1200ms] ease-out will-change-opacity";
        el.style.backgroundImage = `url(${slide.src})`;
        el.style.backgroundSize = "cover";
        el.style.backgroundPosition = "center";
        el.setAttribute("data-idx", String(i));
        container.appendChild(el);
    });

    // Dots
    const dots = document.getElementById("hero-dots");
    if (dots) {
        dots.innerHTML = "";
        heroSlides.forEach((_, i) => {
            const dot = document.createElement("button");
            dot.className =
                "h-2.5 w-2.5 rounded-full bg-white/50 hover:bg-white/80 transition-colors";
            dot.addEventListener("click", () => showHeroSlide(i, true));
            dots.appendChild(dot);
        });
    }

    showHeroSlide(0, false);
    startHeroTimer();
}

function showHeroSlide(index, userTriggered) {
    const container = document.getElementById("hero-slider");
    if (!container) return;

    const slides = Array.from(container.children);
    slides.forEach((s) => s.classList.add("opacity-0"));
    const active = slides[index];
    if (active) active.classList.remove("opacity-0");

    // Update copy
    const titleEl = document.getElementById("hero-title");
    const captionEl = document.getElementById("hero-caption");
    if (titleEl && captionEl) {
        titleEl.textContent = heroSlides[index].title;
        captionEl.textContent = heroSlides[index].caption;
    }

    // Update dots
    const dots = document.getElementById("hero-dots");
    if (dots) {
        Array.from(dots.children).forEach((d, i) => {
            d.classList.toggle("bg-white", i === index);
            d.classList.toggle("bg-white/50", i !== index);
            d.classList.toggle("h-3", i === index);
            d.classList.toggle("w-3", i === index);
        });
    }

    heroIndex = index;
    if (userTriggered) startHeroTimer();
}

function startHeroTimer() {
    if (heroTimerId) clearInterval(heroTimerId);
    heroTimerId = setInterval(() => {
        const next = (heroIndex + 1) % heroSlides.length;
        showHeroSlide(next, false);
    }, 5000);
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", mountHeroSlides);
} else {
    mountHeroSlides();
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
