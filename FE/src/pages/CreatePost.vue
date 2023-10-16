<template>
  <q-page padding>
    <!-- content -->
    <div class="row">
      <div class="col-12 q-gutter-y-md">
        <q-input v-model="title" type="text" label="Title" outlined placeholder="title"></q-input>
        <q-input v-model="caption" type="text" label="Caption" filled autogrow outlined placeholder="caption"></q-input>
        <q-btn label="Create" :loading="loading" :disable="loading" class="full-width" @click="createPost" outline />
      </div>
    </div>
  </q-page>
</template>

<script>
import { api } from 'src/boot/axios';
import { useRouter } from "vue-router";
import { ref } from 'vue';
import { useQuasar } from 'quasar';

export default {
  // name: 'PageName',
  setup() {
    const q = useQuasar()
    const router = useRouter();
    const title = ref(null);
    const caption = ref(null);
    const loading = ref(false)

    function createPost() {
      loading.value = true
      api.post('api/posts', {
        title: title.value,
        caption: caption.value
      }).then(res => {
        console.log(res.data);
        q.notify({
          position: 'top',
          color: 'blue',
          message: 'successfully created'
        })
        router.push('/')
      }).catch(err => {
        console.log(err);
        loading.value = false
        q.notify({
          position: 'top',
          color: 'red',
          message: 'could not create post'
        })
      })
    }
    return { title, caption, createPost, loading }
  }
}
</script>
