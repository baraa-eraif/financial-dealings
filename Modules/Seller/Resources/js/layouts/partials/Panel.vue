<template>
  <div class="asid-left bg-light py-5" :class="{active:active}">
    <div class="btn-close-aside d-lg-none"  @click="close"><i class="fas fa-times"></i></div>
    <div class="d-flex align-items-center justify-content-between mb-5">
      <a
        class="bg-white d-flex rounded-pill logout font-bold px-3"
        href="javascript:;"
        @click="logout"
      >{{ $t("exit") }}
        <img
          class="me-3"
          src="/assets/seller/images/svg/logout.svg"
          alt=""
        />
      </a>
      <el-select
        v-model="$i18n.locale"
        @update:modelValue="onUpdate"
        class="select-lang rounded-pill"
        placeholder="العربية"
        size="large"
      >
        <el-option
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>
      <a class="image-profile" href="">
        <img src="/assets/seller/images/user-icon.png" alt=""/>
      </a>
    </div>
    <div class="panel-container">
<!--      <BookingPanel/>-->
    </div>
  </div>
</template>

<script>
  import BookingPanel from "@/components/booking/Index";
  import {useAuthUser} from "@/stores/user";
  import {useAppSession} from "@/stores/app";
  import {useRouter} from "vue-router";
  import {useI18n} from "vue-i18n";
  import {ref, onMounted} from 'vue' ;

  export default {
    name: "Panel",
    components: {
      BookingPanel,
    },
    setup() {
      const {t, locale} = useI18n({useScope: "global"});

      const options = [
        {
          value: "ar",
          label: "العربية",
        },
        {
          value: "en",
          label: "English",
        },
      ];
      const authUser = useAuthUser();
      const appSession = useAppSession();
      const router = useRouter();
      const active = ref(false);
      const onUpdate = function (locale) {
        authUser.setLocale(locale);

        let direction = locale === "ar" ? "rtl" : "ltr";
        document.querySelector("html").setAttribute("dir", direction);
        document.querySelector("body").setAttribute("dir", direction);
      };

      const logout = function () {
        authUser.setAuth({
          access_token: null,
          auth: null,
        });
        appSession.resetApp();
        router.push({name: "auth.login"});
      };
      const open =  ()=> {
        active.value = true
      };

      const close =  ()=> {
        active.value = false ;

      };
      // onMounted(() => {
      //   this.$root.$off('toggle-menu');
      //   this.$root.$on('toggle-menu', function () {
      //     alert("sssccc")
      //   }.bind(this));
      //
      // })

      return {
        logout,
        onUpdate,
        options,
        t,
        locale,
        open,
        close,
        active,
      };
    },
    // methods: {
    //     logout() {
    //         this.$router.push({name: "auth.login"});
    //     }
    // }
  };
</script>

<style>
  .el-select.select-lang {
    width: 120px !important;
  }

  .el-select.select-lang .el-input__inner {
    border: 0;
    border-radius: 500px;
    padding: 15px;
  }
</style>
