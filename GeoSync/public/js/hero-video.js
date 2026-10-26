(() => {
    'use strict';
    const video = document.getElementById('hero-background-video');
    const button = document.querySelector('.hero-video-toggle');
    if (!video || !button) return;
    const reduced = matchMedia('(prefers-reduced-motion: reduce)');
    const connection = navigator.connection;
    let userPaused = false;
    let userStarted = false;
    let visible = true;
    let failed = false;
    button.hidden = false;
    const label = () => {
        button.textContent = video.paused ? 'Reproduzir vídeo de fundo' : 'Pausar vídeo de fundo';
    };
    async function sync() {
        const allowed = userStarted || (!reduced.matches && !connection?.saveData);
        if (failed || !allowed || userPaused || !visible || document.hidden) {
            video.pause();
            label();
            return;
        }
        if (!video.getAttribute('src')) video.src = video.dataset.src;
        video.muted = true;
        try { await video.play(); } catch { /* Keep the poster and the manual play control. */ }
        label();
    }
    button.addEventListener('click', () => {
        if (!video.paused) {
            userPaused = true;
            video.pause();
        } else {
            userPaused = false;
            userStarted = true;
            sync();
        }
        label();
    });
    video.addEventListener('play', label);
    video.addEventListener('pause', label);
    video.addEventListener('error', () => {
        failed = true;
        video.pause();
        video.hidden = true;
        button.hidden = true;
    });
    reduced.addEventListener('change', () => { userStarted = false; sync(); });
    connection?.addEventListener('change', sync);
    document.addEventListener('visibilitychange', sync);
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(entries => {
            visible = entries[0].isIntersecting;
            sync();
        }, { threshold: 0 }).observe(video.closest('.hero'));
    } else sync();
})();
