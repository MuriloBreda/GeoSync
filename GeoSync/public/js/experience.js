(() => {
    'use strict';
    const boot = () => {
        const reduced = matchMedia('(prefers-reduced-motion: reduce)');
        const desktopStory = matchMedia('(min-width: 900px) and (min-height: 700px)');
        const body = document.body;
        const navbar = document.querySelector('.navbar');
        const floatingTools = document.querySelector('.ferramentas-flutuantes-container');
        const backToTop = document.createElement('button');
        backToTop.type = 'button';
        backToTop.className = 'gs-back-to-top';
        backToTop.hidden = true;
        backToTop.title = 'Voltar ao topo';
        backToTop.setAttribute('aria-label', 'Voltar ao topo da página');
        backToTop.innerHTML = '<svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>';
        floatingTools?.prepend(backToTop);
        backToTop.addEventListener('click', () => {
            navbar?.querySelector('a')?.focus({ preventScroll: true });
            window.scrollTo({ top: 0, behavior: reduced.matches ? 'instant' : 'smooth' });
        });
        const progress = document.createElement('div');
        progress.className = 'gs-progress';
        progress.setAttribute('aria-hidden', 'true');
        if (!document.getElementById('scroll-progress')) body.append(progress);
        document.querySelectorAll('.menu a').forEach(link => {
            if (new URL(link.href).pathname === location.pathname) link.setAttribute('aria-current', 'page');
        });

        // The shared engine replaces the home page's older animation loop.
        document.querySelectorAll('.scroll-reveal').forEach(el => el.classList.add('visible'));
        const selectors = 'section:not(.hero):not(.hero-about):not(.planos-hero),.block-about,.about-card,.section-title,.section-title-center,.section-heading,.service-card,.mvv-card,.team-card,.stat-card,.plano-card,.comparativo,.feedback-card,.alert-card,.info-card,.card-feature,.faq-item,.diferenciais-conteudo,.diferenciais-imagem';
        // Animate only outermost targets to avoid compounding transforms on children.
        const cards = [...document.querySelectorAll(selectors)].filter(el => !el.parentElement.closest(selectors));
        const items = cards.map(el => {
            const index = [...el.parentElement.children].indexOf(el);
            let effect = index % 2 ? 'right' : 'left';
            if (el.matches('.about-card,.block-about,.diferenciais-imagem')) effect = 'image';
            if (el.matches('.team-card')) effect = 'team';
            if (el.matches('.section-title,.section-title-center,.section-heading')) effect = 'heading';
            if (el.matches('.plano-card')) effect = 'plan';
            if (el.matches('.feedback-card,.comparativo')) effect = 'panel';
            el.dataset.gsReveal = effect;
            el.style.setProperty('--gs-direction', index % 2 ? 1 : -1);
            return { el, index, top: 0, last: -1 };
        });
        const stories = [...document.querySelectorAll('.gs-story')];
        const hero = document.querySelector('.hero,.hero-about,.planos-hero');
        if (hero) {
            const cue = document.createElement('span');
            cue.className = 'gs-explore-cue';
            cue.setAttribute('aria-hidden', 'true');
            cue.textContent = 'Role para explorar ↓';
            hero.append(cue);
        }
        body.classList.toggle('gs-motion', !reduced.matches);
        const clamp = value => Math.max(0, Math.min(1, value));
        let pending = false;
        let needsMeasure = true;
        function measure() {
            // Read natural geometry, never transformed bounds: scroll progress stays stable.
            body.classList.add('gs-measuring');
            items.forEach(item => { item.top = item.el.getBoundingClientRect().top + scrollY; });
            body.classList.remove('gs-measuring');
            needsMeasure = false;
        }
        function update() {
            pending = false;
            if (needsMeasure) measure();
            const height = document.documentElement.scrollHeight - innerHeight;
            progress.style.scale = `${height > 0 ? clamp(scrollY / height) : 0} 1`;
            const oldProgress = document.getElementById('scroll-progress');
            if (oldProgress) oldProgress.style.transform = `scaleX(${height > 0 ? clamp(scrollY / height) : 0})`;
            navbar?.classList.toggle('scrolled', scrollY > 30);
            backToTop.hidden = scrollY < 300;
            items.forEach(item => {
                const stagger = innerWidth > 768 ? Math.min(item.index, 3) * innerHeight * .035 : 0;
                const p = reduced.matches ? 1 : clamp((innerHeight * .97 - (item.top - scrollY) - stagger) / (innerHeight * .42));
                if (p !== item.last) {
                    item.el.style.setProperty('--gs-build', p.toFixed(4));
                    item.last = p;
                }
            });
            if (hero) {
                const p = reduced.matches ? 0 : clamp(scrollY / Math.max(1, hero.offsetHeight));
                hero.style.setProperty('--gs-hero-scroll', p.toFixed(4));
            }
            stories.forEach(story => {
                const rect = story.getBoundingClientRect();
                const animated = !reduced.matches && desktopStory.matches;
                const p = reduced.matches ? 1 : animated
                    ? clamp((100 - rect.top) / Math.max(1, rect.height - innerHeight))
                    : clamp((innerHeight * .85 - rect.top) / Math.max(1, rect.height * .65));
                story.style.setProperty('--assembly', clamp(p * 3));
                story.style.setProperty('--route', clamp(p * 1.4));
                story.querySelectorAll('.gs-story-step').forEach((step, i) => {
                    step.style.setProperty('--step', clamp((p - i * .24) * 4));
                });
            });
        }
        const schedule = () => {
            if (!pending) { pending = true; requestAnimationFrame(update); }
        };
        addEventListener('scroll', schedule, { passive: true });
        const remeasure = () => { needsMeasure = true; schedule(); };
        addEventListener('resize', remeasure);
        addEventListener('load', remeasure, { once: true });
        document.fonts?.ready.then(remeasure);
        // Image loading, FAQ expansion and font-size preferences can move later sections.
        if ('ResizeObserver' in window) new ResizeObserver(remeasure).observe(body);
        reduced.addEventListener('change', () => {
            body.classList.toggle('gs-motion', !reduced.matches);
            remeasure();
        });
        // Keyboard focus must never land on an unrevealed control.
        document.addEventListener('focusin', event => event.target.closest('[data-gs-reveal]')?.classList.add('gs-visible'));
        const stars = [...document.querySelectorAll('#stars span')];
        stars.forEach((star, index) => {
            star.setAttribute('role', 'radio');
            star.setAttribute('aria-label', `${index + 1} ${index ? 'estrelas' : 'estrela'}`);
            star.setAttribute('aria-checked', 'false');
            star.tabIndex = index ? -1 : 0;
            star.addEventListener('click', () => stars.forEach(item => {
                item.setAttribute('aria-checked', String(item === star));
                item.tabIndex = item === star ? 0 : -1;
            }));
            star.addEventListener('keydown', event => {
                if (['ArrowRight','ArrowUp','ArrowLeft','ArrowDown','Home','End',' ','Enter'].includes(event.key)) {
                    event.preventDefault();
                    let next = index;
                    if (['ArrowRight','ArrowUp'].includes(event.key)) next = (index + 1) % stars.length;
                    if (['ArrowLeft','ArrowDown'].includes(event.key)) next = (index + stars.length - 1) % stars.length;
                    if (event.key === 'Home') next = 0;
                    if (event.key === 'End') next = stars.length - 1;
                    stars[next].click();
                    stars[next].focus();
                }
            });
        });
        update();
    };
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();
})();
