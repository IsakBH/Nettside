const icons = document.querySelectorAll('.sidebar-application-icon');
const iframe = document.getElementById('content-iframe');

icons.forEach(icon => {
    icon.addEventListener('click', () => {
        iframe.src = icon.dataset.url;
    });
});