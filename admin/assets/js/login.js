document.addEventListener('DOMContentLoaded', () => {
    const identifierInput = document.getElementById('identifier');
    const passwordInput = document.getElementById('password');
    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
        if (!identifierInput.value.trim() || !passwordInput.value.trim()) {
            alert('Please fill in all fields.');
            e.preventDefault();
        }
    });
});
