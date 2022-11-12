import {
    createRouter as createClientRouter,
    createWebHistory,
} from 'vue-router'
// import * as NProgress from 'nprogress'
import routes from './routes'

export function createRouter(base) {
    const router = createClientRouter({

        /**
         * If you need to serve vuero under a subdirectory,
         * you have to set the name of the directory in createWebHistory here
         * and update "base" config in vite.config.ts
         */
        // history: createWebHistory('my-subdirectory'),
        history: createWebHistory(base),
        routes,
    });

    /**
     * Handle NProgress display on page changes
     */
    router.beforeEach(() => {
        // NProgress.start()
    })
    router.afterEach(() => {
        // NProgress.done()
    })

    return router
}
