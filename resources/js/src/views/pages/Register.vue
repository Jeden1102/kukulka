<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img :src="require('@/assets/images/logos/logo.svg').default" max-height="30px" max-width="30px"
              alt="logo" contain class="me-3"></v-img>

            <h2 class="text-2xl font-weight-semibold">Materio</h2>
          </router-link>
        </v-card-title>

        <!-- title -->
        <v-card-text>
          <p class="text-2xl font-weight-semibold text--primary mb-2">Adventure starts here 🚀</p>
          <p class="mb-2">Make your app management easy and fun!</p>
        </v-card-text>

        <!-- login form -->
        <v-card-text>
          <v-form @submit.prevent="registerUser" method="post">
            <v-text-field v-model="username" required outlined label="Username" placeholder="JohnDoe" hide-details
              class="mb-3"></v-text-field>

            <v-text-field type="email" required v-model="email" outlined label="Email" placeholder="john@example.com" hide-details
              class="mb-3"></v-text-field>

            <v-text-field  required v-model="password" outlined :type="isPasswordVisible ? 'text' : 'password'" label="Password"
              placeholder="············" :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details @click:append="isPasswordVisible = !isPasswordVisible"></v-text-field>

            <v-checkbox hide-details class="mt-1">
              <template #label>
                <div class="d-flex align-center flex-wrap">
                  <span class="me-2">I agree to</span><a href="javascript:void(0)">privacy policy &amp; terms</a>
                </div>
              </template>
            </v-checkbox>

            <v-btn type="submit"  block color="primary" class="mt-6"> Sign Up </v-btn>
          </v-form>
        </v-card-text>
        
    <VAlert v-if="error" color="warning">
      {{ error }}
    </VAlert>
        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2"> Already have an account? </span>
          <router-link :to="{ name: 'pages-login' }"> Sign in instead </router-link>
        </v-card-text>

        <!-- divider 
        <v-card-text class="d-flex align-center mt-2">
          <v-divider></v-divider>
          <span class="mx-5">or</span>
          <v-divider></v-divider>
        </v-card-text>-->

        <!-- social link 
        <v-card-actions class="d-flex justify-center">
          <v-btn v-for="link in socialLink" :key="link.icon" icon class="ms-1">
            <v-icon :color="$vuetify.theme.dark ? link.colorInDark : link.color">
              {{ link.icon }}
            </v-icon>
          </v-btn>
        </v-card-actions>-->
      </v-card>
    </div>

    <!-- background triangle shape  -->
    <img class="auth-mask-bg" height="190"
      :src="require(`@/assets/images/misc/mask-${$vuetify.theme.dark ? 'dark' : 'light'}.png`).default" />

    <!-- tree -->
    <v-img class="auth-tree" width="247" height="185" :src="require('@/assets/images/misc/tree.png').default"></v-img>

    <!-- tree  -->
    <v-img class="auth-tree-3" width="377" height="289"
      :src="require('@/assets/images/misc/tree-3.png').default"></v-img>
  </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiFacebook, mdiTwitter, mdiGithub, mdiGoogle, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import axios from 'axios';
import { useUserStore } from '../../store/user';
export default {
  setup() {
    const isPasswordVisible = ref(false)
    const username = ref('')
    const email = ref('')
    const password = ref('')
    const error = ref('')
    const userStore= useUserStore()
    async function registerUser() {
      this.processing = true
      const user = {
        name:username.value,
        email:email.value,
        password:password.value,
      }
      if(!username.value || !email.value || !password.value){
        error.value = "Uzupełnij wszystkie pola!";
        // return;
      }
      axios.post('/api/register', user).then(res=>{
        error.value = '';
        userStore.user = res.data.user
        localStorage.removeItem('user')
        localStorage.setItem('user', JSON.stringify(res.data.token))
        document.location.href = '/';
      }).catch(err=>{
        error.value = err.response.data;
        this.processing = false
      })
    }
    return {
      isPasswordVisible,
      username,
      email,
      password,
      registerUser,
      error,
      userStore,
      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '~@resources/sass/preset/pages/auth.scss';
.v-alert__content{
  color:white !important;
}
</style>
