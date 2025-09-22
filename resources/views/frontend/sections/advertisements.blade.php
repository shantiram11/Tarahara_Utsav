@php
    $onlyPositions = $only ?? null;
    $shouldRender = function ($position) use ($onlyPositions) {
        return is_null($onlyPositions) || in_array($position, $onlyPositions);
    };
@endphp

@if($shouldRender('top') && isset($advertisementsData) && !empty($advertisementsData['top']))
    <style>
        /* Optimize advertisement animations for smooth performance */
        #advertisements-top-mobile,
        #advertisements-top-desktop {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        .advertisement-item img {
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
        }
    </style>

    <!-- Mobile Advertisement Banner -->
    <section id="advertisements-top-mobile" class="fixed top-0 left-0 right-0 z-40 bg-white border-b shadow-sm md:hidden transition-transform duration-300 ease-out will-change-transform">
        <div class="w-full px-2">
            <div class="py-3">
                @foreach($advertisementsData['top'] as $advertisement)
                    <div class="advertisement-item w-full">
                        @if($advertisement['link_url'])
                            <a href="{{ $advertisement['link_url'] }}" target="_blank" rel="noopener" class="block hover:opacity-90 transition-opacity w-full">
                                <img
                                    src="{{ $advertisement['image'] }}"
                                    alt="{{ $advertisement['title'] }}"
                                    class="w-full h-auto block rounded"
                                    style="max-height: 100px; min-height: 60px; object-fit: contain; object-position: center; width: 100%;"
                                >
                            </a>
                        @else
                            <img
                                src="{{ $advertisement['image'] }}"
                                alt="{{ $advertisement['title'] }}"
                                class="w-full h-auto block rounded"
                                style="max-height: 100px; min-height: 60px; object-fit: contain; object-position: center; width: 100%;"
                            >
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Desktop Advertisement Banner -->
    <section id="advertisements-top-desktop" class="fixed top-0 left-0 right-0 z-40 bg-white border-b shadow-sm hidden md:block transition-transform duration-300 ease-out will-change-transform">
        <div class="w-full px-0">
            <div class="py-1">
                @foreach($advertisementsData['top'] as $advertisement)
                    <div class="advertisement-item w-full" style="height: 80vh; max-height: 200px; min-height: 100px;">
                        @if($advertisement['link_url'])
                            <a href="{{ $advertisement['link_url'] }}" target="_blank" rel="noopener" class="block hover:opacity-90 transition-opacity w-full h-full">
                                <img
                                    src="{{ $advertisement['image'] }}"
                                    alt="{{ $advertisement['title'] }}"
                                    class="w-full h-full block"
                                    style="object-fit: contain; object-position: center;"
                                >
                            </a>
                        @else
                            <img
                                src="{{ $advertisement['image'] }}"
                                alt="{{ $advertisement['title'] }}"
                                class="w-full h-full block"
                                style="object-fit: contain; object-position: center;"
                            >
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on mobile or desktop
            const isMobile = window.innerWidth < 768;
            const adSection = isMobile ?
                document.getElementById('advertisements-top-mobile') :
                document.getElementById('advertisements-top-desktop');
            const nav = document.getElementById('main-nav');
            let isAdVisible = true;
            let lastScrollY = window.scrollY;

            function updateLayout() {
                if (adSection && nav) {
                    // Get actual height of advertisement section
                    const adHeight = adSection.offsetHeight;

                    // Set CSS custom properties for consistent positioning
                    document.documentElement.style.setProperty('--ad-height', adHeight + 'px');
                    document.documentElement.style.setProperty('--nav-top', isAdVisible ? adHeight + 'px' : '0px');
                    document.documentElement.style.setProperty('--body-padding', isAdVisible ? (adHeight + 80) + 'px' : '80px');

                    // Apply positioning
                    nav.style.top = isAdVisible ? adHeight + 'px' : '0px';
                    document.body.style.paddingTop = isAdVisible ? (adHeight + 80) + 'px' : '80px';
                }
            }

            // Initial layout update
            updateLayout();

            // Ensure proper initial positioning
            if (adSection && nav) {
                const adHeight = adSection.offsetHeight;
                nav.style.position = 'fixed';
                nav.style.top = adHeight + 'px';
                nav.style.left = '0';
                nav.style.right = '0';
                nav.style.zIndex = '50';
            }

            // Update layout on window resize
            window.addEventListener('resize', function() {
                const newIsMobile = window.innerWidth < 768;
                if (newIsMobile !== isMobile) {
                    // Reload page on breakpoint change for clean state
                    window.location.reload();
                } else {
                    updateLayout();
                }
            });

            if (adSection && nav) {
                // Optimized scroll handler for mobile performance
                function handleScroll() {
                    const currentScrollY = window.scrollY;
                    const hideThreshold = isMobile ? 80 : 100;
                    const showThreshold = isMobile ? 30 : 50;

                    // Only proceed if scroll position changed significantly
                    if (Math.abs(currentScrollY - lastScrollY) < 5) return;

                    if (currentScrollY > hideThreshold && isAdVisible) {
                        // Hide advertisement when scrolling down
                        adSection.style.transform = 'translate3d(0, -100%, 0)';
                        isAdVisible = false;

                        // Update layout after hiding
                        requestAnimationFrame(() => {
                            updateLayout();
                        });

                    } else if (currentScrollY <= showThreshold && !isAdVisible) {
                        // Show advertisement when scrolling back to top
                        adSection.style.transform = 'translate3d(0, 0, 0)';
                        isAdVisible = true;

                        // Update layout after showing
                        requestAnimationFrame(() => {
                            updateLayout();
                        });
                    }

                    lastScrollY = currentScrollY;
                }

                // Optimized scroll throttling for smooth performance
                let ticking = false;
                let lastScrollTime = 0;
                const scrollThrottle = isMobile ? 16 : 8; // 60fps for mobile, 120fps for desktop

                function onScroll() {
                    const now = performance.now();

                    if (!ticking && (now - lastScrollTime) >= scrollThrottle) {
                        requestAnimationFrame(() => {
                            handleScroll();
                            ticking = false;
                            lastScrollTime = now;
                        });
                        ticking = true;
                    }
                }

                window.addEventListener('scroll', onScroll, { passive: true });
            }
        });
    </script>
@endif

@if($shouldRender('below_hero') && isset($advertisementsData) && !empty($advertisementsData['below_hero']))
    <section id="advertisements-below-hero" class="w-full">
        <div class="w-full">
            <div class="py-4">
                @foreach($advertisementsData['below_hero'] as $advertisement)
                    <div class="advertisement-item mb-4 last:mb-0">
                        @if($advertisement['link_url'])
                            <a href="{{ $advertisement['link_url'] }}" target="_blank" rel="noopener" class="block hover:opacity-90 transition-opacity">
                                <img
                                    src="{{ $advertisement['image'] }}"
                                    alt="{{ $advertisement['title'] }}"
                                    class="w-full h-auto block"
                                    style="object-fit: contain; object-position: center; width: 100%;"
                                >
                            </a>
                        @else
                            <img
                                src="{{ $advertisement['image'] }}"
                                alt="{{ $advertisement['title'] }}"
                                class="w-full h-auto block"
                                style="object-fit: contain; object-position: center; width: 100%;"
                            >
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if($shouldRender('bottom') && isset($advertisementsData) && !empty($advertisementsData['bottom']))
    <section id="advertisements-bottom" class="bg-gray-50 border-t">
        <div class="mx-auto max-w-full px-2 sm:px-4 lg:px-6">
            <div class="py-4">
                @foreach($advertisementsData['bottom'] as $advertisement)
                    <div class="advertisement-item mb-4 last:mb-0">
                        @if($advertisement['link_url'])
                            <a href="{{ $advertisement['link_url'] }}" target="_blank" rel="noopener" class="block hover:opacity-90 transition-opacity">
                                <img
                                    src="{{ $advertisement['image'] }}"
                                    alt="{{ $advertisement['title'] }}"
                                    class="w-full h-auto rounded-lg shadow-sm mx-auto"
                                    style="object-fit: contain; object-position: center; width: 100%;"
                                >
                            </a>
                        @else
                            <img
                                src="{{ $advertisement['image'] }}"
                                alt="{{ $advertisement['title'] }}"
                                class="w-full h-auto rounded-lg shadow-sm mx-auto"
                                                                    style="object-fit: contain; object-position: center; width: 100%;"
                            >
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
