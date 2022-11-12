<template>
    <el-card shadow="hover" style="margin-bottom: 10px">
        <div class="col">
            <div class="widget-content">
                <div class="row">
                    <h1 class="font-bold">
                        {{ item.name }}
                    </h1>
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="col">
                                <h5 class="font-bold">
                                    Title
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h6 class="font-bold text-success font-16 text-center">dsadas</h6>
                    </div>
                </div>
            </div>
        </div>
    </el-card>
</template>

<script>
export default {
    name: "card",
    props : {
        item : {
            default : {},
            type : Object
        }
    }
}
</script>

<style scoped>

</style>
