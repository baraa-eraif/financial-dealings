import {defineStore} from 'pinia'
import {computed, ref} from 'vue'
import {useStorage} from '@vueuse/core'


export const useAuthUser = defineStore('userSession', () => {
  const token = useStorage('seller_token', '');
  const user = useStorage('seller_auth', {});
  const locale = useStorage('seller_locale', '');

  const loading = ref(true);

  const isLoggedIn = computed(
    () => token.value !== undefined && token.value !== ''
  );

  function setAuth({access_token, auth}) {
    setUser(auth);
    setToken(access_token);
  }

  function setUser(newUser) {
    user.value = newUser;
  }


  function setToken(newToken) {
    token.value = newToken;
  }

  function setLocale(newVal) {
    console.log('setsellerLocale',newVal)
    locale.value = newVal;
  }

  function setLoading(newLoading) {
    loading.value = newLoading;
  }

  async function logoutUser() {
    token.value = undefined;
    user.value = undefined;
  }

  return {
    user,
    token,
    locale,
    isLoggedIn,
    loading,
    logoutUser,
    setUser,
    setToken,
    setAuth,
    setLoading,
    setLocale,
  }
});
