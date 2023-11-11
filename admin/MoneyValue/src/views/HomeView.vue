<script setup>
import AddPairPopup from '../components/AddPairPopup.vue';
import AddCurrencyPopup from '../components/AddCurrencyPopup.vue';
import PairsList from '../components/PairsList.vue';
import { ref, onMounted } from 'vue';
import { getCurrencies } from '../services/requests';

const showAddPairPopup = ref(false);
const showAddCurrencyPopup = ref(false);
const currenciesDatas = ref([]);
const currenciesTable = ref([]);

const openAddPairPopup = () => {
  showAddPairPopup.value = true;
};

const openAddCurrencyPopup = () => {
  showAddCurrencyPopup.value = true;
}

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
        <button @click="openAddPairPopup">Ajouter une paire</button>
      </li>
      <li>
        <button @click="openAddCurrencyPopup">Ajouter une devise</button>
      </li>
    </ul>
    <AddPairPopup v-if="showAddPairPopup" :currencies="currenciesTable"
    @closePairPopup="showAddPairPopup = false"/>
    <AddCurrencyPopup v-if="showAddCurrencyPopup" 
    @closeCurrencyPopup="showAddCurrencyPopup = false"/>
    <PairsList :currencies="currenciesTable"/>
  </div>
</template>
