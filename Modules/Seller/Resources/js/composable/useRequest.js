import {inject, provide} from 'vue'
import axios from 'axios'
import {useAuthUser} from '@/stores/user'

export const apiSymbol = Symbol();

export function provideApi() {
    const api = axios.create({
        // baseURL: "https://test.pazarcpdeveloper.com"
    });

    api.interceptors.request.use((config) => {
        const {locale,token, isLoggedIn} = useAuthUser();

        if (isLoggedIn) {
            config.headers = {
                ...config.headers,
                Authorization: `Bearer ${token}`,
              Language: locale,
            }
        }

        return config
    });
    provide(apiSymbol, api);
    return api
}

export function useApi() {
    const api = inject(apiSymbol);
    const $endPoints = inject("$endPoints");

    if (!api || !$endPoints)
        throw new Error('Api not properly injected in app');

    const resolveEndPoint = (...args) => $endPoints.route(...args);

    const fireCallback = function (callbacks, callbackName, ...args) {
        let callback = callbacks?.[callbackName];
        if (callback instanceof Function)
            return callback(...args);
        return callback;
    };
    const request = function ({method, url, header}, data, callbacks = {}) {
        return api[method.toLowerCase()](url, data, header)
            .then((response) => {
                if (response.data.status)
                    fireCallback(callbacks, 'success', response);
                else
                    fireCallback(callbacks, 'error', response);

            })
            .catch((xhr) => {
                fireCallback(callbacks, 'error', xhr);
            }).finally(fireCallback(callbacks, 'finally'));
    };


    return {
        request,
        resolveEndPoint,
        api
    }
}
