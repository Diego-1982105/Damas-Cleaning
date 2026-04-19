import { mergeServicesCatalog } from '../data/legacyServicesCatalog';

/**
 * Catálogo de servicios (GET /api/services + respaldo legacy). Una sola petición por carga de página.
 */
let inflight = null;

export async function fetchServicesCatalog() {
    if (!inflight) {
        inflight = fetch('/api/services', {
            headers: { Accept: 'application/json' },
            credentials: 'same-origin',
        })
            .then((res) => {
                if (!res.ok) {
                    return [];
                }
                return res.json();
            })
            .then((json) => (Array.isArray(json?.data) ? json.data : []))
            .then((rows) => mergeServicesCatalog(rows))
            .catch(() => mergeServicesCatalog([]));
    }

    return inflight;
}
