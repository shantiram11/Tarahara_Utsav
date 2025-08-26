@php
    // Hero data is now passed from FrontendController
    $hasImages = $heroData['hasImages'] ?? false;
    $description = $heroData['description'] ?? 'From soulful music to savory bites, this festival is a colorful journey through community, creativity, and culture!';
    $images = $heroData['images'] ?? [];
    $fallbackImages = $heroData['fallbackImages'] ?? [];
@endphp

<section id="hero" class="bg-yellow-50 hero-section pb-8 sm:pb-12 lg:pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">
            <!-- Left Content -->
            <div class="space-y-6 lg:space-y-8 order-1 lg:order-1">
                <!-- Hero Logo -->
                <div class="mb-4 lg:mb-6">
                    <img src="{{ asset('assets/2025_logo_hero.png') }}" alt="Tarahara Utsav Hero" class="h-12 sm:h-16 lg:h-40 w-68">
                </div>

                <!-- Description -->
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-lg">{{ $description }}</p>

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
                </div>
            </div>

            <!-- Right Content - Image Collage -->
            <div class="relative order-2 lg:order-2 mb-6 lg:mb-0">
                <!-- Arrow pointing to collage -->
                <div class="absolute -left-6 lg:-left-8 top-1/2 transform -translate-y-1/2 z-30 hidden lg:block">
                    <div class="w-6 h-6 lg:w-8 lg:h-8 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Image Container -->
                <div class="relative w-full h-[380px] sm:h-[400px] lg:h-[600px] flex items-center justify-center overflow-hidden">
                    <!-- Background Images -->
                    <div class="absolute top-2 sm:top-8 left-1 sm:left-4 w-28 sm:w-40 lg:w-48 h-32 sm:h-50 lg:h-60 bg-image-1">
                        <img id="bg-image-1" src="{{ $hasImages ? $images[0] : $fallbackImages[1] }}" alt="Background Image" class="bg-image">
                    </div>

                    <div class="absolute bottom-2 sm:bottom-12 right-1 sm:right-8 w-24 sm:w-36 lg:w-44 h-28 sm:h-46 lg:h-56 bg-image-2">
                        <img id="bg-image-2" src="{{ $hasImages ? $images[1] : $fallbackImages[2] }}" alt="Background Image" class="bg-image">
                    </div>

                    <div class="absolute top-6 sm:top-16 right-4 sm:right-12 w-24 sm:w-32 lg:w-40 h-28 sm:h-42 lg:h-52 bg-image-3 hidden sm:block">
                        <img id="bg-image-3" src="{{ $hasImages ? $images[2] : $fallbackImages[3] }}" alt="Background Image" class="bg-image">
                    </div>

                    <div class="absolute bottom-2 sm:bottom-8 left-4 sm:left-12 w-24 sm:w-34 lg:w-42 h-24 sm:h-38 lg:h-48 bg-image-4 hidden sm:block">
                        <img id="bg-image-4" src="{{ $hasImages ? $images[3] : $fallbackImages[0] }}" alt="Background Image" class="bg-image">
                    </div>

                    <!-- Main Image -->
                    <div class="main-image-container">
                        <img id="cycling-image" src="{{ $hasImages ? $images[0] : $fallbackImages[0] }}" alt="Festival Image" class="main-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.hero-section {
    padding-top: 5.5rem;
}

@media (min-width: 640px) {
    .hero-section { padding-top: 5.75rem; }
}

@media (min-width: 1024px) {
    .hero-section { padding-top: 5.5rem; }
}

/* Main Image Container */
.main-image-container {
    position: relative;
    z-index: 10;
    max-width: 260px;
    max-height: 360px;
    animation: gentleFloat 6s ease-in-out infinite;
}

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

/* Image Styling */
.bg-image, .main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    backface-visibility: hidden;
    will-change: opacity, transform;
}

.bg-image {
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    opacity: 0.3;
}

.main-image {
    border-radius: 0.75rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

@media (min-width: 1024px) {
    .bg-image {
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .main-image {
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
}

/* Background Image Positions */
.bg-image-1 img { transform: rotate(3deg); }
.bg-image-2 img { transform: rotate(-2deg); }
.bg-image-3 img { transform: rotate(2deg); }
.bg-image-4 img { transform: rotate(-4deg); }

@media (min-width: 640px) {
    .bg-image-1 img { transform: rotate(6deg); }
    .bg-image-2 img { transform: rotate(-4deg); }
    .bg-image-3 img { transform: rotate(3deg); }
    .bg-image-4 img { transform: rotate(-8deg); }
}

@media (min-width: 1024px) {
    .bg-image-1 img { transform: rotate(12deg); }
    .bg-image-2 img { transform: rotate(-8deg); }
    .bg-image-3 img { transform: rotate(6deg); }
    .bg-image-4 img { transform: rotate(-15deg); }
}

/* Animations */
@keyframes gentleFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-4px); }
}

@media (min-width: 1024px) {
    @keyframes gentleFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }
}

/* Transitions */
.fade-out { opacity: 0 !important; transform: scale(0.98); }
.fade-in { opacity: 1 !important; transform: scale(1); }

/* Mobile Optimizations */
@media (max-width: 640px) {
    .main-image-container { animation: none; }
}

/* Touch Optimization */
.touch-manipulation { touch-action: manipulation; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = @json($hasImages ? $images : $fallbackImages);
    const cyclingImage = document.getElementById('cycling-image');
    const bgImages = [
        document.getElementById('bg-image-1'),
        document.getElementById('bg-image-2'),
        document.getElementById('bg-image-3'),
        document.getElementById('bg-image-4')
    ];

    let currentIndex = 0;
    let bgIndex = 1;

    // Update background images
    function updateBackgrounds() {
        const indices = [
            bgIndex % images.length,
            (bgIndex + 1) % images.length,
            (bgIndex + 2) % images.length,
            (bgIndex + 3) % images.length
        ];

        // Fade out
        bgImages.forEach(img => {
            img.style.opacity = '0';
            img.style.transform = img.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(0.95)';
        });

        // Update sources and fade in
        setTimeout(() => {
            bgImages.forEach((img, i) => {
                img.src = images[indices[i]];
                setTimeout(() => {
                    img.style.opacity = '0.3';
                    img.style.transform = img.style.transform.replace(/scale\([^)]*\)/, '') + ' scale(1)';
                }, i * 50);
            });
        }, 400);

        bgIndex = (bgIndex + 1) % images.length;
    }

    // Change main image
    function changeMainImage() {
        cyclingImage.classList.add('fade-out');

        setTimeout(() => {
            currentIndex = (currentIndex + 1) % images.length;
            cyclingImage.src = images[currentIndex];
            cyclingImage.classList.remove('fade-out');
            cyclingImage.classList.add('fade-in');

            setTimeout(() => cyclingImage.classList.remove('fade-in'), 1200);
        }, 600);
    }

    // Initialize and start cycling
    updateBackgrounds();
    setInterval(changeMainImage, 4500);
    setInterval(updateBackgrounds, 3000);
});
</script>
