<template>
  <q-page padding>
    <!-- content -->
    <div class="row">
      <div class="col-12 q-gutter-y-md">
        <q-input v-model="title" value="{{ post.title }}" type="text" label="Title" outlined
          placeholder="title"></q-input>
        <q-input v-model="caption" type="text" label="Caption" filled autogrow outlined placeholder="caption"></q-input>
        <q-btn label="Update" :loading="loading" :disable="loading" class="full-width" @click="updatePost" outline />
      </div>
    </div>
  </q-page>
</template>

<script>
import { api } from 'src/boot/axios';
import { useRouter, useRoute } from "vue-router";
import { onMounted, ref } from 'vue';
import { useQuasar } from 'quasar';

export default {
  // name: 'PageName',
  setup() {
    const q = useQuasar()
    const router = useRouter();
    const route = useRoute();
    const title = ref(null);
    const caption = ref(null);
    const loading = ref(false)

    function getPost() {
      api.get(`api/posts/${route.params.id}`).then(res => {
        title.value = res.data.title;
        caption.value = res.data.caption
      }).catch(err => {
        console.log(err);
        q.notify({
          position: 'top',
          color: 'red',
          message: 'could not find the post'
        })
      })
    }
    getPost();

    function updatePost() {
      loading.value = true;
      api.put('api/posts/' + route.params.id, {
        title: title.value,
        caption: caption.value
      }).then(res => {
        console.log(res.data);
        loading.value = false
        if (res.data.status) {
          router.push('/');
        } else {
          loading.value = false
          q.notify({
            color: 'red',
            message: 'could not update the post',
            position: 'top'
          })
        }
      }).catch(err => {
        loading.value = false
        console.log(err);
        q.notify({
          color: 'red',
          position: 'top',
          message: err.message
        })
      })
    }

    return { title, caption, loading, updatePost }
  }
}
</script>
