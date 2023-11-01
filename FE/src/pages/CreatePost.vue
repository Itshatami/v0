<template>
  <q-page padding>
    <!-- content -->
    <div class="row">
      <div class="col-12 q-gutter-y-md">
      <q-form @submit="createPost">
          <q-input name="title" type="text" label="Title" outlined placeholder="title" v-model="title"></q-input>
          <q-file name="picture" label="choose cover" outlined v-model="file" />
          <q-input name="caption" type="text" label="Caption" filled autogrow outlined placeholder="caption"
            v-model="caption"></q-input>
          <q-btn type="submit" label="Create" :loading="loading" :disable="loading" class="full-width" outline />
        </q-form>
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
    const file = ref(null);

    function handleFile(e) {
      file.value = e.target.files[0]
    }

    function createPost(event) {
      const formData = new FormData(event.target);
      loading.value = true
      api.post('api/posts', formData, {
        headers: {
          "Content-Type": "multipart/form-data"
        },
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
    return { file, title, caption, createPost, loading, handleFile }
  }
}
</script>
