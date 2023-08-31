/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                Montserrat: "Montserrat",
            },
            colors: {
                crimson: "tomato",
                tosca: {
                    100: "#d2fbf5",
                    200: "#a5f7eb",
                    300: "#78f3e0",
                    400: "#4befd6",
                    500: "#1eebcc",
                    600: "#18bca3",
                    700: "#128d7a",
                    800: "#0c5e52",
                    900: "#062f29",
                },
                bluesea: {
                    100: "#d0ebfb",
                    200: "#a1d7f8",
                    300: "#71c2f4",
                    400: "#42aef1",
                    500: "#139aed",
                    600: "#0f7bbe",
                    700: "#0b5c8e",
                    800: "#083e5f",
                    900: "#041f2f",
                },
                darkblue: {
                    100: "#d3d7dc",
                    200: "#a8afb9",
                    300: "#7c8695",
                    400: "#515e72",
                    500: "#25364f",
                    600: "#1e2b3f",
                    700: "#16202f",
                    800: "#0f1620",
                    900: "#070b10",
                },
                bluesky: {
                    100: "#d1f1f9",
                    200: "#a2e4f2",
                    300: "#74d6ec",
                    400: "#45c9e5",
                    500: "#17bbdf",
                    600: "#1296b2",
                    700: "#0e7086",
                    800: "#094b59",
                    900: "#05252d",
                },
            },
            fontSize: {
                "2xs": "0.5rem",
            },
            borderRadius: {
                "6xl": " 2.625rem",
                'circle' : '50%'
            },
            boxShadow: {
                'box': "0px 4px 18px 0px rgba(0, 0, 0, 0.25)",
                "custom" : "0px 0px 6px 1px rgba(0, 0, 0, 0.25)",
                'custom-2' : '0px 0px 20px 10px rgba(255,255,255,1)'

            },
            screens:{
                'md' : "1024px"
            },
        },
    },
    plugins: [require("daisyui")],
};
