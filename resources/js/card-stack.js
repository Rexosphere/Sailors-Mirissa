import vertexSource from './shaders/wave.vert.glsl?raw';
import commonSource from './shaders/common.glsl?raw';
import seaSource from './shaders/sea.frag.glsl?raw';

const START_SUBMERGED = 0.62; // fraction of the rising card under water when the transition begins
const CARD_RADIUS_PX = 28;
const PICTURES_PER_CARD = 3;  // pictures of a card that its reflection is built from
const PICTURE_MIN_AREA = 0.06; // of the card, for a picture to count
const TEXTURE_MAX_PX = 1024;
const FALLBACK_BG = [0.04, 0.09, 0.16];

// Camera and sea constants shared with the shaders; SEA_MEAN is the average of seaHeight().
const CAMERA = { height: 2.4, pitch: 0.24, fov: 0.8, seaMean: 0.105, seaMax: 0.32, sun: [-0.55, 0.30, 0.78] };

const easeOutCubic = (x) => 1 - Math.pow(1 - x, 3);
const smoothstep = (a, b, x) => { const t = Math.min(1, Math.max(0, (x - a) / (b - a))); return t * t * (3 - 2 * t); };

function shaderDefines() {
    const sun = CAMERA.sun;
    const len = Math.hypot(...sun);
    return [
        `#define CAM_HEIGHT ${CAMERA.height.toFixed(4)}`,
        `#define CAM_PITCH ${CAMERA.pitch.toFixed(4)}`,
        `#define CAM_FOV ${CAMERA.fov.toFixed(4)}`,
        `#define SEA_MEAN ${CAMERA.seaMean.toFixed(4)}`,
        `#define SEA_MAX ${CAMERA.seaMax.toFixed(4)}`,
        `#define SUN_DIR vec3(${sun.map((v) => (v / len).toFixed(4)).join(', ')})`,
        '',
    ].join('\n');
}

// Distance along the view axis at which the mean sea level projects to screen height `uvY`.
function planeDistance(uvY) {
    const sy = (uvY * 2 - 1) * CAMERA.fov;
    const len = Math.hypot(sy, 1);
    const dy = sy / len;
    const dz = 1 / len;
    const c = Math.cos(CAMERA.pitch);
    const s = Math.sin(CAMERA.pitch);
    const rdY = dy * c - dz * s;
    const rdZ = dy * s + dz * c;
    if (rdY > -0.03) return 60;
    return ((CAMERA.seaMean - CAMERA.height) / rdY) * rdZ;
}

function compile(gl, type, source) {
    const shader = gl.createShader(type);
    gl.shaderSource(shader, source);
    gl.compileShader(shader);
    if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        const log = gl.getShaderInfoLog(shader);
        gl.deleteShader(shader);
        throw new Error(log || 'Shader compile failed');
    }
    return shader;
}

function createLayer(id, fragment, uniformNames) {
    const canvas = document.createElement('canvas');
    canvas.id = id;
    canvas.className = id;
    canvas.setAttribute('aria-hidden', 'true');
    const gl = canvas.getContext('webgl', { alpha: true, premultipliedAlpha: true, antialias: false, depth: false, stencil: false, powerPreference: 'high-performance' });
    if (!gl) return null;

    const program = gl.createProgram();
    try {
        gl.attachShader(program, compile(gl, gl.VERTEX_SHADER, vertexSource));
        gl.attachShader(program, compile(gl, gl.FRAGMENT_SHADER, fragment.replace('#include <common>', shaderDefines() + commonSource)));
        gl.linkProgram(program);
        if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
            throw new Error(gl.getProgramInfoLog(program) || 'Program link failed');
        }
    } catch (error) {
        console.warn(`[${id}] disabled:`, error.message);
        return null;
    }

    gl.useProgram(program);
    const buffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);
    const position = gl.getAttribLocation(program, 'a_position');
    gl.enableVertexAttribArray(position);
    gl.vertexAttribPointer(position, 2, gl.FLOAT, false, 0, 0);
    gl.clearColor(0, 0, 0, 0);

    const u = {};
    uniformNames.forEach((name) => { u[name] = gl.getUniformLocation(program, name); });

    let lost = false;
    canvas.addEventListener('webglcontextlost', (event) => { event.preventDefault(); lost = true; });
    canvas.addEventListener('webglcontextrestored', () => { lost = false; });

    return {
        canvas,
        gl,
        u,
        resize(width, height) {
            if (canvas.width !== width || canvas.height !== height) {
                canvas.width = width;
                canvas.height = height;
                gl.viewport(0, 0, width, height);
                gl.uniform2f(u.u_res, width, height);
            }
        },
        draw() {
            if (lost) return;
            gl.clear(gl.COLOR_BUFFER_BIT);
            gl.drawArrays(gl.TRIANGLES, 0, 3);
        },
        show(on) {
            canvas.classList.toggle('is-visible', on);
            if (!on && !lost) gl.clear(gl.COLOR_BUFFER_BIT);
        },
    };
}

function parseColor(css) {
    const parts = css?.match(/[\d.]+/g);
    if (!parts || parts.length < 3 || (parts.length > 3 && Number(parts[3]) === 0)) return null;
    return parts.slice(0, 3).map((v) => Number(v) / 255);
}

function isRendered(el, root) {
    for (let node = el; node && node !== root; node = node.parentElement) {
        const style = getComputedStyle(node);
        if (style.display === 'none' || style.visibility === 'hidden' || Number(style.opacity) < 0.5) return false;
    }
    return true;
}

// The pictures that make up a card's reflection: its largest visible images, each with its
// rect in card-local fractions (origin bottom-left) and the window of the texture it shows.
function cardPictures(section) {
    const sec = section.getBoundingClientRect();
    const area = sec.width * sec.height;
    if (!area) return [];
    const found = [];
    section.querySelectorAll('img').forEach((img) => {
        if (!img.complete || !img.naturalWidth) return;
        const r = img.getBoundingClientRect();
        const ix = Math.max(0, Math.min(r.right, sec.right) - Math.max(r.left, sec.left));
        const iy = Math.max(0, Math.min(r.bottom, sec.bottom) - Math.max(r.top, sec.top));
        const visible = (ix * iy) / area;
        if (visible < PICTURE_MIN_AREA || !isRendered(img, section)) return;
        found.push({ img, r, visible });
    });
    found.sort((a, b) => b.visible - a.visible);
    return found.slice(0, PICTURES_PER_CARD).map(({ img, r }) => {
        const fit = getComputedStyle(img).objectFit;
        const nw = img.naturalWidth;
        const nh = img.naturalHeight;
        let box = { left: r.left, top: r.top, width: r.width, height: r.height };
        let crop = [0, 0, 1, 1];
        if (fit === 'cover') {
            const scale = Math.max(r.width / nw, r.height / nh);
            const vw = r.width / scale / nw;
            const vh = r.height / scale / nh;
            crop = [(1 - vw) / 2, (1 - vh) / 2, (1 + vw) / 2, (1 + vh) / 2];
        } else if (fit === 'contain') {
            const scale = Math.min(r.width / nw, r.height / nh);
            const w = nw * scale;
            const h = nh * scale;
            box = { left: r.left + (r.width - w) / 2, top: r.top + (r.height - h) / 2, width: w, height: h };
        }
        return {
            img,
            rect: [(box.left - sec.left) / sec.width, (sec.bottom - box.top - box.height) / sec.height, box.width / sec.width, box.height / sec.height],
            crop,
        };
    });
}

/**
 * Card-stack transition: the leaving section lifts away while the next one rises out of
 * a ray-marched sea drawn over the whole viewport in a single pass. Around the cards it
 * is open water; in front of the rising card it is clipped to where the water stands
 * between the viewer and the card's plane, so the swell itself forms the waterline. The
 * water is clear, and its surface mirrors the cards' pictures and background colours.
 *
 * The resting section and the two cards in flight are pinned to the viewport while their
 * slots keep the document's height, so card positions depend on progress alone and never
 * on where the browser's compositor has scrolled to in the meantime.
 */
export function initCardStack(sections, slots) {
    if (sections.length < 2) return null;

    const isMobile = window.matchMedia('(max-width: 767px)').matches;
    const sea = createLayer('fp-sea', seaSource, [
        'u_res', 'u_time', 'u_card', 'u_radius', 'u_cardBg', 'u_leave', 'u_leaveRadius', 'u_leaveBg', 'u_dist', 'u_tex', 'u_rect', 'u_crop',
    ]);
    if (!sea) return null;
    document.body.appendChild(sea.canvas);

    const { gl } = sea;
    const pictureSlots = PICTURES_PER_CARD * 2;
    gl.uniform1iv(sea.u.u_tex, new Int32Array(Array.from({ length: pictureSlots }, (_, i) => i)));
    const blank = gl.createTexture();
    gl.bindTexture(gl.TEXTURE_2D, blank);
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, 1, 1, 0, gl.RGBA, gl.UNSIGNED_BYTE, new Uint8Array(4));
    const textures = new WeakMap();

    function sectionBg(section) {
        return parseColor(getComputedStyle(section).backgroundColor) || FALLBACK_BG;
    }

    // Pictures are flattened onto their card's colour so transparent pixels reflect as the card does.
    function textureFor(img, bg) {
        if (textures.has(img)) return textures.get(img);
        let texture = null;
        try {
            const scale = Math.min(1, TEXTURE_MAX_PX / Math.max(img.naturalWidth, img.naturalHeight));
            const source = document.createElement('canvas');
            source.width = Math.max(1, Math.round(img.naturalWidth * scale));
            source.height = Math.max(1, Math.round(img.naturalHeight * scale));
            const ctx = source.getContext('2d');
            ctx.fillStyle = `rgb(${bg.map((v) => Math.round(v * 255)).join(' ')})`;
            ctx.fillRect(0, 0, source.width, source.height);
            ctx.drawImage(img, 0, 0, source.width, source.height);
            texture = gl.createTexture();
            gl.bindTexture(gl.TEXTURE_2D, texture);
            gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
            gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, source);
            gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
            gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
            gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
            gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
        } catch (error) {
            texture = null;   // tainted (cross-origin) image: reflect the background colour instead
        }
        textures.set(img, texture);
        return texture;
    }

    function uploadCards(rising, leaving) {
        const rects = new Float32Array(pictureSlots * 4);
        const crops = new Float32Array(pictureSlots * 4);
        [rising, leaving].forEach((section, card) => {
            const pictures = cardPictures(section);
            const bg = sectionBg(section);
            for (let i = 0; i < PICTURES_PER_CARD; i++) {
                const slot = card * PICTURES_PER_CARD + i;
                const picture = pictures[i];
                const texture = picture ? textureFor(picture.img, bg) : null;
                gl.activeTexture(gl.TEXTURE0 + slot);
                gl.bindTexture(gl.TEXTURE_2D, texture || blank);
                if (texture) {
                    rects.set(picture.rect, slot * 4);
                    crops.set(picture.crop, slot * 4);
                }
            }
        });
        gl.uniform4fv(sea.u.u_rect, rects);
        gl.uniform4fv(sea.u.u_crop, crops);
        gl.uniform3fv(sea.u.u_cardBg, sectionBg(rising));
        gl.uniform3fv(sea.u.u_leaveBg, sectionBg(leaving));
    }

    let tops = [];
    let rafId = 0;
    let active = false;
    let lastPair = -1;
    const start = performance.now();

    function pin(section) {
        if (section.classList.contains('fp-pinned')) return;
        slots[sections.indexOf(section)].style.height = `${section.offsetHeight}px`;
        section.classList.add('fp-pinned');
    }

    function unpin(section) {
        if (!section.classList.contains('fp-pinned')) return;
        section.classList.remove('fp-pinned', 'fp-card--active');
        section.style.transform = '';
        section.style.zIndex = '';
        slots[sections.indexOf(section)].style.height = '';
    }

    function measure() {
        sections.forEach((section) => {
            if (section.classList.contains('fp-pinned')) slots[sections.indexOf(section)].style.height = `${section.offsetHeight}px`;
        });
        tops = slots.map((slot) => slot.offsetTop);
        const dpr = Math.min(window.devicePixelRatio || 1, isMobile ? 1 : 1.25);
        sea.resize(Math.max(1, Math.round(window.innerWidth * dpr)), Math.max(1, Math.round(window.innerHeight * dpr)));
    }

    function progress() {
        const y = window.scrollY;
        for (let i = 0; i < tops.length - 1; i++) {
            const span = tops[i + 1] - tops[i];
            if (span > 0 && y >= tops[i] && y < tops[i + 1]) {
                return { index: i, p: (y - tops[i]) / span };
            }
        }
        return { index: tops.length - 2, p: y >= tops[tops.length - 1] ? 1 : 0 };
    }

    function fly(section, transform, zIndex) {
        pin(section);
        section.classList.add('fp-card--active');
        section.style.transform = transform;
        section.style.zIndex = zIndex;
    }

    // The section at rest: pinned, plain, covering the viewport.
    function rest(index) {
        sections.forEach((section, i) => {
            if (i !== index) {
                unpin(section);
                return;
            }
            pin(section);
            section.classList.remove('fp-card--active');
            section.style.transform = '';
            section.style.zIndex = '';
        });
    }

    function applyTransforms(index, p) {
        const H = window.innerHeight;
        const eased = easeOutCubic(p);
        const rising = sections[index + 1];
        const leaving = sections[index];
        sections.forEach((section) => {
            if (section !== rising && section !== leaving) unpin(section);
        });
        fly(rising, `translate3d(0, ${(0.38 * H * (1 - eased)).toFixed(2)}px, 0) scale(${(0.84 + 0.16 * eased).toFixed(4)})`, 2);
        fly(leaving, `translate3d(0, ${(-1.25 * H * p).toFixed(2)}px, 0) scale(${(1 - 0.08 * p).toFixed(4)})`, 3);
    }

    // Card rect in shader uv space (origin bottom-left), plus its corner radius in uv height units.
    function cardRect(section) {
        const rect = section.getBoundingClientRect();
        const W = window.innerWidth;
        const H = window.innerHeight;
        return {
            x: rect.left / W,
            y: 1 - rect.bottom / H,
            w: rect.width / W,
            h: rect.height / H,
            radius: (CARD_RADIUS_PX * (rect.height / H)) / H,
        };
    }

    function frame() {
        rafId = 0;
        const { index, p } = progress();
        const transitioning = p > 0.002 && p < 0.998;

        if (!transitioning) {
            rest(p >= 0.998 ? index + 1 : index);
            if (active) {
                sea.show(false);
                active = false;
                lastPair = -1;
            }
            return;
        }
        active = true;
        applyTransforms(index, p);
        if (index !== lastPair) {
            lastPair = index;
            uploadCards(sections[index + 1], sections[index]);
        }

        const rising = cardRect(sections[index + 1]);
        const leaving = cardRect(sections[index]);
        const time = (performance.now() - start) / 1000;

        // Waterline: a fraction of the rising card early on, then sunk below the screen
        // so the last swell disappears off the bottom edge instead of being switched off.
        const submerged = START_SUBMERGED * (1 - smoothstep(0.05, 0.9, p));
        const waterline = rising.y + submerged * rising.h - 0.12 * smoothstep(0.6, 0.97, p);

        sea.show(true);
        gl.uniform1f(sea.u.u_time, time);
        gl.uniform4f(sea.u.u_card, rising.x, rising.y, rising.w, rising.h);
        gl.uniform1f(sea.u.u_radius, rising.radius);
        gl.uniform4f(sea.u.u_leave, leaving.x, leaving.y, leaving.w, leaving.h);
        gl.uniform1f(sea.u.u_leaveRadius, leaving.radius);
        gl.uniform1f(sea.u.u_dist, planeDistance(waterline));
        sea.draw();

        rafId = requestAnimationFrame(frame);
    }

    function schedule() {
        if (!rafId) rafId = requestAnimationFrame(frame);
    }

    window.addEventListener('scroll', schedule, { passive: true });
    window.addEventListener('resize', () => { measure(); schedule(); });
    const observer = new ResizeObserver(() => { measure(); schedule(); });
    observer.observe(document.documentElement);

    // Build the textures for pictures that are already decoded before the first transition needs them.
    const warm = () => sections.forEach((section) => { const bg = sectionBg(section); cardPictures(section).forEach(({ img }) => textureFor(img, bg)); });
    if ('requestIdleCallback' in window) window.requestIdleCallback(warm, { timeout: 2000 });
    else window.setTimeout(warm, 500);

    measure();
    schedule();

    return { measure };
}
