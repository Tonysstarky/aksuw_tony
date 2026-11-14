/* ==========================================================================
   AK SUW — 3D suw damjasy logosy
   1) Syçanjyk (mouse) nirä hereket etse, damja 3D aýlanyp şol tarapa seredýär.
   2) Sahypa aşak aýlananda damja logodan (suwuň içinden) çykyp, aşak akýar.
   Kitaphana ýok, internet gerek däl.
   ========================================================================== */
(function () {
    'use strict';

    var logo   = document.getElementById('logo3d');
    var inner  = document.getElementById('logo3dInner');
    var flow   = document.getElementById('flow');
    var drop   = document.getElementById('flowDrop');
    var stream = document.getElementById('flowStream');
    var ripple = document.getElementById('flowRipple');
    if (!logo || !inner) return;

    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce) return;                       // hereket islemeýänler üçin duran logo

    var clamp = function (v, a, b) { return Math.max(a, Math.min(b, v)); };
    var lerp  = function (a, b, t) { return a + (b - a) * t; };

    // ───── 1) Syçanjyga eýerýän 3D aýlanma ─────
    var mx = 0, my = 0;          // -1..1 (logo bilen syçanjygyň aralygy)
    var rx = 0, ry = 0;          // häzirki aýlanma
    var hasPointer = false;

    window.addEventListener('pointermove', function (e) {
        var r = logo.getBoundingClientRect();
        var cx = r.left + r.width / 2, cy = r.top + r.height / 2;
        mx = clamp((e.clientX - cx) / (window.innerWidth * 0.45), -1, 1);
        my = clamp((e.clientY - cy) / (window.innerHeight * 0.45), -1, 1);
        hasPointer = true;
    }, { passive: true });

    document.addEventListener('pointerleave', function () { mx = 0; my = 0; });

    // ───── 2) Aşak aýlananda akýan damja ─────
    var flowOn = !!(flow && drop && stream);
    var fy = 0, targetY = 0, prevFy = 0, shown = 0, geo = null;

    function measure() {
        var r = logo.getBoundingClientRect();
        geo = {
            x: r.left + r.width / 2,
            top: r.top + r.height / 2,
            bottom: window.innerHeight - 46
        };
        if (flowOn) flow.style.setProperty('--fx', geo.x + 'px');
    }

    function progress() {
        var max = document.documentElement.scrollHeight - window.innerHeight;
        return max > 0 ? clamp(window.scrollY / max, 0, 1) : 0;
    }

    var scrolled = false;
    function onScroll() {
        var s = window.scrollY > 6;
        if (s !== scrolled) {
            scrolled = s;
            logo.classList.remove('release');
            void logo.offsetWidth;                 // animasiýany täzeden başlat
            if (s) logo.classList.add('release');  // damja "üzülip" çykýar
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', measure);
    window.addEventListener('load', measure);
    measure(); onScroll();

    // ───── Bir animasiýa sikli ─────
    var t0 = performance.now();
    function frame(now) {
        var t = (now - t0) / 1000;

        // 3D aýlanma (syçanjyk ýok bolsa özi ýuwaşlyk bilen sallanýar)
        var tx = hasPointer ? mx : Math.sin(t * 0.9) * 0.35;
        var ty = hasPointer ? my : Math.cos(t * 0.7) * 0.25;
        ry = lerp(ry, tx * 42, 0.12);
        rx = lerp(rx, -ty * 42, 0.12);
        inner.style.transform = 'rotateX(' + rx.toFixed(2) + 'deg) rotateY(' + ry.toFixed(2) + 'deg)';
        logo.style.setProperty('--gx', (50 + ry * 0.9).toFixed(1) + '%');   // ýalpyldy ýagtylyk
        logo.style.setProperty('--gy', (35 - rx * 0.9).toFixed(1) + '%');

        // Akýan damja
        if (flowOn) {
            var p = progress();
            var eased = 1 - Math.pow(1 - p, 1.6);
            targetY = geo.top + eased * (geo.bottom - geo.top);
            if (window.scrollY <= 6) targetY = geo.top;

            fy = lerp(fy, targetY, 0.09);
            var speed = Math.abs(fy - prevFy);
            prevFy = fy;

            var stretch = 1 + clamp(speed / 14, 0, 0.7);        // çalt akanda uzalýar
            var wobble  = Math.sin(t * 5) * 0.04;               // sähel dolkunlaýar
            var len = Math.max(0, fy - geo.top);

            shown = lerp(shown, window.scrollY > 6 ? 1 : 0, 0.12);
            flow.style.opacity = shown.toFixed(3);

            drop.style.transform = 'translate(-50%, ' + fy.toFixed(1) + 'px) scale(' +
                (1 / Math.sqrt(stretch) + wobble).toFixed(3) + ', ' + (stretch - wobble).toFixed(3) + ')';
            stream.style.transform = 'translate(-50%, ' + geo.top.toFixed(1) + 'px)';
            stream.style.height = len.toFixed(1) + 'px';
            stream.style.width = (3 + clamp(speed / 6, 0, 3)).toFixed(1) + 'px';

            // Aşaky ýere ýetende suw halkasy ýaýraýar
            var atBottom = p > 0.97 && len > 40;
            ripple.classList.toggle('on', atBottom);
            ripple.style.transform = 'translate(-50%, ' + (geo.bottom + 18) + 'px)';
        }
        requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
})();
