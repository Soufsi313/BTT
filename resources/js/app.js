document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-icon-open');
    const closeIcon = document.getElementById('menu-icon-close');

    if (!menuButton || !mobileMenu || !openIcon || !closeIcon) {
        return;
    }

    menuButton.addEventListener('click', () => {
        const menuIsOpen = !mobileMenu.classList.contains('hidden');

        mobileMenu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        menuButton.setAttribute('aria-expanded', String(!menuIsOpen));

        menuButton.setAttribute(
            'aria-label',
            menuIsOpen ? 'Ouvrir le menu' : 'Fermer le menu'
        );
    });
});