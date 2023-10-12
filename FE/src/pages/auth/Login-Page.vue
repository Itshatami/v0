<template>
  <q-page padding>

    <div class=" q-my-md q-mx-sm" style="height: 100vh;">
      <!-- showcase -->
      <section class=" text-center flex column justify-center">
        <h1 class="morabba text-info text-h4 text-weight-bold">ورود</h1>
        <!-- login form -->
        <div class="q-gutter-y-sm">
          <q-input v-model="username" color="info" label-color="info" outlined class="vazirmatn" label="ایمیل"
            ref="usernameRef"
            :rules="[val => !!val || 'لطفا ایمیل خود را وارد کنید', val => val.length > 7 || 'حداقل هشت کاراکتر وارد کنید']">
            <template v-slot:append>
              <q-icon name="event" color="info" />
            </template>
          </q-input>
          <!-- password -->
          <q-input v-model="password" color="info" class="vazirmatn" label="پسوورد" label-color="info" filled
            :type="isPwd ? 'password' : 'text'" ref="passwordRef"
            :rules="[val => !!val || 'لطفا پسوورد خود را وارد کنید', val => val.length > 7 || 'حداقل هشت کاراکتر وارد کنید']">
            <template v-slot:append>
              <q-icon color="info" :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                @click="isPwd = !isPwd" />
            </template>
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

export default {
  // name: 'PageName',
  setup() {
    const q = useQuasar();
    const router = useRouter()
    const username = ref(null)
    const password = ref(null)
    const usernameRef = ref(null)
    const passwordRef = ref(null)

    function login() {
      usernameRef.value.validate();
      passwordRef.value.validate();
      if (usernameRef.value.hasError || passwordRef.value.hasError) {
        q.notify({
          color: "red",
          position: 'top',
          message: "مقادیر فرم نادرست پر شده!"
        })
      } else {
        api.post('api/login', {
          username: username.value,
          password: password.value
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
      username, password, usernameRef, passwordRef, login
    }
  }
}
</script>