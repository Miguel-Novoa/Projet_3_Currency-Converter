<script>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { getTokenLocalStorage } from '../services/localStorageService'

export default {
  setup() {
    const router = useRouter()

    // Check if token is in local storage when component is mounted
    onMounted(() => {

      if (!getTokenLocalStorage()) {
        // Redirect to login page
        router.push({ name: 'login' })
      }
    })
  },
}

</script>