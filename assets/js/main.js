// Document ready function
document.addEventListener('DOMContentLoaded', function() {
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Auto-hide alerts after 5 seconds
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Focus on first input in forms
    var forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        var inputs = form.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], input[type="number"]');
        if (inputs.length > 0) {
            inputs[0].focus();
        }
    });
});

// Confirm before destructive actions
function confirmAction(message) {
    return confirm(message || 'Are you sure you want to perform this action?');
}
