(function () {
    const form = document.getElementById("aboutForm");
    if (!form) return;

    const config = {
        targetW: Number(form.dataset.targetW || 1080),
        targetH: Number(form.dataset.targetH || 720),
    };

    let selectedImages = [];
    let fileQueue = [];
    let isProcessing = false;

    const input = document.getElementById("collageImagesInput");
    if (input) {
        input.addEventListener("change", function (e) {
            const files = Array.from(e.target.files || []);
            const error = document.getElementById("imagesError");

            if (error) error.style.display = "none";

            if (files.length) {
                files.forEach((file) => {
                    if (file.size > 2 * 1024 * 1024) {
                        if (error) {
                            error.textContent =
                                "Each file must be less than 2MB";
                            error.style.display = "block";
                        }
                        return;
                    }
                    if (!file.type.startsWith("image/")) {
                        if (error) {
                            error.textContent =
                                "Please select valid image files only";
                            error.style.display = "block";
                        }
                        return;
                    }
                    fileQueue.push(file);
                });
                if (!isProcessing) processNextFile();
            }
            input.value = "";
        });
    }

    function processNextFile() {
        if (fileQueue.length === 0) {
            isProcessing = false;
            return;
        }
        isProcessing = true;
        const file = fileQueue.shift();

        const img = new Image();
        const reader = new FileReader();
        reader.onload = function (ev) {
            img.onload = function () {
                if (
                    img.naturalWidth === config.targetW &&
                    img.naturalHeight === config.targetH
                ) {
                    addImageToSelection(file);
                    processNextFile();
                } else {
                    ImageCropper.openCropper(
                        file,
                        config.targetW,
                        config.targetH,
                        img.naturalWidth,
                        img.naturalHeight,
                        function (croppedFile) {
                            addImageToSelection(croppedFile);
                            processNextFile();
                        }
                    );
                }
            };
            img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    }

    function addImageToSelection(file) {
        const imageId =
            "img_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9);
        selectedImages.push({ id: imageId, file: file, name: file.name });
        displaySelectedImage(imageId, file);
        updateSelectedImagesCount();
    }

    function displaySelectedImage(imageId, file) {
        const container = document.getElementById("selectedImagesContainer");
        if (!container) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const imageCard = document.createElement("div");
            imageCard.className = "image-card";
            imageCard.id = imageId;

            const fileName =
                file.name.length > 20
                    ? file.name.substring(0, 17) + "..."
                    : file.name;

            imageCard.innerHTML = `
                <img src="${e.target.result}" alt="Selected image">
                <button type="button" class="remove-btn" onclick="removeSelectedImage('${imageId}')" title="Remove image">
                    <i class="ri-close-line"></i>
                </button>
                <div class="image-card-body">
                    <div class="image-card-title">${fileName}</div>
                    <div class="image-card-subtitle">
                        <i class="ri-check-line me-1"></i>${config.targetW} × ${config.targetH}
                    </div>
                </div>
            `;
            container.appendChild(imageCard);
        };
        reader.readAsDataURL(file);
    }

    function removeSelectedImage(imageId) {
        selectedImages = selectedImages.filter((img) => img.id !== imageId);
        const imageElement = document.getElementById(imageId);
        if (imageElement) imageElement.remove();
        updateSelectedImagesCount();
    }
    window.removeSelectedImage = removeSelectedImage;

    function updateSelectedImagesCount() {
        const container = document.getElementById("selectedImagesList");
        const imageContainer = document.getElementById(
            "selectedImagesContainer"
        );
        const countBadge = document.getElementById("imageCount");
        const count = selectedImages.length;

        if (!container || !imageContainer) return;

        if (count === 0) {
            container.style.display = "none";
            imageContainer.innerHTML = `
                <div class="empty-state">
                    <i class="ri-image-add-line"></i>
                    <h6>No images selected yet</h6>
                    <p>Choose files above to add images to your about section</p>
                </div>
            `;
            if (countBadge) countBadge.textContent = "0";
        } else {
            container.style.display = "block";
            if (countBadge) countBadge.textContent = count;
            const emptyState = imageContainer.querySelector(".empty-state");
            if (emptyState) emptyState.remove();
        }
    }

    // Form submission
    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            // Check if even number of images
            if (selectedImages.length % 2 !== 0) {
                const error = document.getElementById("imagesError");
                if (error) {
                    error.textContent =
                        "Please upload an even number of images.";
                    error.style.display = "block";
                }
                return;
            }

            // Add selected images to form
            const existingInputs = form.querySelectorAll(
                'input[name^="images"]'
            );
            existingInputs.forEach((input) => input.remove());

            selectedImages.forEach((imageData, index) => {
                const input = document.createElement("input");
                input.type = "file";
                input.name = `images[${index}]`;
                input.style.display = "none";

                const dt = new DataTransfer();
                dt.items.add(imageData.file);
                input.files = dt.files;

                form.appendChild(input);
            });

            form.submit();
        });
    }

    // Initialize
    document.addEventListener("DOMContentLoaded", function () {
        updateSelectedImagesCount();
    });
})();
