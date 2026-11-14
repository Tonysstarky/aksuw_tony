/* ==========================================================================
   AK SUW — animasiýa gatlagy (kitaphanasyz)
   1) Sahypa geçişi: suw aşakdan göterilip ekrany ýapýar, täze sahypada ýokary gidýär
   2) Aşak aýlananda kartalar suwdan çykan ýaly peýda bolýar
   3) Kartalar 3D egrelýär (myska görä) we aýna ýalpyldysy bar
   4) Köpükler (fon), tegelek tolkun (basanyňda), şarlar parallax
   ========================================================================== */
(function () {
    'use strict';
    var root = document.documentElement;
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var wt = document.getElementById('wt');
    var DUR = 650;

    // ───── 1) Sahypa geçişi ─────
    function drain() {
        if (!wt) return;
        wt.classList.add('wt-out');                  // ýokary gidýär
        root.classList.remove('wt-cover');
        setTimeout(function () { wt.classList.remove('wt-out'); wt.classList.add('wt-idle'); }, DUR + 500);
    }
    function cover(done) {
        if (!wt || reduce) { done(); return; }
        wt.classList.remove('wt-out', 'wt-idle');
        void wt.offsetWidth;
        wt.classList.add('wt-go');
        setTimeout(done, DUR);
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', drain); else drain();
    window.addEventListener('pageshow', function (e) { if (e.persisted && wt) { wt.classList.remove('wt-go'); wt.classList.add('wt-idle'); } });

    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        var a = e.target.closest && e.target.closest('a[href]');
        if (!a || a.target === '_blank' || a.hasAttribute('download') || a.hasAttribute('data-no-wt')) return;
        var u; try { u = new URL(a.href, location.href); } catch (_) { return; }
        if (u.origin !== location.origin || (u.pathname === location.pathname && u.search === location.search)) return;
        e.preventDefault();
        cover(function () { location.href = u.href; });
    });
    document.addEventListener('submit', function (e) {
        var f = e.target;
        if (e.defaultPrevented || f.hasAttribute('data-no-wt') || reduce) return;
        e.preventDefault();
        if (e.submitter && e.submitter.name) {
            var h = document.createElement('input'); h.type = 'hidden'; h.name = e.submitter.name; h.value = e.submitter.value; f.appendChild(h);
        }
        cover(function () { HTMLFormElement.prototype.submit.call(f); });
    });

    if (reduce) return;

    // ───── 2) Suwdan çykýan kartalar ─────
    var sel = '.stat, .factory-card, .card, .head, .glass:not(.nav-inner):not(.hero), .glass-soft:not(.alert)';
    var items = Array.prototype.slice.call(document.querySelectorAll('main ' + sel)).filter(function (el) {
        return !el.closest('.hero') && !el.closest('.navbar');
    });
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (en) {
            en.forEach(function (x) {
                if (!x.isIntersecting) return;
                var el = x.target, sib = Array.prototype.indexOf.call(el.parentNode.children, el);
                el.style.transitionDelay = Math.min(sib, 8) * 70 + 'ms';
                el.classList.add('rv-in');
                io.unobserve(el);
                setTimeout(function () { el.style.transitionDelay = ''; el.classList.remove('rv', 'rv-in'); }, 1300 + sib * 70);
            });
        }, { threshold: .12, rootMargin: '0px 0px -6% 0px' });
        items.forEach(function (el) { el.classList.add('rv'); io.observe(el); });
    }

    // ───── 3) Kartalaryň 3D egrelmesi ─────
    var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    if (fine) {
        document.querySelectorAll('main .card, main .factory-card, main .stat').forEach(function (el) {
            el.classList.add('tilt');
            var raf = 0;
            el.addEventListener('pointermove', function (e) {
                var r = el.getBoundingClientRect(), x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
                cancelAnimationFrame(raf);
                raf = requestAnimationFrame(function () {
                    el.style.transition = 'transform .08s linear, box-shadow .3s';
                    el.style.transform = 'perspective(800px) rotateX(' + ((.5 - y) * 12).toFixed(2) + 'deg) rotateY(' + ((x - .5) * 14).toFixed(2) + 'deg) translateY(-6px) scale(1.02)';
                    el.style.setProperty('--mx', (x * 100).toFixed(1) + '%'); el.style.setProperty('--my', (y * 100).toFixed(1) + '%');
                });
            });
            el.addEventListener('pointerleave', function () {
                cancelAnimationFrame(raf);
                el.style.transition = 'transform .6s cubic-bezier(.16,1,.3,1), box-shadow .3s';
                el.style.transform = '';
            });
        });
    }

    // ───── 4) Tegelek tolkun (basanyňda) ─────
    document.addEventListener('pointerdown', function (e) {
        var r = document.createElement('span'); r.className = 'tap-ripple';
        r.style.left = e.clientX + 'px'; r.style.top = e.clientY + 'px';
        document.body.appendChild(r); setTimeout(function () { r.remove(); }, 800);
    }, { passive: true });

    // ───── 5) Fon köpükleri we şarlaryň parallaxy ─────
    var cv = document.getElementById('bubbles');
    var orbs = Array.prototype.slice.call(document.querySelectorAll('.orb'));
    var sy = 0, vel = 0, lastSy = 0;
    window.addEventListener('scroll', function () { sy = window.scrollY; }, { passive: true });
    if (cv) {
        var c = cv.getContext('2d'), dpr = Math.min(window.devicePixelRatio || 1, 2), bs = [], N = window.innerWidth < 760 ? 14 : 30, w = 0, h = 0;
        function size() { w = cv.width = window.innerWidth * dpr; h = cv.height = window.innerHeight * dpr; }
        size(); window.addEventListener('resize', size);
        for (var i = 0; i < N; i++) bs.push({ x: Math.random(), y: Math.random(), r: 2 + Math.random() * 7, s: .0004 + Math.random() * .0012, p: Math.random() * 6 });
        var t0 = performance.now(), on = true;
        document.addEventListener('visibilitychange', function () { on = !document.hidden; if (on) requestAnimationFrame(loop); });
        (function loop(now) {
            if (!on) return;
            var t = (now - t0) / 1000; vel += ((sy - lastSy) - vel) * .1; lastSy = sy;
            c.clearRect(0, 0, w, h);
            bs.forEach(function (b) {
                b.y -= b.s * (1 + Math.min(Math.abs(vel) * .15, 4)); if (b.y < -.05) { b.y = 1.05; b.x = Math.random(); }
                var x = (b.x + Math.sin(t * .8 + b.p) * .012) * w, y = b.y * h, r = b.r * dpr;
                var g = c.createRadialGradient(x - r * .35, y - r * .35, r * .1, x, y, r);
                g.addColorStop(0, 'rgba(255,255,255,.55)'); g.addColorStop(.6, 'rgba(150,200,255,.12)'); g.addColorStop(1, 'rgba(150,200,255,.28)');
                c.fillStyle = g; c.beginPath(); c.arc(x, y, r, 0, 7); c.fill();
            });
            orbs.forEach(function (o, k) { o.style.translate = '0 ' + (-sy * (.05 + k * .03)).toFixed(1) + 'px'; });
            requestAnimationFrame(loop);
        })(t0);
    }
})();
