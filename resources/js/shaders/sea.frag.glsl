precision highp float;

varying vec2 v_uv;

uniform vec2 u_res;
uniform float u_time;
uniform vec4 u_card;         // rising card rect in uv: x, y (bottom), width, height
uniform float u_radius;      // rising card corner radius in uv height units
uniform vec3 u_cardBg;
uniform vec4 u_leave;        // leaving card rect in uv; it floats in front of the water
uniform float u_leaveRadius;
uniform vec3 u_leaveBg;
uniform float u_dist;        // distance from the camera to the rising card's plane
uniform sampler2D u_tex[6];  // the cards' pictures: slots 0-2 rising, 3-5 leaving
uniform vec4 u_rect[6];      // picture rect in card-local fractions: x, y (bottom), w, h; w = 0 when unused
uniform vec4 u_crop[6];      // visible window of the texture: u0, v0, u1, v1

#include <common>

float roundedRect(vec2 p, vec2 halfSize, float r) {
    vec2 q = abs(p) - halfSize + r;
    return length(max(q, 0.0)) + min(max(q.x, q.y), 0.0) - r;
}

// Signed distance to a card's rounded rect, in pixels.
float cardMask(vec2 uv, vec4 card, float radius, float aspect, float pxl) {
    vec2 center = card.xy + card.zw * 0.5;
    vec2 p = vec2((uv.x - center.x) * aspect, uv.y - center.y);
    vec2 halfSize = vec2(card.z * aspect, card.w) * 0.5;
    return roundedRect(p, halfSize, radius) / pxl;
}

// World point to screen uv through the same camera as rayDir().
vec2 project(vec3 p, float aspect) {
    vec3 v = p - vec3(0.0, CAM_HEIGHT, 0.0);
    float c = cos(CAM_PITCH);
    float s = sin(CAM_PITCH);
    vec3 cam = vec3(v.x, v.y * c + v.z * s, -v.y * s + v.z * c);
    vec2 sc = cam.xy / (max(cam.z, 0.001) * CAM_FOV);
    return vec2(sc.x / aspect, sc.y) * 0.5 + 0.5;
}

#define PICTURE(i) if (u_rect[i].z > 0.0) { vec2 q = (local - u_rect[i].xy) / u_rect[i].zw; if (all(greaterThanEqual(q, vec2(0.0))) && all(lessThanEqual(q, vec2(1.0)))) { col = texture2D(u_tex[i], mix(u_crop[i].xy, u_crop[i].zw, q)).rgb; found = 1.0; } }

// The rising card's pictures at screen position uv; alpha 0 where there is none.
vec4 risingPicture(vec2 uv) {
    vec2 local = (uv - u_card.xy) / u_card.zw;
    if (any(lessThan(local, vec2(0.0))) || any(greaterThan(local, vec2(1.0)))) return vec4(0.0);
    vec3 col = vec3(0.0);
    float found = 0.0;
    PICTURE(0) PICTURE(1) PICTURE(2)
    return vec4(col, found);
}

// What a card looks like at screen position uv: its pictures where they sit, its background elsewhere.
vec4 risingColor(vec2 uv) {
    vec2 local = (uv - u_card.xy) / u_card.zw;
    if (any(lessThan(local, vec2(0.0))) || any(greaterThan(local, vec2(1.0)))) return vec4(0.0);
    vec4 picture = risingPicture(uv);
    return vec4(mix(u_cardBg, picture.rgb, picture.a), 1.0);
}

vec4 leavingColor(vec2 uv) {
    vec2 local = (uv - u_leave.xy) / u_leave.zw;
    if (any(lessThan(local, vec2(0.0))) || any(greaterThan(local, vec2(1.0)))) return vec4(0.0);
    vec3 col = u_leaveBg;
    float found = 0.0;
    PICTURE(3) PICTURE(4) PICTURE(5)
    return vec4(col, 1.0);
}

// What the surface at P mirrors along R: the cards where the reflected ray meets their plane, else sky.
vec3 reflectedWorld(vec3 P, vec3 R, vec3 sun, float aspect) {
    vec3 sky = skyColor(R, sun);
    if (R.z < 0.02 || R.y < 0.0) return sky;
    float tr = (u_dist - P.z) / R.z;
    if (tr < 0.0) return sky;
    vec2 q = project(P + R * tr, aspect);
    vec4 c = leavingColor(q);
    if (c.a > 0.0) return c.rgb;
    c = risingColor(q);
    if (c.a > 0.0) return c.rgb;
    return sky;
}

// Swell normal with fine wind ripples on top; the ripples fade with distance so the far water stays glassy.
vec3 waterNormal(vec3 hit, float dist, float t) {
    vec3 n = seaNormal(hit.xz, t, 0.01 + 0.006 * dist);
    vec2 rp = hit.xz * 9.0 + vec2(t * 0.9, -t * 0.6);
    float r0 = vnoise(rp);
    float rx = vnoise(rp + vec2(0.13, 0.0)) - r0;
    float rz = vnoise(rp + vec2(0.0, 0.13)) - r0;
    return normalize(n + vec3(rx, 0.0, rz) * (0.18 / (1.0 + dist * 0.25)));
}

// Premultiplied colour of clear water at `hit`. `path` is how far the ray keeps travelling through
// water before reaching whatever stands behind the surface (the shorter, the clearer), and `under`
// is that thing seen through the surface, premultiplied: a refracted picture of the card, or nothing.
vec4 shadeWater(vec3 rd, vec3 n, vec3 hit, float path, vec4 under, vec3 sun, float aspect) {
    float cosTheta = max(dot(n, -rd), 0.0);
    float fres = 0.14 + 0.86 * pow(1.0 - cosTheta, 3.5);
    vec3 R = reflect(rd, n);
    // The mirror image is looked up along a damped normal: the full one swings the reflected ray so far it marbles.
    vec3 refl = reflectedWorld(hit, reflect(rd, normalize(mix(vec3(0.0, 1.0, 0.0), n, 0.4))), sun, aspect);
    float spec = pow(max(dot(R, sun), 0.0), 200.0);

    vec3 body = mix(vec3(0.02, 0.14, 0.20), vec3(0.08, 0.36, 0.42), clamp(0.2 + hit.y * 2.2, 0.0, 1.0));
    float bodyAlpha = 0.2 + 0.75 * (1.0 - exp(-path * 2.0));

    vec3 col = under.rgb * (1.0 - bodyAlpha) + body * bodyAlpha;
    float alpha = under.a * (1.0 - bodyAlpha) + bodyAlpha;
    col = col * (1.0 - fres) + refl * fres + vec3(1.0, 0.97, 0.9) * spec;
    alpha = alpha * (1.0 - fres) + fres;
    return vec4(col, min(alpha, 1.0));
}

// One sea for the whole viewport: open water and sky around the cards, and in front of the
// rising card only the water that stands between the viewer and the card's plane, so the
// swell itself forms the waterline. The leaving card floats above it all and is cut out.
void main() {
    float aspect = u_res.x / u_res.y;
    vec2 uv = v_uv;
    float pxl = 1.0 / u_res.y;
    float t = u_time;

    float clear = smoothstep(0.0, 1.5, cardMask(uv, u_leave, u_leaveRadius, aspect, pxl));
    if (clear <= 0.0) discard;
    float inside = 1.0 - smoothstep(0.0, 1.5, cardMask(uv, u_card, u_radius, aspect, pxl));

    vec2 sc = vec2((uv.x * 2.0 - 1.0) * aspect, uv.y * 2.0 - 1.0);
    vec3 ro = vec3(0.0, CAM_HEIGHT, 0.0);
    vec3 rd = rayDir(sc);
    vec3 sun = SUN_DIR;
    vec4 horizon = vec4(skyColor(vec3(rd.x, 0.0, rd.z), sun), 1.0);

    vec4 open = horizon;
    if (inside < 1.0) {
        if (rd.y > -0.003) {
            open = vec4(skyColor(rd, sun), 1.0);
        } else {
            float tGround = -CAM_HEIGHT / rd.y;
            vec3 hit;
            float dist;
            if (tGround < 80.0 && trace(ro, rd, tGround * 1.05 + 0.5, t, hit, dist)) {
                vec3 n = waterNormal(hit, dist, t);
                open = mix(shadeWater(rd, n, hit, 1000.0, vec4(0.0), sun, aspect), horizon, smoothstep(8.0, 45.0, dist));
            }
        }
    }

    vec4 front = vec4(0.0);
    if (inside > 0.0) {
        float tCard = u_dist / rd.z;
        float yAtCard = ro.y + rd.y * tCard;   // height of the ray where it meets the card
        if (yAtCard < SEA_MAX) {
            vec3 hit;
            float dist;
            if (trace(ro, rd, tCard, t, hit, dist)) {
                float path = tCard - dist;
                vec3 n = waterNormal(hit, dist, t);

                // The submerged face seen through the surface: its pictures, bent by the ripples.
                vec3 T = normalize(rd + vec3(n.x, 0.0, n.z) * 0.7);
                vec4 under = vec4(0.0);
                if (T.z > 0.01) {
                    vec4 picture = risingPicture(project(hit + T * ((u_dist - hit.z) / T.z), aspect));
                    under = vec4(picture.rgb, 1.0) * picture.a * 0.85;
                }
                front = shadeWater(rd, n, hit, path, under, sun, aspect);

                // Sunlight focused by the ripples plays on the submerged face.
                vec2 cp = hit.xz * 6.0;
                float caustic = pow(vnoise(cp + t * 0.5) * vnoise(cp * 1.3 - t * 0.4 + 3.0), 2.0) * 2.0;
                front.rgb += vec3(0.9, 1.0, 1.0) * caustic * 0.18 * (1.0 - front.a);

                // A thin bright meniscus and a little foam where the surface meets the card.
                float contact = smoothstep(0.08, 0.0, path);
                float churn = fbm3(vec2(sc.x * 9.0 + t * 0.4, hit.z * 4.0 - t * 1.1));
                float foam = contact * clamp(0.5 * (churn - 0.45), 0.0, 1.0);
                float rim = pow(contact, 4.0) * 0.28;
                front.rgb = mix(front.rgb, vec3(0.96), foam) + vec3(1.0) * rim;
                front.a = mix(front.a, 1.0, foam);
            }
        }
    }

    gl_FragColor = mix(open, front, inside) * clear;
}
