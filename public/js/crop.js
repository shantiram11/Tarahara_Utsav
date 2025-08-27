// Essential Image Cropping Utilities
window.ImageCropper = (function () {
    let cropper = null;
    let cropModalInstance = null;

    function openCropper(
        file,
        targetW,
        targetH,
        originalWidth,
        originalHeight,
        onCropComplete
    ) {
        const sizeEl = document.getElementById("originalSize");
        if (sizeEl)
            sizeEl.textContent = `${originalWidth} x ${originalHeight} pixels`;

        const modalEl = document.getElementById("cropModal");
        if (!modalEl) return;

        cropModalInstance = new bootstrap.Modal(modalEl);

        modalEl.addEventListener(
            "shown.bs.modal",
            function onShown() {
                modalEl.removeEventListener("shown.bs.modal", onShown);
                initializeCropper(file, targetW, targetH);
            },
            { once: true }
        );

        modalEl.addEventListener(
            "hidden.bs.modal",
            function onHidden() {
                modalEl.removeEventListener("hidden.bs.modal", onHidden);
                cleanupCropper();
            },
            { once: true }
        );

        const cropBtn = document.getElementById("cropButton");
        if (cropBtn) {
            cropBtn.onclick = function () {
                if (!cropper) return;

                const canvas = cropper.getCroppedCanvas({
                    width: targetW,
                    height: targetH,
                });

                canvas.toBlob(function (blob) {
                    const croppedFile = new File([blob], file.name, {
                        type: file.type,
                        lastModified: Date.now(),
                    });
                    cropModalInstance.hide();
                    if (onCropComplete) onCropComplete(croppedFile);
                }, file.type);
            };
        }

        cropModalInstance.show();
    }

    function initializeCropper(file, targetW, targetH) {
        const cropArea = document.getElementById("cropArea");
        if (!cropArea) return;

        cropArea.innerHTML = "";

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = "100%";
        img.style.maxHeight = "400px";
        cropArea.appendChild(img);

        cropper = new Cropper(img, {
            aspectRatio: targetW / targetH,
            viewMode: 1,
            dragMode: "move",
            autoCropArea: 1,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    }

    function cleanupCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        const cropArea = document.getElementById("cropArea");
        if (cropArea) cropArea.innerHTML = "";
    }

    // Public API
    return {
        openCropper: openCropper,
        cleanupCropper: cleanupCropper,
    };
})();
