(function () {
    const form = document.getElementById("heroForm");
    if (!form) return; // Not on a hero form page

    const config = {
        submitUrl: form.dataset.submitUrl || "",
        method: form.dataset.method || "POST",
        methodOverride: form.dataset.methodOverride || "",
        requireImages: (form.dataset.requireImages || "false") === "true",
        heroId: form.dataset.heroId || "",
        successRedirect: form.dataset.successRedirect || "",
        targetW: Number(form.dataset.targetW || form.dataset.targetw || 940),
        targetH: Number(form.dataset.targetH || form.dataset.targeth || 1328),
    };

    let selectedImages = [];
    let fileQueue = [];
    let currentFile = null;
    let isProcessing = false;

    const input = document.getElementById("collageImagesInput");
    if (input && input.addEventListener) {
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

            // Allow reselecting same files
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

    if (form && form.addEventListener) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            clearErrors();

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
                .then((response) => {
                    if (!response.ok)
                        throw new Error(
                            `HTTP error! status: ${response.status}`
                        );
                    const contentType = response.headers.get("content-type");
                    if (!contentType?.includes("application/json")) {
                        return response.text().then(() => {
                            throw new Error(
                                "Server returned HTML instead of JSON. Please check authentication."
                            );
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        showAlert("success", data.message || "Success");
                        if (config.successRedirect) {
                            setTimeout(() => {
                                window.location.href = config.successRedirect;
                            }, 1500);
                        }
                    } else {
                        if (data.errors) {
                            let errorMessages = [];
                            Object.keys(data.errors).forEach((field) => {
                                if (field === "images") {
                                    showFieldError(
                                        "imagesError",
                                        data.errors[field].join(", ")
                                    );
                                }
                                errorMessages.push(
                                    `${field}: ${data.errors[field].join(", ")}`
                                );
                            });
                            showAlert(
                                "danger",
                                "Validation errors: " +
                                    errorMessages.join(" | ")
                            );
                        } else if (data.redirect) {
                            showAlert(
                                "warning",
                                data.message || "Authentication required"
                            );
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 2000);
                        } else {
                            showAlert(
                                "danger",
                                data.message || "An error occurred"
                            );
                        }
                    }
                })
                .catch((error) => {
                    showAlert("danger", `Error: ${error.message}`);
                })
                .finally(() => {
                    if (submitBtn && spinner) {
                        submitBtn.disabled = false;
                        spinner.classList.add("d-none");
                    }
                });
        });
    }

    function validateForm() {
        let isValid = true;
        if (config.requireImages && selectedImages.length === 0) {
            showFieldError(
                "imagesError",
                "Please select at least one image for the hero section"
            );
            showAlert(
                "danger",
                "Please select at least one image before submitting"
            );
            isValid = false;
        }
        const description = document
            .getElementById("description")
            ?.value.trim();
        if (description && description.length > 1000) {
            showFieldError(
                "descriptionError",
                "Description must be less than 1000 characters"
            );
            isValid = false;
        }
        return isValid;
    }

    function clearErrors() {
        document.querySelectorAll(".invalid-feedback").forEach((error) => {
            error.style.display = "none";
            error.textContent = "";
        });
        document.querySelectorAll(".is-invalid").forEach((field) => {
            field.classList.remove("is-invalid");
        });
    }

    function showFieldError(fieldId, message) {
        const errorElement = document.getElementById(fieldId);
        if (errorElement) {
            const field = errorElement.previousElementSibling;
            errorElement.textContent = message;
            errorElement.style.display = "block";
            if (field) field.classList.add("is-invalid");
        }
    }

    function showAlert(type, message) {
        const alertContainer = document.getElementById("alert-container");
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        if (alertContainer) alertContainer.innerHTML = alertHtml;
        setTimeout(() => {
            const alert = alertContainer?.querySelector(".alert");
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    // Expose current-image removal for edit page
    window.removeCurrentImage = function (heroId, imageIndex) {
        if (!confirm("Are you sure you want to remove this image?")) {
            return;
        }

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
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        })
            .then((response) => {
                if (!response.ok)
                    throw new Error(`HTTP error! status: ${response.status}`);
                const contentType = response.headers.get("content-type");
                if (!contentType?.includes("application/json")) {
                    return response.text().then(() => {
                        throw new Error(
                            "Server returned HTML instead of JSON. Please check authentication."
                        );
                    });
                }
                return response.json();
            })
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
                            if (badge) {
                                badge.textContent = data.remaining_images;
                            }
                            if (data.remaining_images === 0) {
                                const currentImagesSection =
                                    document.querySelector(
                                        ".mt-3:has(.current-images-grid)"
                                    );
                                if (currentImagesSection) {
                                    currentImagesSection.remove();
                                }
                            }
                        }, 300);
                    }
                    showAlert("success", data.message || "Removed");
                } else {
                    showAlert("danger", data.message || "Error removing image");
                    if (removeBtn) {
                        removeBtn.disabled = false;
                        removeBtn.innerHTML = '<i class="ri-close-line"></i>';
                    }
                }
            })
            .catch((error) => {
                showAlert("danger", `Error: ${error.message}`);
                if (removeBtn) {
                    removeBtn.disabled = false;
                    removeBtn.innerHTML = '<i class="ri-close-line"></i>';
                }
            });
    };

    // Initial UI state
    if (document.addEventListener) {
        document.addEventListener("DOMContentLoaded", function () {
            updateSelectedImagesCount();
        });
    }
})();
