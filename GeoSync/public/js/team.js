(() => {
    'use strict';
    let opener = null;
    const dialogs = [...document.querySelectorAll('.gs-profile')];
    const close = dialog => { if (dialog.open) dialog.close(); };
    document.querySelectorAll('[data-team-dialog]').forEach(button => {
        button.addEventListener('click', () => {
            const dialog = document.getElementById(button.dataset.teamDialog);
            if (!dialog || dialog.open) return;
            opener = button;
            dialog.showModal();
            document.body.classList.add('gs-profile-open');
            dialog.scrollTop = 0;
        });
    });
    dialogs.forEach(dialog => {
        dialog.querySelector('.gs-profile-close').addEventListener('click', () => close(dialog));
        // Only close when both ends of the pointer gesture are on the backdrop.
        let startedOutside = false;
        const outside = event => {
            const r = dialog.getBoundingClientRect();
            return event.clientX < r.left || event.clientX > r.right || event.clientY < r.top || event.clientY > r.bottom;
        };
        dialog.addEventListener('pointerdown', event => { startedOutside = outside(event); });
        dialog.addEventListener('click', event => {
            if (startedOutside && outside(event)) close(dialog);
            startedOutside = false;
        });
        dialog.addEventListener('close', () => {
            document.body.classList.remove('gs-profile-open');
            opener?.focus({ preventScroll: true });
            opener = null;
        });
    });
})();
