import {createApp as createClientApp, h, resolveDynamicComponent, Transition} from "vue";
import {RouterView} from 'vue-router';
import {createHead} from '@vueuse/head';
import {createRouter} from '@/router';
import {
  ElAvatar,
  ElButton,
  ElScrollbar,
  ElSkeleton,
  ElSkeletonItem,
  ElRate,
  ElDatePicker,
  ElLoading,
  ElNotification
} from 'element-plus'
import vuetify from './plugins/vuetify'
import 'vuetify/dist/vuetify.min.css'
import {createPinia} from 'pinia';
import {provideApi} from "@/composable/useRequest";
import {usePlugins} from "@/composable/usePlugins";
import useNotify from "@/composable/useNotify";
import {useAuthUser} from "@/stores/user";
import {i18n} from "./i18n";
import {useI18n} from "vue-i18n";

export async function createApp({enhanceApp}) {

  const head = createHead();
  const router = createRouter("/seller");
  const pinia = createPinia();


  const app = createClientApp({
    setup() {


      provideApi();
      usePlugins();
      return () => {

        const defaultSlot = ({Component: _Component}) => {
          const Component = resolveDynamicComponent(_Component);
          return [
            h(
              Transition,
              {name: 'fade-slow', mode: 'out-in'},
              {
                default: () => [h(Component)],
              }
            ),
          ]
        };

        return [
          h(RouterView, null, {
            default: defaultSlot,
          })
        ]
      }
    },
  });
  router.beforeEach((to, from) => {
    const userSession = useAuthUser()
    if (!to.meta.withoutAuth && !userSession.isLoggedIn) {
      let query = {};
      if (to.fullPath !== "/") {
        const notif = useNotify();
        notif.error({
          message: 'لقد إنتهت الجلسة الخاصة بك, يرجى تسجيل الدخول',
          duration: 7000,
        });
        query = {redirect: to.fullPath};
      }

      return {
        name: 'auth.login',
        query
      }
    }
  });

  app.use(head);
  app.use(router);
  app.use(vuetify);
  app.use(i18n);
  app.use(pinia);
  app.use(ElScrollbar);
  app.use(ElButton);
  app.use(ElSkeleton);
  app.use(ElSkeletonItem);
  app.use(ElAvatar);
  app.use(ElDatePicker);
  app.use(ElRate);
  app.use(ElLoading);
 app.component('AlertModal','')

  app.mixin({

    methods: {
      $t: (...args) => {
        // i18n.global.locale;
        return i18n.global.t(...args);
      },
      notify$(title='success',message ,type='success')  {
        ElNotification({
          title:title,
          message: message,
          type: type,
        })
      },
      $get: (...args) => _.get(...args),
      $trans(value, defaultVal = this.$t('no_name_available')) {
        if (typeof value == "object"){
          var ssssssss= _.get(value, i18n?.global?.locale?.value ?? "ar", defaultVal);
          console.log('return',ssssssss)
          return ssssssss;
        }
        return value;
      },
    }
  })

  if (enhanceApp) {
    await enhanceApp(app)
  }

  return {
    app,
    router,
    head,
    pinia,
    i18n
  }
}


