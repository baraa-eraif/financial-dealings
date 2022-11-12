import {defineStore} from 'pinia'
import {useApi} from '@/composable/useRequest'

export const useAppSession = defineStore('appData', {
  state: () => {
    return {
      data: {},
      loading: true,
      dialog: {
        show: false
      },
      config:{}
    }
  },


  getters: {
    isLoading(state) {
      return state.loading;
    },
    todayReservations(state) {
      return _.get(state.data, 'today_reservations', [])
    },
    statistics(state) {
      return _.get(state.data, 'statistics', [])
    },
    tripsClassifications(state) {
      return _.get(state.data, 'types_with_trips', []);
    },
    userAuthenticated(state) {
      return _.get(state.data, 'user_auth', [])
    },
    dialogConfig(state) {
      return _.get(state, 'dialog', {
        show: false
      });
    } ,
    panelMenu(state) {
      return _.get(state.config, 'panel_menu',false);
    }
,
    slidBarMenu(state) {
      return _.get(state.config, 'slid_bar_menu',true);
    }


  },
  actions: {

    setPanelMenu(newVal) {
      this.config.panel_menu = newVal ;
    }
    , setSlideMenu(newVal) {
      this.config.slid_bar_menu = newVal ;
    }
    ,
    fetch({request, resolveEndPoint} = useApi()) {
      // const {request, resolveEndPoint} = useApi();
      request(
        resolveEndPoint('home.index'),
        {params: {for_web: true}},
        {
          success: ({data}) => {
            this.data = data?.data;
            this.loading = false;

          },
          finally: () => {
            // setTimeout(()=>{
            //     this.loading = false;
            // },1000)
          }
        }
      )
    },
    toggleDialog() {
      this.dialog.show = !this.dialog.show;
    },
    setDialog(newVal) {
      this.dialog = newVal;
    },
    resetApp() {
      this.data = {};
      this.loading = true;
      this.dialog = {
        show: false
      }
    }
  }
});
