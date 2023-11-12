<template>
  <q-page padding>

    <div class=" q-my-md q-mx-sm" style="height: 100vh;">
      <!-- showcase -->
      <section class=" text-center flex column justify-center">
        <h1 class="morabba text-info text-h4 text-weight-bold">ورود</h1>
        <!-- confirm form -->
        <div class="q-gutter-y-sm">
          <q-input type="text" v-model="password" color="info" label-color="info" outlined class="vazirmatn"
            label="Confirm" ref="passwordRef" :rules="[val => !!val || 'لطفا کد تایید خود را وارد کنید']">
          </q-input>
        </div>
      </section>
      <!-- buttons -->
      <div class=" absolute-bottom-md  flex justify-center items-center" style="po">
        <div class="flex column q-gutter-y-md vazirmatn">
          <q-btn @click="verify" unelevated label="Confirm" color="info" />
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
import { useAppDataStore } from "src/stores/appData";
import { storeToRefs } from "pinia";

export default {
  // name: 'PageName',
  setup() {
    const appData = useAppDataStore();
    const { username } = storeToRefs(appData)
    const q = useQuasar();
    const router = useRouter()
    const password = ref(null)
    const passwordRef = ref(null)

    console.log(username.value);

    function verify() {
      passwordRef.value.validate();
      if (passwordRef.value.hasError) {
        q.notify({
          color: "red",
          position: 'top',
          message: "مقادیر فرم نادرست پر شده!"
        })
      } else {
        api.post('api/verify', {
          username: username.value,
          password: password.value,
        }).then(res => {
          console.log(res.data);
          if (res.data.access_token) {
            q.cookies.set('access_token', res.data.access_token, { expires: '365d' });
            q.cookies.set('refresh_token', res.data.refresh_token, { expires: '365d' });
            q.cookies.set('expires_in', res.data.expires_in, { expires: '365d' });
            router.push('/')
          }
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
      password, passwordRef, verify
    }
  }
}
</script>