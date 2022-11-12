<template>
  <div class="asid-right bg-light py-5  "  :class="{active:active}">
    <div class="btn-close-aside d-lg-none " @click="close"><i class="fas fa-times" ></i></div>
    <div class="logo text-center mb-5">
      <img src="/assets/seller/images/logo-header.png" alt=""/>
    </div>
    <ul class="menu">
      <li v-for="({ to , icon , label ,show, ...item} ,index) in filtered_types" :class="['menu-item' , index === 0 && ' mb-5 mt-3 pb-2' , item.class]">
        <router-link v-if="isVisible( item )" :to="to" :class="['menu-link']" exact-active-class="active">
          <span class="menu-text">
            {{ $t(label) }}
          </span>
          <img :src="icon" alt=""/>
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import {computed, reactive, ref, onMounted ,defineEmits} from "vue";
import {useAuthUser} from "@/stores/user";
import {useAppSession} from "@/stores/app";

export default {
  name: "Sidebar",
  setup() {
    const appSession = useAppSession();
    const authUser = useAuthUser();

    const active = ref(false);
    const types = computed(() => {
      return Array.from(_.get(authUser.user, 'types', []));
    });

    const user_types = _.get(authUser.user, 'types', []);

    const isVisible =  (item)=> {
      return types.value.includes(item.key) || item.key === 'dashboard'
    };

    const close =  ()=> {
       active.value = false ;

    };
    const open =  ()=> {
      active.value = true
    };

    onMounted(() => {
      console.log('useAppSession' , appSession.setSlideMenu)
     // alert(useAppSession.slidBarMenu)
    })
    const items = reactive([
      {
        class: "",
        key : "dashboard",
        label: "dashboard",
        show: true,
        icon: "/assets/seller/images/svg/dashboard.svg",
        to: {
          name: "dashboard"
        },
      },
      {
        class: "",
        key : "daily",
        label: "daily",
        icon: "/assets/seller/images/svg/balloon-small.svg",
        to: {
          name: "booking",
          params: {
            type: "daily"
          }
        },

      },
      {
        class: "bg-green",
        key : "airport",
        label: "airport",
        icon: "/assets/seller/images/svg/airplain-small.svg",
        to: {
          name: "booking",
          params: {
            type: "airport"
          }
        }
      },
      {
        class: "bg-orage",
        key : "private_car",
        label: "private_car",
        icon: "/assets/seller/images/svg/car-small.svg",
        to: {
          name: "booking",
          params: {
            type: "private_car"
          }
        }
      },
      {
        class: "",
        key : "tour_packages",
        label: "tour_packages",
        icon: "/assets/seller/images/svg/balloon-small.svg",
        to: {
          name: "booking",
          params: {
            type: "tour_packages"
          }
        },

      },
    ]);

    // return _.filter(items, function (item) {
    //   console.log('typessssss',user_types,item,user_types.includes(item.key))
    //
    //   // return option.key === "TRIP_SERVICE_TYPE" && option.parent_id != null;
    // });

    const filtered_types = computed(() => {
      return _.filter(items, function (item) {
       return  user_types.includes(item.key) || item.key === 'dashboard';
      });
    });
    return {
      items,
      types,
      filtered_types,
      isVisible,
      active,
      close,
      open,
    }
  },
  created() {

  },
}
</script>

<style>
a.router-link-active.router-link-exact-active.menu-link.active {
  background-color: #007DFA;
  box-shadow: 0px 6px 9px #007dfa40;
}
</style>
