<script>
import { login } from '../services/requests';
import { useRouter } from 'vue-router';
import { ref } from 'vue';

export default {
  name: "LoginView",
  setup() {
    const router = useRouter();
    const name = ref('');
    const password = ref('');
    const visible = ref(false);

    async function auth() {
      try {
        const response = await login(name.value, password.value);
        if (response.data.message === 'Authentification réussie') {
          router.push({ name: 'home' })
        } else {
          console.log("Échec de l'authentification");
        }
      } catch (err) {
        console.log(err);
      }
    }

    return { name, password, visible, auth };
  }
}
</script>

<template>
  <div role="region" class="container">
    <h1>Login</h1>

    <v-card class="card">
      <v-form @submit.prevent="auth">
        <div class="text-subtitle-1 text-medium-emphasis">Account</div>

        <v-text-field density="compact" placeholder="Name" prepend-inner-icon="mdi-account" variant="outlined"
          v-model="name"></v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
          Password
        </div>

        <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
          density="compact" placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline" variant="outlined"
          @click:append-inner="visible = !visible" v-model="password"></v-text-field>

        <v-btn block class="mb-8 btn" color="blue" size="large" variant="tonal" type="submit">
          Log In
        </v-btn>
      </v-form>
    </v-card>
  </div>
</template>

<style scoped>
.container {
  display: flex;
  flex-flow: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.card{
  width: 40rem;
}

.btn{
  background-color: var(--main-color);
  color: #fff;
  cursor: pointer;
}
</style>