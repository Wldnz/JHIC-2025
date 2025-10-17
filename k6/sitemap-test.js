import http from 'k6/http';
import { check, sleep } from 'k6';

const baseHostname = 'http://localhost:8000';

// Semua URL dari sitemap.xml (versi terbaru)
const urls = [
    `${baseHostname}/`,
    `${baseHostname}/profile`,
    `${baseHostname}/uniforms`,
    `${baseHostname}/visi-misi`,
    `${baseHostname}/galleries`,
    `${baseHostname}/facilities`,
    `${baseHostname}/news`,
    `${baseHostname}/majors/animation`,
    `${baseHostname}/majors/broadcasting`,
    `${baseHostname}/majors/visual-communication-design`,
    `${baseHostname}/majors/software-engineering`,
    `${baseHostname}/majors/network-engineering`,
    `${baseHostname}/majors/game-development`,
    `${baseHostname}/programs/program-silang`,
    `${baseHostname}/programs/baca-tulis-quran`,
    `${baseHostname}/programs/bimbingan-konseling`,
    `${baseHostname}/programs/extracurriculars`,
    `${baseHostname}/programs/program-kecakapan-hidup`,
    `${baseHostname}/programs/project-works`,
    `${baseHostname}/programs/bi-channel`,
];

// Konfigurasi test
export const options = {
    stages: [
        { duration: '30s', target: 100 },
        { duration: '1m', target: 1000 },
        { duration: '2m', target: 1000 },
        { duration: '30s', target: 0 },
    ],
    thresholds: {
        http_req_failed: ['rate<0.01'],    // <1% error
        http_req_duration: ['p(95)<800'],  // 95% request <800ms
    },
};

// default timeout kalau URL nggak ada di map
const DEFAULT_TIMEOUT = '10s';

// Fungsi utama untuk tes acak antar URL
export default function () {
    // const url = urls[Math.floor(Math.random() * urls.length)];
    // const res = http.get(url);

    // check(res, {
    //     'status is 200': (r) => r.status === 200,
    //     'body not empty': (r) => r.body && r.body.length > 0,
    // });

    // sleep(1);

    const batch = urls.map(u => {
        const params = {
            timeout: DEFAULT_TIMEOUT,
            tags: { url: u },
        };
        return ['GET', u, null, params];
    })

    const responses = http.batch(batch);

    for (let i = 0; i < responses.length; i++) {
        const res = responses[i];
        const url = urls[i];

        // basic checks
        check(res, {
            [`${url} status 200`]: (r) => r && r.status === 200,
            [`${url} duration < timeout`]: (r) => {
                // r.timings.duration in ms, kita bandingkan dengan timeout convert ke ms
                const timeoutStr = DEFAULT_TIMEOUT.toLowerCase();
                const timeoutMs = parseTimeoutToMs(timeoutStr);
                return r && r.timings && r.timings.duration <= timeoutMs;
            },
        });
    }

    sleep(2);
}

/**
 * helper: konversi string timeout seperti "2s", "500ms", "1m" -> milliseconds (number)
 * mendukung ms, s, m (menit)
 */
function parseTimeoutToMs(t) {
    if (!t || typeof t !== 'string') return 0;
    const v = t.trim().toLowerCase();

    if (v.endsWith('ms')) {
        return Number(v.slice(0, -2)) || 0;
    } else if (v.endsWith('s')) {
        return (Number(v.slice(0, -1)) || 0) * 1000;
    } else if (v.endsWith('m')) {
        return (Number(v.slice(0, -1)) || 0) * 60 * 1000;
    } else {
        // asumsi ms kalau cuma angka
        return Number(v) || 0;
    }
}
