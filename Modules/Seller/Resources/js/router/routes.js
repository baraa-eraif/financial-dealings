export default [
    {
        path: "/",
        component: () => import("../layouts/App"),
        children: [
            {
                path: "dashboard",
                name: "dashboard",
                component: () => import("../pages/dashboard"),
            },
            {
                path: "list",
                name: "list",
                component: () => import("../pages/form/List"),
            },
            {
                path: "form",
                name: "form",
                component: () => import("../pages/form/create"),
            },
            // {
            //     path: ":type/booking",
            //     name: "booking",
            //     component: () => import("../pages/booking/index"),
            // },
            // {
            //     path: ":id/trip",
            //     name: "trip.show",
            //     component: () => import("../pages/trip/index"),
            // }
        ]
    },
    {
        path: "/auth",
        component: () => import("../layouts/Auth"),
        children: [
            {
                path: "login",
                name: "auth.login",
                meta : {
                    withoutAuth : true
                },
                component: () => import("../pages/auth/login"),
            }
        ]
    },
];
