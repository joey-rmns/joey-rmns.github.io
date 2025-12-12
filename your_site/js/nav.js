
function toggleMenu() {
    const nav = document.getElementById('main-nav');
    if (nav) {
        nav.classList.toggle('responsive');
    } else {
        console.warn('Navigation element with ID "main-nav" not found.');
    }
}

function setNav(currentPath) {
    const navLinks = document.querySelectorAll('#main-nav a');

    navLinks.forEach(link => {
        const linkFilename = link.getAttribute('href');

        if (linkFilename) {
            if (currentPath.endsWith(linkFilename)) {
                link.classList.add('current_page');
            } else {
                link.classList.remove('current_page');
            }
        }
    });
}


document.addEventListener('DOMContentLoaded', () => {
    if (typeof setNav === 'function' && !window.setNavCalledByPHP) {
        const current_path = location.pathname;
        setNav(current_path);
    }
});