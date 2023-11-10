<script setup>
import EditPairPopup from '../components/EditPairPopup.vue';
import { ref, onMounted, defineProps } from 'vue';
import { getPairs } from '../services/requests';

const pairsDatas = ref([]);
const showEditPairPopup = ref(false);
const selectedPairId = ref(null);
const { currencies } = defineProps(['currencies']);

onMounted(async () => {
  const pairs = await getPairs();
  pairsDatas.value = pairs.data.data;
});

const openPopup = (pairId) => {
  selectedPairId.value = pairId;
  showEditPairPopup.value = true;
  console.log('click')
  console.log(selectedPairId.value)
  console.log(showEditPairPopup.value)
};
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
                    <v-btn>Delete</v-btn>
                </td>
            </tr>
        </tbody>
        <EditPairPopup v-if="showEditPairPopup" :pairId="selectedPairId" @closePopup="showEditPairPopup.value = false"/>

    </v-table>
</template>