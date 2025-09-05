@if(isset($advertisementsData) && !empty($advertisementsData['top']))
    <!-- Mobile Advertisement Banner -->
    <section id="advertisements-top-mobile" class="fixed top-0 left-0 right-0 z-40 bg-white border-b shadow-sm md:hidden">
        <div class="w-full px-2">
            <div class="py-2">
                @foreach($advertisementsData['top'] as $advertisement)
                    <div class="advertisement-item w-full">
                        @if($advertisement['link_url'])
                            <a href="{{ $advertisement['link_url'] }}" target="_blank" rel="noopener" class="block hover:opacity-90 transition-opacity w-full">
                                <img
                                    src="{{ $advertisement['image'] }}"
                                    alt="{{ $advertisement['title'] }}"
                                    class="w-full h-auto block rounded"
                                    style="height: 80px; object-fit: cover; object-position: center; width: 100%;"
                                >
                            </a>
                        @else
                            <img
                                src="{{ $advertisement['image'] }}"
                                alt="{{ $advertisement['title'] }}"
                                class="w-full h-auto block rounded"
                                style="height: 80px; object-fit: cover; object-position: center; width: 100%;"
                            >
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Desktop Advertisement Banner -->
    <section id="advertisements-top-desktop" class="fixed top-0 left-0 right-0 z-40 bg-white border-b shadow-sm hidden md:block">
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
                    nav.style.top = adHeight + 'px';

                    // Add padding to body to account for the advertisement
                    document.body.style.paddingTop = (adHeight + 80) + 'px'; // 80px for nav height
                }
            }

            // Initial layout update
            updateLayout();

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
                // Mobile: No scroll hide functionality (keep banner visible)
                if (isMobile) {
                    // Mobile keeps banner visible at all times
                    return;
                }

                // Desktop: Hide/show advertisement on scroll
                function handleScroll() {
                    const currentScrollY = window.scrollY;

                    if (currentScrollY > 100 && isAdVisible) {
                        // Hide advertisement when scrolling down
                        adSection.style.transform = 'translateY(-100%)';
                        adSection.style.transition = 'transform 0.3s ease-in-out';
                        nav.style.top = '0px';
                        nav.style.transition = 'top 0.3s ease-in-out';
                        document.body.style.paddingTop = '80px'; // Only nav height
                        isAdVisible = false;
                    } else if (currentScrollY <= 50 && !isAdVisible) {
                        // Show advertisement when scrolling back to top
                        adSection.style.transform = 'translateY(0)';
                        adSection.style.transition = 'transform 0.3s ease-in-out';
                        nav.style.top = adSection.offsetHeight + 'px';
                        nav.style.transition = 'top 0.3s ease-in-out';
                        document.body.style.paddingTop = (adSection.offsetHeight + 80) + 'px';
                        isAdVisible = true;
                    }

                    lastScrollY = currentScrollY;
                }

                // Throttle scroll events for better performance
                let ticking = false;
                function onScroll() {
                    if (!ticking) {
                        requestAnimationFrame(handleScroll);
                        ticking = true;
                    }
                }

                window.addEventListener('scroll', onScroll);

                // Reset ticking flag
                window.addEventListener('scroll', function() {
                    ticking = false;
                });
            }
        });
    </script>
@endif

@if(isset($advertisementsData) && !empty($advertisementsData['bottom']))
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
