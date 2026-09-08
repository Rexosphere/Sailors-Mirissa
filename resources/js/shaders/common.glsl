// Shared camera, noise, sea surface and shading for the card-stack transition.
// CAM_HEIGHT, CAM_PITCH, CAM_FOV, SEA_MEAN and SEA_MAX are #defined by card-stack.js.

float hash21(vec2 p) {
    vec3 p3 = fract(vec3(p.xyx) * 0.1031);
    p3 += dot(p3, p3.yzx + 33.33);
    return fract((p3.x + p3.y) * p3.z);
}

float vnoise(vec2 p) {
    vec2 i = floor(p);
    vec2 f = fract(p);
    vec2 u = f * f * (3.0 - 2.0 * f);
    return mix(
        mix(hash21(i), hash21(i + vec2(1.0, 0.0)), u.x),
        mix(hash21(i + vec2(0.0, 1.0)), hash21(i + vec2(1.0, 1.0)), u.x),
        u.y
    );
}

float fbm3(vec2 p) {
    float v = 0.0;
    float a = 0.5;
    for (int i = 0; i < 3; i++) {
        v += a * vnoise(p);
        p = p * 2.1 + vec2(7.3, 3.1);
        a *= 0.5;
    }
    return v;
}

float crestWave(vec2 p, vec2 dir, float k, float speed, float sharp, float t) {
    float phase = dot(p, dir) * k + t * speed;
    float s = 0.5 + 0.5 * sin(phase);
    return pow(s, sharp);
}

// Gentle swell, 0 .. SEA_MAX world units, averaging SEA_MEAN.
float seaHeight(vec2 p, float t) {
    float warp = fbm3(p * 0.35 + t * 0.05) - 0.5;
    p += warp * 0.8;
    float h = 0.0;
    h += 0.110 * crestWave(p, normalize(vec2(0.80, 0.60)), 0.9, 0.9, 2.0, t);
    h += 0.075 * crestWave(p, normalize(vec2(-0.60, 0.80)), 1.5, 1.3, 2.4, t);
    h += 0.050 * crestWave(p, normalize(vec2(0.20, -1.00)), 2.6, 1.8, 2.8, t);
    h += 0.032 * crestWave(p, normalize(vec2(-0.90, -0.30)), 4.1, 2.4, 3.0, t);
    h += 0.020 * crestWave(p, normalize(vec2(0.70, 0.70)), 7.0, 3.2, 3.0, t);
    h += 0.013 * crestWave(p, normalize(vec2(-0.30, 0.95)), 11.0, 4.0, 2.0, t);
    return h;
}

vec3 seaNormal(vec2 xz, float t, float eps) {
    float hc = seaHeight(xz, t);
    float hx = seaHeight(xz + vec2(eps, 0.0), t);
    float hz = seaHeight(xz + vec2(0.0, eps), t);
    return normalize(vec3(hc - hx, eps, hc - hz));
}

vec3 skyColor(vec3 dir, vec3 sun) {
    float up = clamp(dir.y * 0.9 + 0.2, 0.0, 1.0);
    vec3 sky = mix(vec3(0.86, 0.93, 0.96), vec3(0.42, 0.66, 0.84), up);
    float sunGlow = pow(max(dot(dir, sun), 0.0), 14.0);
    float sunDisc = pow(max(dot(dir, sun), 0.0), 1200.0);
    return sky + vec3(1.0, 0.94, 0.80) * (sunGlow * 0.55 + sunDisc * 5.0);
}

// Screen coordinate (x already scaled by aspect) to a world ray from the camera.
vec3 rayDir(vec2 sc) {
    vec3 d = normalize(vec3(sc.x * CAM_FOV, sc.y * CAM_FOV, 1.0));
    float c = cos(CAM_PITCH);
    float s = sin(CAM_PITCH);
    return vec3(d.x, d.y * c - d.z * s, d.y * s + d.z * c);
}

float sdf(vec3 p, float t) {
    return p.y - seaHeight(p.xz, t);
}

// Ray-march the surface between the camera and tEnd. Few coarse steps, then bisection.
bool trace(vec3 ro, vec3 rd, float tEnd, float t, out vec3 hit, out float dist) {
    float tStart = max((ro.y - SEA_MAX) / -rd.y, 0.0);
    if (tStart >= tEnd) return false;
    float step = (tEnd - tStart) / 9.0;
    float tPrev = tStart;
    float dPrev = sdf(ro + rd * tPrev, t);
    float tCur = tPrev;
    float dCur = dPrev;
    bool found = false;
    for (int i = 1; i <= 9; i++) {
        tCur = tStart + step * float(i);
        dCur = sdf(ro + rd * tCur, t);
        if (dCur < 0.0) {
            found = true;
            break;
        }
        tPrev = tCur;
        dPrev = dCur;
    }
    if (!found) return false;
    for (int i = 0; i < 5; i++) {
        float tMid = mix(tPrev, tCur, clamp(dPrev / (dPrev - dCur), 0.0, 1.0));
        float dMid = sdf(ro + rd * tMid, t);
        if (dMid < 0.0) {
            tCur = tMid;
            dCur = dMid;
        } else {
            tPrev = tMid;
            dPrev = dMid;
        }
    }
    dist = tCur;
    hit = ro + rd * tCur;
    return true;
}
