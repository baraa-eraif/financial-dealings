<template>
    <div class="widget__items" v-if="isLoading">
        <Skeleton v-for="i in 6"/>
    </div>

    <card v-for="(items , index) in data$" :item="items" v-if="!isLoading"/>
    <infinite-loading class="text-center" @infinite="infiniteHandler"></infinite-loading>

    <el-affix position="bottom" :offset="40" v-if="!isLoading">
        <el-button type="primary" :icon="Plus" circle class="btn-large" @click="openForm"/>
    </el-affix>
</template>

<script>
import card from './partials/card'
import {useI18n} from "vue-i18n";
import {computed, reactive, ref, watch} from "vue";
import {useApi} from "@/composable/useRequest";
import InfiniteLoading from "v3-infinite-loading";
import {useRouter} from "vue-router";
import {
    Plus,
} from '@element-plus/icons-vue'
import Skeleton from "@/component/Skeleton";

export default {
    name: "List",
    components: {
        card,
        InfiniteLoading,
        Skeleton
    },

    setup: function () {
        const {t, locale} = useI18n();
        const {request, resolveEndPoint} = useApi();
        const data$ = ref([]);
        const page = ref(1);
        const router = useRouter();
        const form = reactive({
            page
        });
        const isLoading = ref(true);

        const infiniteHandler = function ($state) {
            fetch($state);
        };

        const openForm = function () {
            router.push({name: "form"});
        };

        const fetch = function ($state) {
            request(
                resolveEndPoint("order.index"),
                {params: {page: page.value}},
                {
                    success: ({data}) => {
                        if ($state) {
                            if (data.data.length > 0) {
                                $state.loaded();
                                page.value += 1;
                            } else {
                                $state.complete();
                            }
                            data$.value.push(...data.data)
                            isLoading.value = false;
                        }
                        // if (page.value > 1) {
                        //     show_more_btn_loader.value = true;
                        //     data$.value.push(...data.data)
                        // } else
                        //     data$.value = data.data
                        //
                        // paginator$.value = data.paginator
                    },
                    error: () => {
                    },
                }
            );
        };

        fetch();


        // watch(
        //     form,
        //     () => {
        //         fetch();
        //     },
        //     {deep: true}
        // );
        return {
            data$,
            Plus,
            openForm,
            isLoading,
            infiniteHandler
        };
    }
    ,
}
</script>

<style scoped>
#lateral .v-btn--example {
    bottom: 0;
    position: absolute;
    margin: 0 0 16px 16px;
}

.btn-large {
    height: 60px !important;
    width: 60px !important;
    background: #0a53be !important;
}
</style>
