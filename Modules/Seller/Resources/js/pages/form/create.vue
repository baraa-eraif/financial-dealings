<template>
    <el-form :model="form" label-position="top" size="large" class="rounded-pill">
        <el-form-item label="Name">
            <el-input v-model="form.name"/>
        </el-form-item>
        <el-form-item label="Price">
            <el-input v-model="form.price"/>
        </el-form-item>
        <el-form-item label="transportation">
            <el-input v-model="form.transportation"/>
        </el-form-item>
        <el-form-item label="transportation">
            <el-input
                v-model="form.note"
                :rows="5"
                type="textarea"
                placeholder="Please input"
            />
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="onSubmit">Create</el-button>
            <el-button @click="cancelForm">Cancel</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
import {computed, reactive, ref, watch} from "vue";
import {useApi} from "@/composable/useRequest";
import {useI18n} from "vue-i18n";
import {useAppSession} from "@/stores/app";
import {useRouter} from "vue-router";

export default {
    name: "Index",


    setup: function () {
        const {t, locale} = useI18n();
        const appSession = useAppSession();
        const {request, resolveEndPoint} = useApi();
        const router = useRouter();
        const form = reactive({
            name: "",
            price: "",
            transportation: "",
            note: "",
        });


        const onSubmit = function () {
            request(
                resolveEndPoint("order.store"),
                form,
                {
                    success: ({data}) => {
                        router.push({name: "list"});
                    },
                    error: () => {
                    },
                }
            );
        };
        const cancelForm = function () {
            router.go(-1);
        };
        return {
            form,
            cancelForm,
            onSubmit
        };
    },
};
</script>
<style lang="scss">
.rounded-pill {
    padding: 5px;

    .el-input .el-input__inner {
        border-radius: 20px;
    }

}
</style>
