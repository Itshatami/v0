<template>
  <q-page padding>
    <!-- content -->
    <div class="q-my-lg text-center">
      <q-avatar size="100px">
        <img v-if="userData" src="selff.jpg" alt="avatar">
        <q-skeleton v-else type="circle" />
      </q-avatar>
      <h1 v-if="userData" class="text-h5 text-weight-medium">{{ userData.username }}</h1>
      <q-skeleton v-else type="text" />
    </div>

    <!-- tab panels-->
    <div class="row">
      <div class="col-12">
        <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary" align="justify"
          narrow-indicator>
          <q-tab name="discover" label="Discover" />
          <q-tab name="posts" label="Posts" />
          <q-tab name="followers" label="Followers" />
          <q-tab name="following" label="Following" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab" animated>
          <!-- Discover -->
          <q-tab-panel name="discover">
            <div class="text-h6">Discover</div>
            <div v-if="AllPosts.length < 1">
              <h1 class="text-h6">no one share a post</h1>
            </div>
            <div v-else class="row q-col-gutter-sm q-mt-md">
              <div v-for="(post, index) in AllPosts" :key="'post ' + index + 1" class="col-6">
                <q-card class="text-center">
                  <q-card-section>
                    <div class="text-h6">{{ post.title }}</div>
                    <div class="text-subtitled2">{{ post.caption }}</div>
                  </q-card-section>
                  <q-card-actions align="around">
                    <q-btn flat icon="visibility" />
                    <q-btn @click="likeToggle(post.id, index)" flat :color="post.liked ? 'red' : 'gray-7'"
                      :icon="post.liked ? 'favorite' : 'favorite_outline'" />
                  </q-card-actions>
                </q-card>
              </div>
            </div>
          </q-tab-panel>
          <!-- Posts -->
          <q-tab-panel name="posts" class="text-center">
            <div class="text-h5">Posts</div>
            <div v-if="posts.length < 1">
              <h4 class="text-h6">you dont have any posts</h4>
              <q-btn @click="$router.push('/posts/create')" label="create your first post" outline class=""></q-btn>
            </div>
            <div v-else class="row q-col-gutter-sm q-mt-md">
              <div v-for="(post, index) in posts" :key="'post' + index + 1" class="col-6">
                <q-card>
                  <q-card-section>
                    <div class="text-h6">{{ post.title }}</div>
                    <div class="text-subtitle2">{{ post.caption }}</div>
                  </q-card-section>
                  <q-card-actions align="around">
                    <q-btn flat icon="more_horiz">
                      <q-menu fit>
                        <q-list>
                          <q-item clickable>
                            <q-item-section>
                              <q-icon @click="$router.push('posts/edit/' + post.id)" color="orange" name="edit" />
                            </q-item-section>
                          </q-item>
                          <q-separator />
                          <q-item clickable>
                            <q-item-section>
                              <q-icon @click="showConfirmation(post.id, index)" color="red" name="delete" />
                            </q-item-section>
                          </q-item>
                        </q-list>
                      </q-menu>
                    </q-btn>
                    <q-btn flat icon="visibility"></q-btn>
                  </q-card-actions>
                </q-card>
              </div>
            </div>

          </q-tab-panel>

          <q-tab-panel name="followers">
            <div class="text-h6">Followers</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>

          <q-tab-panel name="following">
            <div class="text-h6">Following</div>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </q-tab-panel>
        </q-tab-panels>
      </div>
    </div>
    <q-dialog v-model="taeed" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <span class="q-ml-sm">Are You Sure wanna delete this?</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="gray" v-close-popup />
          <q-btn flat label="Delete" @click="deletePost" color="red" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
import { useQuasar } from 'quasar';
import { api } from 'src/boot/axios';
import { onMounted, ref } from 'vue';

export default {
  // name: 'PageName',

  setup() {
    const q = useQuasar();
    const tab = ref('posts');
    const posts = ref([])
    const AllPosts = ref([]);
    const selectedPost = ref(null)
    const selectedIndex = ref(null)
    const taeed = ref(false)
    const userData = ref(null)

    function fetchPost() {
      api.get('api/posts').then(res => {
        console.log(res.data);
        posts.value = res.data
      })
    }

    function fetchAllPost() {
      api.get('api/public/posts').then(res => {
        console.log(res.data);
        AllPosts.value = res.data;
      }).catch(err => {
        q.notify({
          message: err.message,
          color: 'red',
          position: 'top'
        })
      })
    }

    function fechUserData() {
      api.get('api/user')
        .then(res => {
          console.log(res.data);
          userData.value = res.data
        })
        .catch(e => {
          q.notify({
            message: e.message,
            color: 'red',
            position: top
          })
        })
    }

    function showConfirmation(id, index) {
      selectedPost.value = posts.value[index];
      selectedIndex.value = index;
      taeed.value = true;
    }

    function deletePost() {
      api.delete('api/posts/' + selectedPost.value.id).then(res => {
        console.log(res.data);
        if (res.data.status) {
          posts.value.splice(selectedIndex.value, 1)
          confirm.value = false
        }
      })
    }

    function likeToggle(postId, index) {
      api.post('api/likes/' + postId)
        .then(res => {
          // console.log(res.data.liked);
          AllPosts.value[index].liked = res.data.liked
        })
    }

    onMounted(() => {
      fetchPost();
      fetchAllPost();
      fechUserData()
    })

    return { likeToggle, userData, tab, posts, fetchPost, deletePost, AllPosts, selectedIndex, selectedPost, showConfirmation, taeed }
  }
}
</script>
