document.addEventListener('DOMContentLoaded', function() {
    var salaryInput = document.getElementById('salary');
    Inputmask('currency', {
        prefix: '$',
        rightAlign: false,
        digits: 0
    }).mask(salaryInput);
});
