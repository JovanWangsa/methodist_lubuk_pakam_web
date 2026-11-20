/**
 * Konfigurasi Tailwind CSS 3.4, disalin persis dari blok `tailwind.config` hasil ekspor
 * Google Stitch (sama di Hal. 1, 2, 3). Jangan ubah nilai tema di sini tanpa mengubah desain
 * di Stitch: semua warna, font, ukuran, dan spacing di view bergantung pada nilai ini.
 *
 * @type {import('tailwindcss').Config}
 */
export default {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
        './public/js/**/*.js',
        './database/data/**/*.json',
    ],
    theme: {
        extend: {
        "colors": {
            "on-secondary-container": "#663500",
            "on-tertiary-container": "#4ebdb0",
            "surface": "#faf8ff",
            "primary": "#00236f",
            "on-surface-variant": "#444651",
            "background": "#faf8ff",
            "secondary-fixed": "#ffdcc3",
            "surface-container": "#eaedff",
            "on-secondary-fixed-variant": "#6e3900",
            "tertiary": "#00312c",
            "surface-bright": "#faf8ff",
            "on-primary-container": "#90a8ff",
            "on-primary": "#ffffff",
            "primary-fixed-dim": "#b6c4ff",
            "on-primary-fixed-variant": "#264191",
            "error-container": "#ffdad6",
            "on-secondary": "#ffffff",
            "surface-container-high": "#e2e7ff",
            "primary-container": "#1e3a8a",
            "error": "#ba1a1a",
            "on-secondary-fixed": "#2f1500",
            "secondary-container": "#fe932c",
            "inverse-primary": "#b6c4ff",
            "surface-container-highest": "#dae2fd",
            "outline": "#757682",
            "on-tertiary": "#ffffff",
            "on-background": "#131b2e",
            "inverse-surface": "#283044",
            "surface-dim": "#d2d9f4",
            "secondary": "#904d00",
            "outline-variant": "#c5c5d3",
            "surface-tint": "#4059aa",
            "surface-container-low": "#f2f3ff",
            "tertiary-fixed": "#89f5e7",
            "inverse-on-surface": "#eef0ff",
            "on-error": "#ffffff",
            "surface-variant": "#dae2fd",
            "secondary-fixed-dim": "#ffb77d",
            "tertiary-fixed-dim": "#6bd8cb",
            "surface-container-lowest": "#ffffff",
            "tertiary-container": "#004942",
            "on-error-container": "#93000a",
            "on-primary-fixed": "#00164e",
            "primary-fixed": "#dce1ff",
            "on-tertiary-fixed-variant": "#005049",
            "on-tertiary-fixed": "#00201d",
            "on-surface": "#131b2e"
        },
        "borderRadius": {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
        },
        "spacing": {
            "gutter-mobile": "1rem",
            "margin-tablet": "2rem",
            "margin": "3rem",
            "gutter": "1.5rem",
            "space-lg": "1.5rem",
            "space-xs": "0.25rem",
            "space-md": "1rem",
            "space-sm": "0.5rem",
            "margin-mobile": "1.25rem",
            "space-xl": "2.5rem"
        },
        "fontFamily": {
            "display-hero": [
                "Plus Jakarta Sans"
            ],
            "body-md": [
                "Plus Jakarta Sans"
            ],
            "display-hero-mobile": [
                "Plus Jakarta Sans"
            ],
            "label-lg": [
                "Inter"
            ],
            "headline-lg-mobile": [
                "Plus Jakarta Sans"
            ],
            "headline-md": [
                "Plus Jakarta Sans"
            ],
            "label-md": [
                "Inter"
            ],
            "body-sm": [
                "Plus Jakarta Sans"
            ],
            "body-lg": [
                "Plus Jakarta Sans"
            ],
            "headline-sm": [
                "Plus Jakarta Sans"
            ],
            "label-sm": [
                "Inter"
            ],
            "headline-lg": [
                "Plus Jakarta Sans"
            ]
        },
        "fontSize": {
            "display-hero": [
                "56px",
                {
                    "lineHeight": "64px",
                    "letterSpacing": "-0.03em",
                    "fontWeight": "800"
                }
            ],
            "body-md": [
                "16px",
                {
                    "lineHeight": "24px",
                    "letterSpacing": "0",
                    "fontWeight": "400"
                }
            ],
            "display-hero-mobile": [
                "36px",
                {
                    "lineHeight": "44px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "800"
                }
            ],
            "label-lg": [
                "14px",
                {
                    "lineHeight": "20px",
                    "letterSpacing": "0.01em",
                    "fontWeight": "600"
                }
            ],
            "headline-lg-mobile": [
                "28px",
                {
                    "lineHeight": "36px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "700"
                }
            ],
            "headline-md": [
                "28px",
                {
                    "lineHeight": "36px",
                    "letterSpacing": "-0.015em",
                    "fontWeight": "700"
                }
            ],
            "label-md": [
                "12px",
                {
                    "lineHeight": "16px",
                    "letterSpacing": "0.02em",
                    "fontWeight": "600"
                }
            ],
            "body-sm": [
                "14px",
                {
                    "lineHeight": "20px",
                    "letterSpacing": "0",
                    "fontWeight": "400"
                }
            ],
            "body-lg": [
                "18px",
                {
                    "lineHeight": "28px",
                    "letterSpacing": "0",
                    "fontWeight": "400"
                }
            ],
            "headline-sm": [
                "20px",
                {
                    "lineHeight": "28px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "600"
                }
            ],
            "label-sm": [
                "11px",
                {
                    "lineHeight": "14px",
                    "letterSpacing": "0.03em",
                    "fontWeight": "500"
                }
            ],
            "headline-lg": [
                "40px",
                {
                    "lineHeight": "48px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "700"
                }
            ]
        }
    },
    },
    plugins: [],
};
