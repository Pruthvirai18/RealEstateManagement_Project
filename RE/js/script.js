// Function for form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    let isValid = true;

    // Check each required field in the form
    const requiredFields = form.querySelectorAll("[required]");
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            alert(`${field.name} is required.`);
            isValid = false;
            field.focus();
            return false;
        }
    });

    return isValid;
}

// Confirmation before deleting a record
function confirmDelete(url) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = url; // Proceed with delete action
    }
}

// Optional: Highlight input fields dynamically
document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            input.style.border = "2px solid #4CAF50"; // Highlight on focus
        });
        input.addEventListener("blur", () => {
            input.style.border = "1px solid #ccc"; // Remove highlight on blur
        });
    });
});
