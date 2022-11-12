import ar from "./ar";
import en from "./en";
import {createI18n} from "vue-i18n";


export const i18n = createI18n({

    legacy: false,
    locale:localStorage.getItem('seller_locale')?? 'ar',
    messages: {
      ar,
      en
    },
    globalInjection: true,

  });

