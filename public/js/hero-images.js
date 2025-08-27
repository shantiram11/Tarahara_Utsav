(function () {
    const form = document.getElementById("heroForm");
    if (!form) return;

    const config = {
        submitUrl: form.dataset.submitUrl || "",
        method: form.dataset.method || "POST",
        methodOverride: form.dataset.methodOverride || "",
        requireImages: (form.dataset.requireImages || "false") === "true",
        targetW: Number(form.dataset.targetW || 940),
        targetH: Number(form.dataset.targetH || 1328),
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
                    <p>Choose files above to add images to your hero section</p>
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
            if (!validateForm()) return;

            const formData = new FormData();
            formData.append(
                "_token",
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || ""
            );
            if (config.methodOverride)
                formData.append("_method", config.methodOverride);

            const description = document
                .getElementById("description")
                ?.value.trim();
            if (description) formData.append("description", description);

            selectedImages.forEach((imageData, index) => {
                formData.append(`images[${index}]`, imageData.file);
            });

            submitForm(formData);
        });
    }

    function validateForm() {
        if (config.requireImages && selectedImages.length === 0) {
            showFieldError(
                "imagesError",
                "Please select at least one image for the hero section"
            );
            return false;
        }
        return true;
    }

    function showFieldError(fieldId, message) {
        const errorElement = document.getElementById(fieldId);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = "block";
        }
    }

    function submitForm(formData) {
        const submitBtn = document.getElementById("submitBtn");
        const spinner = document.getElementById("submitSpinner");

        if (submitBtn && spinner) {
            submitBtn.disabled = true;
            spinner.classList.remove("d-none");
        }

        fetch(config.submitUrl, {
            method: config.method || "POST",
            body: formData,
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach((field) => {
                            if (field === "images") {
                                showFieldError(
                                    "imagesError",
                                    data.errors[field].join(", ")
                                );
                            }
                        });
                    }
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            })
            .finally(() => {
                if (submitBtn && spinner) {
                    submitBtn.disabled = false;
                    spinner.classList.add("d-none");
                }
            });
    }

    // Current image removal for edit page
    window.removeCurrentImage = function (heroId, imageIndex) {
        if (!confirm("Are you sure you want to remove this image?")) return;

        const imageCard = document.getElementById(
            `current-image-${imageIndex}`
        );
        const removeBtn = imageCard?.querySelector(".current-image-remove-btn");

        if (removeBtn) {
            removeBtn.disabled = true;
            removeBtn.innerHTML =
                '<div class="spinner-border spinner-border-sm" role="status"></div>';
        }

        fetch(`/admin/heroes/${heroId}/images/${imageIndex}`, {
            method: "DELETE",
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    if (imageCard) {
                        imageCard.style.transition = "all 0.3s ease";
                        imageCard.style.opacity = "0";
                        imageCard.style.transform = "scale(0.8)";
                        setTimeout(() => {
                            imageCard.remove();
                            const badge =
                                document.querySelector(".badge.bg-warning");
                            if (badge)
                                badge.textContent = data.remaining_images;
                            if (data.remaining_images === 0) {
                                const currentImagesSection =
                                    document.querySelector(
                                        ".mt-3:has(.current-images-grid)"
                                    );
                                if (currentImagesSection)
                                    currentImagesSection.remove();
                            }
                        }, 300);
                    }
                } else {
                    if (removeBtn) {
                        removeBtn.disabled = false;
                        removeBtn.innerHTML = '<i class="ri-close-line"></i>';
                    }
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                if (removeBtn) {
                    removeBtn.disabled = false;
                    removeBtn.innerHTML = '<i class="ri-close-line"></i>';
                }
            });
    };

    // Initialize
    document.addEventListener("DOMContentLoaded", function () {
        updateSelectedImagesCount();
    });
})();
