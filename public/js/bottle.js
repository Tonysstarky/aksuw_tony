/* ==========================================================================
   AK SUW — 3D suw şişesi (canvas, kitaphanasyz)
   • Myskany süýşürseň şişe egrelýär, suw içinde dolkunlanýar.
   • Ýeterlik egrelende şişäniň agzyndan suw damjalary dökülýär we ýere çaýkanýar.
   • Myska degmeseň, şişe özi gyşaryp suw dökýär.
   ========================================================================== */
(function () {
    'use strict';
    var cv = document.getElementById('bottleCanvas');
    if (!cv) return;
    var ctx = cv.getContext('2d');
    var W = 260, H = 330, PX = 130, PY = 150;           // mantyky ölçegler we aýlanma nokady
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var dpr = Math.min(window.devicePixelRatio || 1, 2);

    function fit() {
        var w = cv.clientWidth || W;
        cv.width = Math.round(w * dpr); cv.height = Math.round(w * (H / W) * dpr);
    }
    fit(); window.addEventListener('resize', fit);

    // ───── ýagdaý ─────
    var ang = 0, angTarget = 0, angSlow = 0;
    var fill = 0.62;                        // suwuň derejesi (0..1)
    var pouredTotal = 0;
    var drops = [], splashes = [], ripples = [], bubbles = [];
    var hover = false, mouseX = 0;
    for (var i = 0; i < 16; i++) bubbles.push({ x: (Math.random() - .5) * 70, y: Math.random() * 120, r: 1 + Math.random() * 2.6, s: .15 + Math.random() * .35, p: Math.random() * 6 });

    var host = cv.closest('.hero-art-wrapper') || cv;
    host.addEventListener('pointermove', function (e) {
        var r = host.getBoundingClientRect();
        mouseX = ((e.clientX - r.left) / r.width) * 2 - 1; hover = true;
    });
    host.addEventListener('pointerleave', function () { hover = false; });

    // ───── şişäniň şekili (ýerli koordinatlar) ─────
    function bottlePath(c) {
        c.beginPath();
        c.moveTo(-15, -104);
        c.lineTo(-15, -84);
        c.bezierCurveTo(-15, -62, -46, -56, -46, -30);
        c.lineTo(-46, 112);
        c.quadraticCurveTo(-46, 130, -28, 130);
        c.lineTo(28, 130);
        c.quadraticCurveTo(46, 130, 46, 112);
        c.lineTo(46, -30);
        c.bezierCurveTo(46, -56, 15, -62, 15, -84);
        c.lineTo(15, -104);
        c.closePath();
    }

    function rot(x, y, a) { return [x * Math.cos(a) - y * Math.sin(a), x * Math.sin(a) + y * Math.cos(a)]; }

    var t0 = performance.now(), last = t0, running = true, pourAcc = 0;

    function step(now) {
        var dt = Math.min((now - last) / 16.67, 3); last = now;
        var t = (now - t0) / 1000;

        // egrelmäniň maksady
        angTarget = hover ? mouseX * 0.85 : Math.sin(t * 0.5) * 0.62 + Math.sin(t * 1.3) * 0.05;
        ang += (angTarget - ang) * 0.06 * dt;
        angSlow += (ang - angSlow) * 0.045 * dt;
        var lag = ang - angSlow;                               // suwuň yzda galmagy (dolkun)

        // suw dökmek
        var pouring = Math.abs(ang) > 0.5 && fill > 0.2;
        if (pouring) {
            fill -= 0.0009 * dt * (Math.abs(ang) - 0.4) * 3;
            pourAcc += dt * (Math.abs(ang) - 0.35) * 1.6;
            while (pourAcc > 1) {
                pourAcc -= 1;
                var m = rot(0, -104, ang), s = Math.sign(ang);
                drops.push({ x: PX + m[0] + s * 3, y: PY + m[1], vx: s * (0.5 + Math.random() * 0.9), vy: -0.4 + Math.random() * 0.8, r: 2 + Math.random() * 2.2 });
            }
        } else if (fill < 0.62) fill += 0.0012 * dt;           // ýuwaş-ýuwaşdan gaýtadan dolýar

        // damjalar
        var floor = PY + 150;
        for (var i = drops.length - 1; i >= 0; i--) {
            var d = drops[i]; d.vy += 0.2 * dt; d.x += d.vx * dt; d.y += d.vy * dt;
            if (d.y >= floor) {
                ripples.push({ x: d.x, r: 2, a: .8 });
                for (var k = 0; k < 3; k++) splashes.push({ x: d.x, y: floor, vx: (Math.random() - .5) * 2.4, vy: -1.2 - Math.random() * 1.6, l: 1 });
                pouredTotal = Math.min(pouredTotal + 0.6, 40);
                drops.splice(i, 1);
            }
        }
        for (var j = splashes.length - 1; j >= 0; j--) {
            var sp = splashes[j]; sp.vy += 0.16 * dt; sp.x += sp.vx * dt; sp.y += sp.vy * dt; sp.l -= 0.035 * dt;
            if (sp.l <= 0 || sp.y > floor + 2) splashes.splice(j, 1);
        }
        for (var q = ripples.length - 1; q >= 0; q--) {
            var rp = ripples[q]; rp.r += 0.9 * dt; rp.a -= 0.014 * dt; if (rp.a <= 0) ripples.splice(q, 1);
        }
        if (pouredTotal > 0) pouredTotal -= 0.008 * dt;        // kölçük ýuwaş-ýuwaş guraýar

        draw(t, lag, floor);
        if (running && !reduce) requestAnimationFrame(step);
    }

    function draw(t, lag, floor) {
        var sc = cv.width / W;
        ctx.setTransform(sc, 0, 0, sc, 0, 0);
        ctx.clearRect(0, 0, W, H);

        // kölçük (ýerdäki suw)
        var pw = 50 + pouredTotal * 3.2, ph = 7 + pouredTotal * 0.3;
        var pcx = PX + Math.sin(ang) * 40;
        var g = ctx.createRadialGradient(pcx, floor + 2, 2, pcx, floor + 2, pw);
        g.addColorStop(0, 'rgba(150,200,255,.55)'); g.addColorStop(1, 'rgba(60,110,255,0)');
        ctx.fillStyle = g; ctx.beginPath(); ctx.ellipse(pcx, floor + 2, pw, ph, 0, 0, 7); ctx.fill();
        ctx.strokeStyle = 'rgba(210,235,255,.7)'; ctx.lineWidth = 1.2;
        ripples.forEach(function (r) { ctx.globalAlpha = Math.max(r.a, 0); ctx.beginPath(); ctx.ellipse(r.x, floor + 2, r.r * 1.8, r.r * .5, 0, 0, 7); ctx.stroke(); });
        ctx.globalAlpha = 1;

        // şişe + suw
        ctx.save();
        ctx.translate(PX, PY); ctx.rotate(ang);
        // şişäniň kölegesi / jam
        bottlePath(ctx);
        ctx.fillStyle = 'rgba(190,225,255,.10)'; ctx.fill();
        ctx.save(); bottlePath(ctx); ctx.clip();

        ctx.rotate(-ang);                                       // suw dünýä görä gorizontal galýar
        var L = 130 - fill * 215;                               // suwuň ýokarky çyzygy (aýlanma nokadyna görä)
        var amp = 2 + Math.min(Math.abs(lag) * 40, 9), slope = lag * 1.1;
        function surface(off, ph, a2) {
            ctx.beginPath(); ctx.moveTo(-130, 190);
            for (var x = -130; x <= 130; x += 6) {
                ctx.lineTo(x, L + x * slope + Math.sin(x * .06 + t * 2 + ph) * amp * a2 + Math.sin(x * .13 - t * 1.4) * amp * .5 * a2 + off);
            }
            ctx.lineTo(130, 190); ctx.closePath();
        }
        surface(-3, 1.8, .8);
        var gb = ctx.createLinearGradient(0, L - 10, 0, 140);
        gb.addColorStop(0, 'rgba(120,190,255,.75)'); gb.addColorStop(1, 'rgba(40,90,255,.85)');
        ctx.fillStyle = gb; ctx.fill();
        surface(0, 0, 1);
        var gf = ctx.createLinearGradient(0, L - 10, 0, 140);
        gf.addColorStop(0, 'rgba(70,150,255,.92)'); gf.addColorStop(1, 'rgba(8,28,170,.97)');
        ctx.fillStyle = gf; ctx.fill();

        // köpükler (suwuň içinde ýokary galýar)
        ctx.fillStyle = 'rgba(255,255,255,.5)';
        bubbles.forEach(function (b) {
            b.y -= b.s; if (b.y < -10) { b.y = 120; b.x = (Math.random() - .5) * 70; }
            var bx = b.x + Math.sin(t * 1.5 + b.p) * 4, by = 130 - b.y * 1.5;
            if (by > L + 6) { ctx.beginPath(); ctx.arc(bx, by, b.r, 0, 7); ctx.fill(); }
        });
        ctx.restore();                                          // clip-i aýyr

        // aýna: gyra we ýalpyldylar
        bottlePath(ctx);
        var gs = ctx.createLinearGradient(-46, 0, 46, 0);
        gs.addColorStop(0, 'rgba(255,255,255,.75)'); gs.addColorStop(.18, 'rgba(255,255,255,.18)');
        gs.addColorStop(.8, 'rgba(255,255,255,.08)'); gs.addColorStop(1, 'rgba(255,255,255,.55)');
        ctx.strokeStyle = gs; ctx.lineWidth = 2.4; ctx.stroke();
        ctx.fillStyle = 'rgba(255,255,255,.34)';                // çep tarapdaky uzyn şöhle
        ctx.beginPath(); ctx.roundRect ? ctx.roundRect(-36, -22, 7, 120, 4) : ctx.rect(-36, -22, 7, 120); ctx.fill();
        ctx.fillStyle = 'rgba(255,255,255,.16)';
        ctx.beginPath(); ctx.roundRect ? ctx.roundRect(-8, -100, 3, 22, 2) : ctx.rect(-8, -100, 3, 22); ctx.fill();
        ctx.strokeStyle = 'rgba(255,255,255,.8)'; ctx.lineWidth = 2.2;   // şişäniň agzy
        ctx.beginPath(); ctx.ellipse(0, -104, 15, 4.5, 0, 0, 7); ctx.stroke();
        ctx.restore();

        // dökülýän damjalar
        drops.forEach(function (d) {
            var stretch = 1 + Math.min(Math.abs(d.vy) * .18, 1.1);
            var gd = ctx.createRadialGradient(d.x - d.r * .3, d.y - d.r * .3, .5, d.x, d.y, d.r * 1.6);
            gd.addColorStop(0, '#e6f4ff'); gd.addColorStop(.5, '#5aa8ff'); gd.addColorStop(1, '#1b3ee0');
            ctx.fillStyle = gd; ctx.beginPath(); ctx.ellipse(d.x, d.y, d.r, d.r * stretch, 0, 0, 7); ctx.fill();
        });
        ctx.fillStyle = '#bfe0ff';
        splashes.forEach(function (s) { ctx.globalAlpha = Math.max(s.l, 0); ctx.beginPath(); ctx.arc(s.x, s.y, 1.5, 0, 7); ctx.fill(); });
        ctx.globalAlpha = 1;
    }

    // ekran görünmese durup dur (batareýany tygşytlaýar)
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (en) {
            var vis = en[0].isIntersecting;
            if (vis && !running) { running = true; last = performance.now(); requestAnimationFrame(step); }
            running = vis;
        }).observe(cv);
    }
    requestAnimationFrame(step);
})();
