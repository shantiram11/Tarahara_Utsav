<section class="bg-yellow-50 hero-section pb-8 sm:pb-12 lg:pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6 lg:space-y-8 order-1 lg:order-1">
                <!-- Hero Logo -->

                <div class="mb-4 lg:mb-6">

                    <img src="{{ asset('assets/home1.png') }}" alt="Tarahara Utsav Hero" class="h-12 sm:h-16 lg:h-40 w-68">

                </div>
                <!-- Description -->
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-lg">
                    From soulful music to savory bites, this festival is a colorful journey through community, creativity, and culture!
                </p>

                <!-- Event Details -->
                <div class="space-y-3 lg:space-y-4">
                    <!-- Date -->
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-red-600 font-semibold text-sm sm:text-base">December 15-17, 2024</span>
                    </div>

                    <!-- Location -->
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <span class="text-red-600 font-semibold text-sm sm:text-base">Central City park, Downtown</span>
                    </div>

                    <!-- Time -->
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-red-600 font-semibold text-sm sm:text-base">10:00 AM - 10:00 PM, daily</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <button class="bg-gray-400 hover:bg-gray-500 active:bg-gray-600 text-white font-semibold py-3 px-6 sm:px-8 rounded-lg transition-colors text-sm sm:text-base w-full sm:w-auto touch-manipulation">
                        Get ticket
                    </button>
                    <button class="border-2 border-gray-400 text-gray-700 hover:bg-gray-100 active:bg-gray-200 font-semibold py-3 px-6 sm:px-8 rounded-lg transition-colors text-sm sm:text-base w-full sm:w-auto touch-manipulation">
                        View program
                    </button>
                </div>
            </div>

            <!-- Right Content - Mobile Optimized Image Collage -->
            <div class="relative order-2 lg:order-2 mb-6 lg:mb-0">
                <!-- Main container with responsive arrow -->
            <div class="relative">
                    <!-- Arrow pointing to the collage - Hidden on mobile, visible on larger screens -->
                    <div class="absolute -left-6 lg:-left-8 top-1/2 transform -translate-y-1/2 z-30 hidden lg:block">
                        <div class="w-6 h-6 lg:w-8 lg:h-8 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Mobile Optimized Image Container -->
                    <div class="relative w-full h-[280px] sm:h-[400px] lg:h-[600px] flex items-center justify-center overflow-hidden">
                        <!-- Dynamic Background Image 1 - Mobile optimized positioning -->
                        <div class="absolute top-2 sm:top-8 left-1 sm:left-4 w-28 sm:w-40 lg:w-48 h-32 sm:h-50 lg:h-60 bg-image-1">
                            <img id="bg-image-1" src="{{ asset('assets/Live performance.png') }}" alt="Background Image" class="w-full h-full object-cover rounded-lg lg:rounded-xl shadow-md lg:shadow-lg opacity-25 sm:opacity-30 lg:opacity-40 transform rotate-3 sm:rotate-6 lg:rotate-12 bg-smooth-transition">
                        </div>

                        <!-- Dynamic Background Image 2 - Mobile optimized positioning -->
                        <div class="absolute bottom-2 sm:bottom-12 right-1 sm:right-8 w-24 sm:w-36 lg:w-44 h-28 sm:h-46 lg:h-56 bg-image-2">
                            <img id="bg-image-2" src="{{ asset('assets/food stalls.png') }}" alt="Background Image" class="w-full h-full object-cover rounded-lg lg:rounded-xl shadow-md lg:shadow-lg opacity-25 sm:opacity-30 lg:opacity-40 transform -rotate-2 sm:-rotate-4 lg:-rotate-8 bg-smooth-transition">
                        </div>

                        <!-- Dynamic Background Image 3 - Hidden on small mobile, visible on larger screens -->
                        <div class="absolute top-6 sm:top-16 right-4 sm:right-12 w-24 sm:w-32 lg:w-40 h-28 sm:h-42 lg:h-52 bg-image-3 hidden sm:block">
                            <img id="bg-image-3" src="{{ asset('assets/culture.png') }}" alt="Background Image" class="w-full h-full object-cover rounded-lg lg:rounded-xl shadow-md lg:shadow-lg opacity-20 lg:opacity-30 transform rotate-2 sm:rotate-3 lg:rotate-6 bg-smooth-transition">
                        </div>

                        <!-- Dynamic Background Image 4 - Hidden on small mobile, visible on larger screens -->
                        <div class="absolute bottom-2 sm:bottom-8 left-4 sm:left-12 w-24 sm:w-34 lg:w-42 h-24 sm:h-38 lg:h-48 bg-image-4 hidden sm:block">
                            <img id="bg-image-4" src="{{ asset('assets/art exhibation.jpg') }}" alt="Background Image" class="w-full h-full object-cover rounded-lg lg:rounded-xl shadow-md lg:shadow-lg opacity-20 lg:opacity-30 transform -rotate-4 sm:-rotate-8 lg:-rotate-15 bg-smooth-transition">
                </div>

                        <!-- Main Cycling Image - Mobile Optimized -->
                        <div class="main-image-container">
                            <img id="cycling-image" src="{{ asset('assets/art exhibation.jpg') }}" alt="Festival Image" class="max-w-full max-h-full w-auto h-auto rounded-xl lg:rounded-2xl shadow-xl lg:shadow-2xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.main-image-container {
    position: relative;
    z-index: 10;
    animation: gentleFloat 6s ease-in-out infinite;
    max-width: 220px;
    max-height: 320px;
}

/* Responsive main image sizing */
@media (min-width: 640px) {
    .main-image-container {
        max-width: 300px;
        max-height: 350px;
    }
}

@media (min-width: 1024px) {
    .main-image-container {
        max-width: 350px;
        max-height: 400px;
    }
}

/* Fine-tuned top spacing for hero beyond Tailwind steps */
.hero-section {
    padding-top: 5.5rem; /* 88px - between 4rem (64) and 6rem (96) */
}
@media (min-width: 640px) { /* sm */
    .hero-section { padding-top: 5.75rem; }
}
@media (min-width: 1024px) { /* lg */
    .hero-section { padding-top: 5.5rem; }
}

/* Dynamic background images */
.bg-image-1, .bg-image-2, .bg-image-3, .bg-image-4 {
    z-index: 1;
}

.main-image-container img {
    transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    backface-visibility: hidden;
    will-change: opacity;
}

/* Gentle floating animation - reduced on mobile */
@keyframes gentleFloat {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-4px);
    }
}

@media (min-width: 1024px) {
    @keyframes gentleFloat {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
    }
}

/* Smooth fade transitions */
.fade-out {
    opacity: 0 !important;
    transform: scale(0.98);
}

.fade-in {
    opacity: 1 !important;
    transform: scale(1);
}

/* Background image smooth transitions */
.bg-smooth-transition {
    transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), transform 0.6s ease-out;
}

/* Touch optimization */
.touch-manipulation {
    touch-action: manipulation;
}

/* Mobile-specific optimizations */
@media (max-width: 640px) {
    /* Reduce animation complexity on mobile for better performance */
    .main-image-container {
        animation: none;
    }

    /* Simplified shadows on mobile */
    .bg-image-1 img, .bg-image-2 img {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Removed global section min-height and safe-area padding to prevent large gaps between sections on mobile */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = [
        '{{ asset('assets/art exhibation.jpg') }}',
        '{{ asset('assets/Live performance.png') }}',
        '{{ asset('assets/food stalls.png') }}',
        '{{ asset('assets/culture.png') }}'
    ];

    const cyclingImage = document.getElementById('cycling-image');
    const bgImage1 = document.getElementById('bg-image-1');
    const bgImage2 = document.getElementById('bg-image-2');
    const bgImage3 = document.getElementById('bg-image-3');
    const bgImage4 = document.getElementById('bg-image-4');

    let currentImageIndex = 0;
    let backgroundImageIndex = 1; // Start with different index for background

    function updateBackgroundImages() {
        // Get different images for background (independent of main image)
        const bgIndices = [
            backgroundImageIndex % images.length,
            (backgroundImageIndex + 1) % images.length,
            (backgroundImageIndex + 2) % images.length,
            (backgroundImageIndex + 3) % images.length
        ];

        // Smooth fade out with slight scale
        [bgImage1, bgImage2, bgImage3, bgImage4].forEach((img, index) => {
            img.style.opacity = '0';
            img.style.transform = img.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(0.95)';
        });

        // After smooth fade out, update sources and fade in
        setTimeout(() => {
            bgImage1.src = images[bgIndices[0]];
            bgImage2.src = images[bgIndices[1]];
            bgImage3.src = images[bgIndices[2]];
            bgImage4.src = images[bgIndices[3]];

            // Smooth fade in with scale back to normal
            setTimeout(() => {
                bgImage1.style.opacity = '0.4';
                bgImage1.style.transform = bgImage1.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(1)';

                bgImage2.style.opacity = '0.4';
                bgImage2.style.transform = bgImage2.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(1)';

                bgImage3.style.opacity = '0.3';
                bgImage3.style.transform = bgImage3.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(1)';

                bgImage4.style.opacity = '0.2';
                bgImage4.style.transform = bgImage4.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(1)';
            }, 50);
        }, 400);

        // Move to next background set
        backgroundImageIndex = (backgroundImageIndex + 1) % images.length;
    }

    function changeMainImage() {
        // Smooth fade out current main image
        cyclingImage.classList.add('fade-out');

        // After fade out completes, change main image and fade in
        setTimeout(() => {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            cyclingImage.src = images[currentImageIndex];

            // Smooth fade in new main image
            cyclingImage.classList.remove('fade-out');
            cyclingImage.classList.add('fade-in');

            // Remove fade-in class after transition
            setTimeout(() => {
                cyclingImage.classList.remove('fade-in');
            }, 1200);
        }, 600);
    }

    // Initialize background images
    updateBackgroundImages();

    // Start independent cycling for main and background images
    setInterval(changeMainImage, 4500); // Change main image every 4.5 seconds
    setInterval(updateBackgroundImages, 3000); // Change background images every 3 seconds
});
</script>
