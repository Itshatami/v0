<template>
  <q-page padding>

    <div class=" q-my-md q-mx-sm" style="height: 100vh;">
      <!-- showcase -->
      <section class=" text-center flex column justify-center">
        <h1 class="morabba text-info text-h4 text-weight-bold">ورود</h1>
        <!-- login form -->
        <div class="q-gutter-y-sm">
          <q-input type="text" v-model="username" color="info" label-color="info" outlined class="vazirmatn"
            label="موبایل" ref="usernameRef"
            :rules="[val => !!val || 'لطفا موبایل خود را وارد کنید', val => val.length > 7 || 'حداقل هشت کاراکتر وارد کنید']">
          </q-input>
        </div>
      </section>
      <!-- buttons -->
      <div class=" absolute-bottom-md  flex justify-center items-center" style="po">
        <div class="flex column q-gutter-y-md vazirmatn">
          <q-btn @click="login" unelevated label="ورود" color="info" />
          <q-btn @click="$router.push('/register')" label="حساب کاربری ندارید ؟" flat outline color="info" />
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { api } from 'src/boot/axios';
import { ref, toRefs } from 'vue';
import { useRouter } from "vue-router";
import { useAppDataStore } from 'src/stores/appData'
import { storeToRefs } from 'pinia'

export default {
  // name: 'PageName',
  setup() {
    const appData = useAppDataStore();
    const { username } = storeToRefs(appData);
    const q = useQuasar();
    const router = useRouter()
    const usernameRef = ref(null)

    function login() {
      usernameRef.value.validate();
      if (usernameRef.value.hasError) {
        q.notify({
          color: "red",
          position: 'top',
          message: "مقادیر فرم نادرست پر شده!"
        })
      } else {
        api.post('api/login', {
          username: username.value,
        }).then(res => {
          console.log(res.data);
          router.push('/confirm');

        }).catch(err => {
          q.notify({
            color: 'red',
            position: 'top',
            message: err
          })
        })
      }
    }

    return {
      username, usernameRef, login
    }
  }
}
</script>