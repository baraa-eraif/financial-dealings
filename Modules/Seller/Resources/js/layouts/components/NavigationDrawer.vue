<template>
    <v-navigation-drawer floating app temporary fixed v-model="showMenu">
        <el-menu
            default-active="2"
            class="el-menu-vertical-demo"
        >
<!--            @open="handleOpen"-->
<!--            @close="handleClose"-->
            <el-card shadow="always">
            <div class="demo-type">
                <el-col :span="8">
                <el-avatar :size="60">
                    <img src="/assets/seller/images/user-icon.png"/>
                </el-avatar>
                </el-col>
                <el-col :span="8" class="float-end">
                    <h4>مرحبا </h4>
                </el-col>
            </div>
            </el-card>
<!--            <el-sub-menu index="1">-->
<!--                <template #title>-->
<!--                    <el-icon><location /></el-icon>-->
<!--                    <span>Navigator One</span>-->
<!--                </template>-->
<!--                <el-menu-item-group title="Group One">-->
<!--                    <el-menu-item index="1-1">item one</el-menu-item>-->
<!--                    <el-menu-item index="1-2">item two</el-menu-item>-->
<!--                </el-menu-item-group>-->
<!--                <el-menu-item-group title="Group Two">-->
<!--                    <el-menu-item index="1-3">item three</el-menu-item>-->
<!--                </el-menu-item-group>-->
<!--                <el-sub-menu index="1-4">-->
<!--                    <template #title>item four</template>-->
<!--                    <el-menu-item index="1-4-1">item one</el-menu-item>-->
<!--                </el-sub-menu>-->
<!--            </el-sub-menu>-->
            <el-menu-item  v-for="(item , index) in menu" :key="item.key" :index="index"  @click="page(item)">
<!--                <el-icon><icon-menu /></el-icon>-->
                <span>{{ item.label }}</span>
            </el-menu-item>
<!--            <el-menu-item index="3" disabled>-->
<!--                <el-icon><document /></el-icon>-->
<!--                <span>Navigator Three</span>-->
<!--            </el-menu-item>-->
<!--            <el-menu-item index="4">-->
<!--                <el-icon><setting /></el-icon>-->
<!--                <span>Navigator Four</span>-->
<!--            </el-menu-item>-->
        </el-menu>
<!--        <v-list-item>-->
<!--            <v-list-item-content>-->
<!--                <v-list-item-title class="title">-->
<!--                    Application-->
<!--                </v-list-item-title>-->
<!--                <v-list-item-subtitle>-->
<!--                    subtext-->
<!--                </v-list-item-subtitle>-->
<!--            </v-list-item-content>-->
<!--        </v-list-item>-->

<!--        <v-divider></v-divider>-->

<!--        <v-list-->
<!--            dense-->
<!--            rounded-->
<!--        >-->
<!--            <v-list-item-->
<!--                v-for="item in menu"-->
<!--                :key="item.key"-->
<!--                @click="page(item)"-->
<!--            >-->
<!--                <v-list-item-icon>-->
<!--                    <v-icon>{{ item.icon }}</v-icon>-->
<!--                </v-list-item-icon>-->

<!--                <v-list-item-content>-->
<!--                    <v-list-item-title>{{ item.label }}</v-list-item-title>-->
<!--                </v-list-item-content>-->
<!--            </v-list-item>-->
<!--        </v-list>-->
    </v-navigation-drawer>
</template>

<script>
import menu from "@/config/menu";
import {useRouter} from "vue-router";

export default {
    name: "NavigationDrawer",
    setup(props) {
        const router = useRouter();

        const page = function (item) {
            const route = _.get(item,'to.name','dashboard');
            router.push({name: route});
        };
        return {
            menu,
            page
        }
    },
    props: {
        showMenu: {
            default: false,
        }
    },
    //   computed: {
    //       menu() {
    //          return menu;
    //       }
    //   },
    // methods : {
    //     page(item) {
    //         console.log('item',item)
    //         // localStorage.setItem("page", JSON.stringify(item));
    //         // this.$router.push({name: "content"});
    //     },
    // }
}
</script>

<style scoped>

</style>
