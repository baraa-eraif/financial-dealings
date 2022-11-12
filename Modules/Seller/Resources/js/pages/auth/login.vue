<template>
    <div class="login-form">
        <h3 class="text-primary font-bold">{{ t('sign_in') }}</h3>
        <h6 class="font-12">{{ t('sign_in_message') }}</h6>
        <form class="mt-5" action="">
            <div class="form-group">
                <div class="input-icon">
                    <input class="form-control font-bold"
                           v-model="form.mobile"
                           type="text"
                           :placeholder="t('mobile_number')"/>
                    <div class="icon">
                        <img src="/assets/seller/images/svg/user.svg" alt=""/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-icon">
                    <input class="form-control font-bold"
                           v-model="form.password"
                           type="password"
                           :placeholder="t('password')"/>
                    <div class="icon">
                        <img src="/assets/seller/images/svg/padlock.svg" alt=""/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <el-button type="primary"
                           class="btn btn-primary w-100 font-bold"
                           :loading="loading"
                           round
                           @click.prevent="login">
                    {{ t('sign_in') }}
                </el-button>
            </div>
        </form>
    </div>
</template>

<script>
    import {reactive, ref} from "vue";
    import {useRouter} from "vue-router";
    import {useAuthUser} from "@/stores/user";
    import {useApi} from "@/composable/useRequest";
    import useNotify from "@/composable/useNotify";
    import {useI18n} from "vue-i18n";
    export default {
        name: "Login",
        setup() {
            const notify = useNotify();
            const form = reactive({mobile: "", password: ""});
            const loading = ref(false);
            const router = useRouter();
            const {setAuth} = useAuthUser();
            const authUser = useAuthUser();
            const {request, resolveEndPoint} = useApi();
            const { t ,locale } = useI18n();
            authUser.setLocale('ar');

            const login = () => {
                loading.value = true;
                request(
                    resolveEndPoint('auth.login'),
                    form,
                    {
                        success: ({data}) => {
                            setAuth(data.data);
                            notify.success(data.message);
                            router.push({name: "dashboard"});
                        },
                        error: (xhr) => {
                            let message = _.get(xhr,'data.message','unknown error');
                            notify.error(message);
                        },
                        finally: () => {
                            setTimeout(() => {
                                loading.value = false;
                            }, 1000);
                        }
                    }
                );

            };

            return {
                loading,
                form,
                login,
              t,locale
            }
        }
    }
</script>

<style scoped>

</style>
