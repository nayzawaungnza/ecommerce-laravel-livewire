import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/assets/css/bootstrap.min.css",
                "resources/assets/css/all.min.css",
                "resources/assets/css/animate.css",
                "resources/assets/css/magnific-popup.css",
                "resources/assets/css/meanmenu.css",
                "resources/assets/css/swiper-bundle.min.css",
                "resources/assets/css/nice-select.css",
                "resources/assets/css/main.css",
                "resources/assets/js/jquery-3.7.1.min.js",
                "resources/assets/js/viewport.jquery.js",
                "resources/assets/js/bootstrap.bundle.min.js",
                "resources/assets/js/jquery.nice-select.min.js",
                "resources/assets/js/jquery.waypoints.js",
                "resources/assets/js/jquery.counterup.min.js",
                "resources/assets/js/swiper-bundle.min.js",
                "resources/assets/js/jquery.meanmenu.min.js",
                "resources/assets/js/jquery.magnific-popup.min.js",
                "resources/assets/js/wow.min.js",
                "resources/assets/js/main.js",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
