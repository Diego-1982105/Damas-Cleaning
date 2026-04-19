/** Presets compartidos para motion-v (https://motion.dev/docs/vue) */

export const easeOut = [0.22, 1, 0.36, 1];

export const viewportOnce = {
    once: true,
    amount: 0.2,
};

/**
 * Entrada suave al entrar en vista (scroll).
 * @param {number} [delay=0] segundos
 */
export function fadeUp(delay = 0) {
    return {
        initial: { opacity: 0, y: 26 },
        whileInView: { opacity: 1, y: 0 },
        viewport: viewportOnce,
        transition: { duration: 0.55, ease: easeOut, delay },
    };
}

export function fadeIn(delay = 0) {
    return {
        initial: { opacity: 0 },
        whileInView: { opacity: 1 },
        viewport: viewportOnce,
        transition: { duration: 0.45, ease: easeOut, delay },
    };
}

export function scaleIn(delay = 0) {
    return {
        initial: { opacity: 0, scale: 0.94 },
        whileInView: { opacity: 1, scale: 1 },
        viewport: viewportOnce,
        transition: { type: 'spring', stiffness: 380, damping: 28, delay },
    };
}
