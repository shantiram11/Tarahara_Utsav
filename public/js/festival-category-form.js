// Festival Category Form Handler
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll(
        'form[action*="festival-categories"]'
    );

    forms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            fetch(this.action, {
                method: this.method,
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Show success message
                        showAlert("success", data.message);

                        // Redirect if specified
                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        }
                    } else {
                        showAlert(
                            "danger",
                            data.message || "An error occurred"
                        );
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showAlert(
                        "danger",
                        "An error occurred while processing your request"
                    );
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        });
    });

    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll(".alert");
        existingAlerts.forEach((alert) => alert.remove());

        // Create new alert
        const alertDiv = document.createElement("div");
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert at the top of the form
        const form = document.querySelector(
            'form[action*="festival-categories"]'
        );
        if (form) {
            form.insertBefore(alertDiv, form.firstChild);
        }

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
