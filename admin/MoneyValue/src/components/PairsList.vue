<script setup>
import EditPairPopup from '../components/EditPairPopup.vue';
import { ref, onMounted, defineProps } from 'vue';
import { getPairs, deletePair } from '../services/requests';
import { useRouter } from 'vue-router';

const pairsDatas = ref([]);
const showEditPairPopup = ref(false);
const selectedPairId = ref(null);
const { currencies } = defineProps(['currencies']);
const router = useRouter();

onMounted(async () => {
  const pairs = await getPairs();
  pairsDatas.value = pairs.data.data;
});

const openPopup = (pairId) => {
    selectedPairId.value = pairId;
    showEditPairPopup.value = true;
};

async function destroyPair(id){
    try {
        const response = await deletePair(id);
        if (response.data.message === 'Paire correctement supprimée !') {
            router.go();
        } else {
          console.log("La suppression de paire a échoué");
        }
      } catch (err) {
        console.log(err);
    }
}

</script>

<template>
    <v-table density="compact">
        <thead>
            <tr>
                <th class="text-left">Pair</th>
                <th class="text-left">Rate</th>
                <th class="text-left">Conversions</th>
                <th class="text-left"></th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="pair in pairsDatas" :key="pair.id">
                <td>{{ currencies[pair.source_currency_id - 1].code }} -> {{ currencies[pair.target_currency_id - 1].code }}</td>
                <td>{{ pair.rate }}</td>
                <td>{{ pair.nb_conversions }}</td>
                <td>
                    <v-btn @click="() => openPopup(pair.id)">Edit</v-btn>
                </td>
                <td>
                    <v-btn @click="() => destroyPair(pair.id)">Delete</v-btn>
                </td>
            </tr>
        </tbody>
        <EditPairPopup v-if="showEditPairPopup" :pairId="selectedPairId" 
        :popupState="showEditPairPopup" 
        @closePopup="showEditPairPopup = false"/>

    </v-table>
</template>