const EndPoints = class EndPoints {
    /**
     * EndPoints constructor
     *
     * @param baseURL
     * @return {string}
     * @author BaRaa
     */
    constructor(baseURL) {
        this.baseURL = baseURL;
    }

    /**
     *
     * init base api url and endpoints object for specific module
     *
     * @author BaRaa
     */
    init(endPoints) {
        this.endPoints = endPoints;
    }

    /**
     * return request method and url based on route name
     * endpoint called as function with parsed arguments
     *
     * @param $routeName
     * @param args
     * @return {Object}
     * @author BaRaa
     */
    route($routeName, ...args) {
        console.log('this.endPoints this.endPoints', this.endPoints, $routeName, _.get(this.endPoints, $routeName)(...args));
        return _.get(this.endPoints, $routeName) instanceof Function ? _.get(this.endPoints, $routeName)(...args) : {};
    }

    /**
     * Build Rest-full routes functions according to resource
     *
     * @param uri
     * @param others
     * @return {Object}
     * @author BaRaa
     */
    resource(uri, others = {}) {
        return {
            index: ($params) => {
                return this.generateURL('GET', $params, uri);
            },
            store: ($params) => {
                return this.generateURL('POST', $params, uri);
            },
            find: (id) => {
                return this.generateURL('GET', {}, uri, id);
            },
            update: (id) => {
                return this.generateURL('PUT', {}, uri, id);
            },
            status: (id) => {
                return this.generateURL('PATCH', {}, uri, id, 'status');
            },
            multi_delete: ($params) => {
                return this.generateURL('PATCH', $params, uri, 'delete', 'group');
            },
            order: ($params) => {
                return this.generateURL('PATCH', $params, uri, 'order', 'list');
            },
            delete: (id) => {
                return this.generateURL('DELETE', {}, uri, id);
            },
            ...others
        }
    }


    /**
     * Generate EndPoint
     *
     * @param $method
     * @param $params
     * @param args
     * @return {Object}
     * @author BaRaa
     */
    generateURL($method, $params, ...args) {
        let url = this.baseURL;
        url += _.join(args, '/');
        if ($params && Object.entries($params).length > 0)
            url += `?${new URLSearchParams($params).toString()}`;

        return {
            method: $method, // set method from end point object
            url: url
        };
    }
}


const BASE_URI = "/api/seller/";
const instance = new EndPoints(BASE_URI);
const endPoints = {
    auth: {
        login: () => instance.generateURL('POST', {}, 'auth/login')
    },
    home: {
        index: () => instance.generateURL('GET', {}, 'home')
    },
    order: {
        store: () => instance.generateURL('POST', {}, 'order'),
        index: () => instance.generateURL('GET', {}, 'order')
    }
    // booking: {
    //   index: () => instance.generateURL('GET', {}, 'service'),
    //   find: (id) => instance.generateURL('GET', {}, 'service', id),
    // },
    // order: {
    //   index: () => instance.generateURL('GET', {}, 'order'),
    //   edit: (id) => instance.generateURL('POST', {}, 'order',id),
    //   services_calendar: () => instance.generateURL('GET', {}, 'order','services-calendar'),
    //   find: (id) => instance.generateURL('GET', {}, 'order', id),
    //   rejection: (id) => instance.generateURL('GET', {}, 'order', id,'rejection'),
    //   excel: () => instance.generateURL('GET', {}, 'order','excel','export'),
    // },
    // report: {
    //   pdf: (id) => instance.generateURL('GET', {}, 'report','order',id,'pdf',),
    // },
    // constant : {
    //   index: () => instance.generateURL('GET', {}, 'constant'),
    // },
    // destination : {
    //   index: () => instance.generateURL('GET', {}, 'destination'),
    // },
    // user_logged : {
    //   index: () => instance.generateURL('GET', {}, 'seller'),
    // },
};

instance.init(endPoints);
export default instance;

