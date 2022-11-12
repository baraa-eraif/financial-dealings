<template>
    <div class="app-page">
        <div class="login bg-white vh-100">
            <div class="row g-0">
                <div class="col-lg-4 d-flex align-items-center justify-content-center">
                    <div class="content-login">
                        <div class="logo text-center mb-5">
                            <img src="/assets/seller/images/logo.png" alt=""/>
                        </div>
                        <RouterView></RouterView>
                    </div>
                </div>
                <div class="col-lg-8 d-lg-block d-none">
                    <div class="login-image"><img class="w-100 vh-100" src="/assets/seller/images/bg-login.png" alt=""/></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Auth"
    }
</script>

<style scoped>

</style>
