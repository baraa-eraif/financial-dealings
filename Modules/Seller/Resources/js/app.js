import {createApp} from '@/bootstrap';
import endPoints from '@/endPoints';

createApp({
    async enhanceApp(app) {
        app.provide("$endPoints", endPoints);
    },
}).then(async ({app, router}) => {
    await router.isReady();
    app.mount('#app');
});
