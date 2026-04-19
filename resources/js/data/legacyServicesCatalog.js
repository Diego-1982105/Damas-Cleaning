/**
 * Servicios que aparecían en la landing antes del catálogo admin.
 * Se fusionan con GET /api/services (sin duplicar por nombre) y sirven de respaldo si la API falla o viene vacía.
 */
export const LEGACY_CATALOG_SERVICES = [
    {
        name: 'Standard cleaning',
        price: 129,
        description:
            'Consistent visits with a checklist tuned to your home — kitchens, baths, living areas, and the details you care about most.',
    },
    {
        name: 'Deep cleaning',
        price: 229,
        description:
            'A full reset for built-up grime, baseboards, appliances, and hard-to-reach spots — ideal before guests or a new season.',
    },
    {
        name: 'Move-in / move-out cleaning',
        price: 249,
        description:
            'Empty-home focus: inside cabinets, closets, and surfaces so the space is ready for keys, photos, or your next chapter.',
    },
    {
        name: 'Post-renovation cleaning',
        price: 279,
        description:
            'Dust control and detail work after contractors leave — floors, fixtures, and finishes without scratching new surfaces.',
    },
    {
        name: 'Recurring maintenance',
        price: 119,
        description:
            'Weekly or bi-weekly rhythm so your home stays guest-ready with less weekend catch-up.',
    },
];

function normalizeServiceName(name) {
    return String(name ?? '')
        .trim()
        .toLowerCase();
}

function legacyKey(name) {
    const slug = normalizeServiceName(name).replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    return slug ? `legacy-${slug}` : 'legacy-unknown';
}

/**
 * @param {Array<{ id: number|string, name: string, price: string|number }>} apiRows
 * @returns {Array<{ id: number|string, name: string, price: string|number, description?: string }>}
 */
export function mergeServicesCatalog(apiRows) {
    const apiList = Array.isArray(apiRows) ? apiRows : [];
    const seen = new Set(apiList.map((r) => normalizeServiceName(r.name)));

    const merged = apiList.map((r) => {
        const leg = LEGACY_CATALOG_SERVICES.find((l) => normalizeServiceName(l.name) === normalizeServiceName(r.name));
        return {
            ...r,
            description: leg?.description,
        };
    });

    for (const leg of LEGACY_CATALOG_SERVICES) {
        const key = normalizeServiceName(leg.name);
        if (seen.has(key)) {
            continue;
        }
        merged.push({
            id: legacyKey(leg.name),
            name: leg.name,
            price: leg.price,
            description: leg.description,
        });
        seen.add(key);
    }

    return merged;
}
