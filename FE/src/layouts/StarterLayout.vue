<template>
  <q-layout view="hHh Lpr fFf"> <!-- Be sure to play with the Layout demo on docs -->
    <!-- Header -->
    <header>
      <div class="row">
        <div class="col-12 flex justify-between q-pa-sm">
          <q-avatar size="60px">
            <q-img src="logo.png" />
          </q-avatar>
          <h1 class="text-h5 text-info text-weight-bold">جیمیفای</h1>
        </div>
      </div>
    </header>

    <q-page-container>
      <!-- This is where pages get injected -->
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script>
import { ref } from 'vue'

export default {
  // name: 'LayoutName',

  setup() {

  }
}
</script>
