(() => {
    'use strict';

    const video = document.getElementById('hero-background-video');
    if (!video) return;

    let visible = true;
    let failed = false;

    async function playWhenReady() {
        if (failed || !visible || document.hidden) {
            video.pause();
            return;
        }

        if (!video.getAttribute('src')) video.src = video.dataset.src;
        video.muted = true;
        try {
            await video.play();
        } catch {
            // Browsers may block autoplay; the muted inline video retries when visible.
        }
    }

    video.addEventListener('error', () => {
        failed = true;
        video.pause();
    });
    document.addEventListener('visibilitychange', playWhenReady);

    if ('IntersectionObserver' in window) {
        new IntersectionObserver(entries => {
            visible = entries[0].isIntersecting;
            playWhenReady();
        }, { threshold: 0 }).observe(video.closest('.hero'));
    } else {
        playWhenReady();
    }
})();
