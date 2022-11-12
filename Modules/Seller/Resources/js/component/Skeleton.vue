<template>
  <el-skeleton loading animated>
    <template #template>
      <div class="widget-card widget-3 bg-white d-flex align-items-center">
        <div class="widget-content col">
          <el-skeleton-item variant="text" style="width: 100%"/>
          <el-skeleton-item variant="text" style="width: 100%"/>
          <div class="row g-0">
            <div class="col">
              <el-skeleton-item variant="text" style="width: 100%"/>
            </div>
          </div>
        </div>
      </div>
    </template>
  </el-skeleton>
</template>

<script>

export default {
  name: "SkeletonCalendar",

}
</script>

<style>
.el-skeleton__item.el-skeleton__image.widget-image.col-auto {
    height: 66px;
    border-radius: 5px;
    margin-right: 15px;
}
</style>
