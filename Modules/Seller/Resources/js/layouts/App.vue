<template>
    <!-- App.vue -->

    <v-app>

        <NavigationDrawer :showMenu="showMenu" :right="right"/>
        <v-app-bar
            app
            fixed
            dark
        >
            <v-app-bar-nav-icon @click.stop="toggleMenu"></v-app-bar-nav-icon>

            <v-toolbar-title class="me-3">{{ routeName }}</v-toolbar-title>

        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

                <!-- If using vue-router -->
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            <!-- -->
        </v-footer>
    </v-app>
</template>

<script>
import NavigationDrawer from "./components/NavigationDrawer";
import {useRouter} from "vue-router";
import {ref,computed} from "vue";

export default {
    name: 'App',
    components: {
        NavigationDrawer
    },
    setup: function () {
        const right = ref(null);
        const drawer = ref(null);
        const showMenu = ref(false);
        const router = useRouter();

        const routeName = computed(() => {
            return _.get(router, 'currentRoute.value.name')
        });

        const toggleMenu = function () {
            showMenu.value = !showMenu.value;
        };

        return {
            right,
            drawer,
            routeName,
            showMenu,
            toggleMenu,
        }
    },
    // methods :{
    //     toggleMenu() {
    //         this.showMenu = !this.showMenu;
    //     },
    // }
};
</script>
