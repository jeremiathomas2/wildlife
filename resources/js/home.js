// Home Page JavaScript
// Hero Carousel, Shader, and Interactive Features

document.addEventListener('DOMContentLoaded', function() {
    // Hero Carousel
    let currentHeroSlide = 0;
    const heroSection = document.getElementById('hero-section');
    const totalHeroSlides = heroSection ? parseInt(heroSection.dataset.totalSlides || '0') : 0;
    let heroAutoplayInterval;

    function updateHeroSlides() {
        for (let i = 0; i < totalHeroSlides; i++) {
            const slide = document.getElementById('hero-slide-' + i);
            const indicator = document.getElementById('hero-indicator-' + i);
            if (slide && indicator) {
                slide.style.opacity = i === currentHeroSlide ? 1 : 0;
                indicator.style.width = i === currentHeroSlide ? '48px' : '12px';
                indicator.style.background = i === currentHeroSlide ? '#ff9729' : 'rgba(255,255,255,0.5)';
            }
        }
    }

    function nextHeroSlide() {
        currentHeroSlide = (currentHeroSlide + 1) % totalHeroSlides;
        updateHeroSlides();
        resetAutoplay();
    }

    function prevHeroSlide() {
        currentHeroSlide = (currentHeroSlide - 1 + totalHeroSlides) % totalHeroSlides;
        updateHeroSlides();
        resetAutoplay();
    }

    function goToHeroSlide(index) {
        currentHeroSlide = index;
        updateHeroSlides();
        resetAutoplay();
    }

    function resetAutoplay() {
        clearInterval(heroAutoplayInterval);
        heroAutoplayInterval = setInterval(nextHeroSlide, 6000);
    }

    // Expose carousel functions for inline onclick handlers
    window.nextHeroSlide = nextHeroSlide;
    window.prevHeroSlide = prevHeroSlide;
    window.goToHeroSlide = goToHeroSlide;

    // Multi-Day Scroll-Zoom Background
    function initMultiDayZoom() {
        const section = document.getElementById('multiDaySection');
        const bg = document.getElementById('multiBgZoom');
        if (!section || !bg) return;

        function onScroll() {
            const rect = section.getBoundingClientRect();
            const vh = window.innerHeight;
            const sectionHeight = rect.height;

            if (rect.top > vh || rect.bottom < 0) return;

            const progress = (vh - rect.top) / (vh + sectionHeight);
            const clamped = Math.max(0, Math.min(1, progress));
            const scale = 1.25 - (clamped * 0.3);
            bg.style.transform = 'scale(' + scale + ')';
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // Draping Silk Shader
    function initDrapingSilk() {
        const canvas = document.getElementById('draping-silk');
        if (!canvas) return;

        const gl = canvas.getContext('webgl');
        if (!gl) {
            console.log('WebGL not supported');
            return;
        }

        // Vertex shader
        const vertexShaderSource = `
            attribute vec2 a_pos;
            varying vec2 v_uv;
            void main() {
                v_uv = a_pos * 0.5 + 0.5;
                gl_Position = vec4(a_pos, 0.0, 1.0);
            }
        `;

        // Fragment shader
        const fragmentShaderSource = `
            precision highp float;
            uniform float u_time;
            uniform vec2 u_res;
            uniform vec3 u_color;
            varying vec2 v_uv;

            float hash(vec2 p) {
                p = fract(p * vec2(127.1, 311.7));
                p += dot(p, p + 45.32);
                return fract(p.x * p.y);
            }

            float noise(vec2 p) {
                vec2 i = floor(p);
                vec2 f = fract(p);
                vec2 u = f * f * (3.0 - 2.0 * f);
                float a = hash(i);
                float b = hash(i + vec2(1.0, 0.0));
                float c = hash(i + vec2(0.0, 1.0));
                float d = hash(i + vec2(1.0, 1.0));
                return mix(mix(a, b, u.x), mix(c, d, u.x), u.y);
            }

            float fbm(vec2 p) {
                float val = 0.0;
                float amp = 0.5;
                float freq = 1.0;
                for (int i = 0; i < 5; i++) {
                    val += amp * noise(p * freq);
                    freq *= 2.03;
                    amp *= 0.5;
                    p += vec2(1.7, 9.2);
                }
                return val;
            }

            float ridgedNoise(vec2 p) {
                return 1.0 - abs(noise(p) * 2.0 - 1.0);
            }

            float fabricFold(vec2 uv, float t, float foldStrength, float foldFreq, float foldPhase) {
                float foldCenter = sin(uv.x * foldFreq * 3.14159 + foldPhase) * 0.25;
                float foldLine = abs(uv.y - foldCenter);
                float foldShape = exp(-foldLine * foldLine * 120.0);
                float foldWave = sin(uv.x * 12.0 + t * 0.4) * 0.03;
                float foldRidges = pow(max(ridgedNoise(vec2(uv.x * 8.0 + foldPhase, t * 0.15)), 0.0), 3.0) * 0.15;
                return (foldShape + foldWave) * foldStrength + foldRidges * foldStrength;
            }

            float fabricDrape(vec2 uv, float t) {
                float drape1 = sin(uv.x * 2.5 + t * 0.25) * 0.06;
                float drape2 = sin(uv.x * 4.0 + t * 0.35 + 1.5) * 0.035;
                float drape3 = sin(uv.x * 7.0 + t * 0.18 + 3.0) * 0.015;
                float weightPull = sin(uv.x * 1.5 + t * 0.1) * 0.02;
                float drapeNoise = fbm(vec2(uv.x * 3.0, t * 0.1)) * 0.02;
                float centerGather = sin((uv.x - 0.5) * 1.8) * 0.025;
                return drape1 + drape2 + drape3 + weightPull + drapeNoise + centerGather;
            }

            float fabricFolds(vec2 uv, float t) {
                float fold = 0.0;
                fold += fabricFold(uv, t, 0.5, 1.2, t * 0.15);
                fold += fabricFold(uv, t, 0.35, 2.8, t * 0.2 + 2.0);
                fold += fabricFold(uv, t, 0.25, 4.5, t * 0.12 + 4.0);
                fold += fabricFold(uv, t, 0.18, 7.0, t * 0.18 + 1.0);
                fold += fabricFold(uv, t, 0.12, 11.0, t * 0.08 + 3.5);
                return fold;
            }

            void main() {
                vec2 uv = (gl_FragCoord.xy - u_res * 0.5) / min(u_res.x, u_res.y);
                vec2 c = gl_FragCoord.xy / u_res;
                float t = u_time;

                float folds = fabricFolds(c, t);
                folds += sin(c.x * 2.5 + t * 0.2) * 0.04;
                folds += fbm(vec2(c.x * 6.0 + t * 0.1, c.y * 3.0)) * 0.03;

                float drapeEffect = fabricDrape(c, t);

                vec2 patternUV = c;
                patternUV.y += folds * 0.08;
                patternUV.x += drapeEffect * 0.03;
                patternUV.y += drapeEffect * 0.06;

                float pattern = fbm(patternUV * 3.0 + vec2(t * 0.05, 0.0));
                float sheen = pow(max(noise(patternUV * 8.0 + vec2(t * 0.08, t * 0.03)), 0.0), 2.0);
                pattern += sheen * 0.3;

                float threadX = sin(patternUV.x * 200.0) * 0.5 + 0.5;
                float threadY = sin(patternUV.y * 200.0) * 0.5 + 0.5;
                float threads = threadX * threadY * 0.06 + (threadX * 0.02);

                float foldDepth = folds + drapeEffect;

                vec3 lightDir = normalize(vec3(0.3, 0.8, 0.5));
                vec3 foldNormal = normalize(vec3(-(folds * 0.5 + drapeEffect * 0.3), 0.6, 1.0));
                float diffuse = max(dot(foldNormal, lightDir), 0.0);

                vec3 viewDir = normalize(vec3(0.0, 0.0, 1.0));
                vec3 halfDir = normalize(lightDir + viewDir);
                float specAngle = max(dot(foldNormal, halfDir), 0.0);
                float spec = pow(specAngle, 60.0);

                float fresnel = pow(1.0 - max(dot(foldNormal, viewDir), 0.0), 3.0);

                vec3 baseColor = u_color;
                float colorMix = clamp(diffuse * 1.5 + foldDepth * 0.3 + pattern * 0.2, 0.0, 1.0);
                vec3 finalColor = baseColor * (0.7 + colorMix * 0.6);

                finalColor += vec3(0.05, 0.02, 0.0) * fresnel * 0.3;
                finalColor += vec3(0.35, 0.08, 0.0) * sheen * 0.25;
                finalColor += vec3(0.02, 0.01, 0.0) * threads;
                finalColor += vec3(0.45, 0.18, 0.0) * spec * 0.7;
                finalColor += vec3(0.45, 0.18, 0.0) * pow(max(folds, 0.0), 3.0) * 0.15;

                float depthShadow = smoothstep(-0.15, 0.25, foldDepth);
                float gatherShadow = smoothstep(0.3, 0.7, c.y);
                float shadow = depthShadow * 0.7 + 0.3;
                finalColor *= shadow * gatherShadow;

                finalColor += vec3(0.02, 0.005, 0.0) * (1.0 - depthShadow) * 0.5;

                float breathe = sin(t * 0.15) * 0.015;
                finalColor += vec3(0.02, 0.005, 0.0) * breathe;

                float vig = 1.0 - dot(uv * 0.8, uv * 0.8);
                vig = smoothstep(0.0, 1.0, vig);
                finalColor *= 0.65 + vig * 0.35;

                finalColor += (hash(gl_FragCoord.xy + fract(t * 0.1) * 1000.0) - 0.5) * 0.012;

                finalColor = pow(finalColor, vec3(0.95));

                gl_FragColor = vec4(finalColor, 0.3);
            }
        `;

        // Compile shader helper
        function compileShader(gl, source, type) {
            const shader = gl.createShader(type);
            gl.shaderSource(shader, source);
            gl.compileShader(shader);
            if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
                console.error('Shader compile error:', gl.getShaderInfoLog(shader));
                gl.deleteShader(shader);
                return null;
            }
            return shader;
        }

        // Create shaders
        const vertexShader = compileShader(gl, vertexShaderSource, gl.VERTEX_SHADER);
        const fragmentShader = compileShader(gl, fragmentShaderSource, gl.FRAGMENT_SHADER);

        // Create program
        const program = gl.createProgram();
        gl.attachShader(program, vertexShader);
        gl.attachShader(program, fragmentShader);
        gl.linkProgram(program);
        if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
            console.error('Program link error:', gl.getProgramInfoLog(program));
            return;
        }
        gl.useProgram(program);

        // Create geometry (a fullscreen triangle)
        const positions = new Float32Array([-1, -1, 3, -1, -1, 3]);
        const positionBuffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, positions, gl.STATIC_DRAW);

        const a_pos = gl.getAttribLocation(program, 'a_pos');
        gl.enableVertexAttribArray(a_pos);
        gl.vertexAttribPointer(a_pos, 2, gl.FLOAT, false, 0, 0);

        // Get uniform locations
        const u_time = gl.getUniformLocation(program, 'u_time');
        const u_res = gl.getUniformLocation(program, 'u_res');
        const u_color = gl.getUniformLocation(program, 'u_color');

        // Resize canvas (cap devicePixelRatio to keep the GPU cost reasonable)
        function resize() {
            const heroEl = document.getElementById('hero-section');
            if (!heroEl) return;
            const rect = heroEl.getBoundingClientRect();
            const dpr = Math.min(window.devicePixelRatio || 1, 1.5);
            canvas.width = Math.round(rect.width * dpr);
            canvas.height = Math.round(rect.height * dpr);
            gl.viewport(0, 0, canvas.width, canvas.height);
        }
        window.addEventListener('resize', resize);
        resize();

        // Animation loop
        const startTime = performance.now();
        let silkRunning = false;

        function animate(time) {
            if (!silkRunning) return;
            const t = (time - startTime) / 1000;
            gl.uniform1f(u_time, t);
            gl.uniform2f(u_res, canvas.width, canvas.height);
            gl.uniform3f(u_color, 0.35, 0.12, 0.0); // Brown color
            gl.drawArrays(gl.TRIANGLES, 0, 3);
            requestAnimationFrame(animate);
        }

        // Run the shader only while the hero is on screen
        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        canvas.style.display = 'block';
                        if (!silkRunning) {
                            silkRunning = true;
                            requestAnimationFrame(animate);
                        }
                    } else {
                        silkRunning = false;
                        canvas.style.display = 'none';
                    }
                });
            }, { threshold: 0.05 });
            io.observe(canvas);
        } else {
            silkRunning = true;
            requestAnimationFrame(animate);
        }
    }

    // Initialize everything
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    heroAutoplayInterval = setInterval(nextHeroSlide, 6000);

    initMultiDayZoom();

    if (!prefersReducedMotion) {
        initDrapingSilk();
    }

    // Typewriter effect
    const messages = [
        "The Best African Safari Experience",
        "Discover Tanzania's Hidden Gems",
        "Adventures That Last a Lifetime",
        "Witness the Great Migration",
        "Connect with Nature's Beauty"
    ];
    let messageIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typewriter = document.getElementById('typewriter');

    function type() {
        const currentMessage = messages[messageIndex];

        if (isDeleting) {
            typewriter.textContent = currentMessage.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typewriter.textContent = currentMessage.substring(0, charIndex + 1);
            charIndex++;
        }

        let typeSpeed = isDeleting ? 50 : 100;

        if (!isDeleting && charIndex === currentMessage.length) {
            typeSpeed = 2000; // Pause at end
            isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            messageIndex = (messageIndex + 1) % messages.length;
            typeSpeed = 500;
        }

        setTimeout(type, typeSpeed);
    }

    if (prefersReducedMotion) {
        typewriter.textContent = messages[0];
    } else {
        type();
    }
});
