<template>
  <q-page padding>

    <div class=" q-my-md q-mx-sm" style="height: 100vh;">
      <!-- showcase -->
      <section class=" text-center flex column justify-center">
        <h1 class="morabba text-info text-h4 text-weight-bold">ثبت نام</h1>
        <h2 class="vazirmatn text-info text-h6 text-h-5">حساب کاربری جیمی فای بساز</h2>
        <!-- register form -->
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
          <!-- confirm password -->
          <q-input v-model="confirmPassword" label="تکرار پسوورد" class="vazirmatn" label-color="info" filled
            :type="isPwd ? 'password' : 'text'" ref="confirmPasswordRef"
            :rules="[val => !!val || 'تکرار پسوورد را وارد کنید', val => val.length > 7 || 'حداقل هشت کاراکتر وارد کنید']">
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
          <q-btn @click="register" unelevated label="ثبت نام" color="info" />
          <q-btn @click="$router.push('/login')" label="حساب کاربری دارید؟" flat outline color="info" />
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
    const confirmPassword = ref(null)
    const usernameRef = ref(null)
    const passwordRef = ref(null)
    const confirmPasswordRef = ref(null)

    function register() {
      usernameRef.value.validate();
      passwordRef.value.validate();
      confirmPasswordRef.value.validate();
      if (usernameRef.value.hasError || passwordRef.value.hasError || confirmPasswordRef.value.hasError) {
        q.notify({
          color: "red",
          position: 'top',
          message: "مقادیر فرم نادرست پر شده!"
        })
      } else if (password.value !== confirmPassword.value) {
        q.notify({
          color: "red",
          position: 'top',
          message: "تکرار پسوورد با پسوورد مطابقت ندارد"
        })
      } else {
        api.post('api/register', {
          email: username.value,
          password: password.value
        }).then(res => {
          console.log(res.data);
          if (res.data.status) {
            router.push('/login')
          }
        }).catch(err => {
          q.notify({
            color: 'red',
            position: 'top',
            message: err.message
          })
        })
      }
    }

    return {
      username, password, confirmPassword, usernameRef, passwordRef, confirmPasswordRef,
      register
    }
  }
}
</script>