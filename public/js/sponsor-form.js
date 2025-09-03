document.addEventListener("DOMContentLoaded", function () {
    const sponsorForm = document.querySelector('form[action*="sponsors"]');

    if (sponsorForm) {
        sponsorForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.textContent = "Processing...";

            // Determine if this is create or update
            const isUpdate = this.method === "PUT";
            const url = this.action;

            fetch(url, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Show success message
                        showAlert("success", data.message);

                        // Redirect if provided
                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        }
                    } else {
                        // Show error message
                        showAlert("error", data.message || "An error occurred");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showAlert(
                        "error",
                        "An error occurred while processing the request"
                    );
                })
                .finally(() => {
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                });
        });
    }

    // Alert function
    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll(".alert");
        existingAlerts.forEach((alert) => alert.remove());

        // Create new alert
        const alertDiv = document.createElement("div");
        alertDiv.className = `alert alert-${
            type === "success" ? "success" : "danger"
        } alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert alert at the top of the form
        const form = document.querySelector('form[action*="sponsors"]');
        if (form) {
            form.parentNode.insertBefore(alertDiv, form);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }
});
