<script>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { getTokenLocalStorage } from '../services/localStorageService'

export default {
  setup() {
    const router = useRouter()

    onMounted(() => {
      //Redirige l'utilisateur sur la page de connexion dans le cas où il n'est pas connecté
      //(lorsque le token n'est pas dans le local storage)
      if (!getTokenLocalStorage()) {
        router.push({ name: 'login' })
      }
    })
  },
}

</script>