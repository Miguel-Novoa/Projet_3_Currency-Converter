<script setup>
import AddPairPopup from '../components/AddPairPopup.vue';
import PairsList from '../components/PairsList.vue';
import { ref, onMounted } from 'vue';
import { getCurrencies } from '../services/requests';

const showAddPairPopup = ref(false);
const currenciesDatas = ref([]);
const currenciesTable = ref([]);

const toggleAddPairPopup = () => {
  showAddPairPopup.value = !showAddPairPopup.value;
};

onMounted(async () => {
    const currencies = await getCurrencies();
    currenciesDatas.value = currencies.data.data;

    currenciesDatas.value.forEach(currency => {
        currenciesTable.value.push({
          code: currency.code,
          id: currency.id
        });
    });
});
</script>

<template>
  <div>
    <h1>Liste des paires</h1>
    <ul>
      <li>
        <button @click="toggleAddPairPopup">Ajouter une paire</button>
      </li>
      <li>
        <button>Ajouter une devise</button>
      </li>
    </ul>
    <AddPairPopup v-if="showAddPairPopup" :currencies="currenciesTable"/>
    <PairsList :currencies="currenciesTable"/>
  </div>
</template>
