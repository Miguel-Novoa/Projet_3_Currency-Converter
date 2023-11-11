<script setup>
import { ref, onMounted } from 'vue';
import { getCurrencies, getPairs, pairConversions } from '../services/requests';

const selectedItem1 = ref(null);
const selectedItem2 = ref(null);
const valueToConvert = ref(null);
const valueConverted = ref(null);
const availableCurrenciesTable = ref([]);

onMounted(async () => {
  await createAvailableCurrenciesTable();
});

async function createAvailableCurrenciesTable() {
  try {
    const currencyResponse = await getCurrencies();
    const pairsResponse = await getPairs();

    if (
      pairsResponse.data.message === 'Paires récupérées !' &&
      currencyResponse.data.message === 'Devises récupérées !'
    ) {
      const currencies = currencyResponse.data.data;
      const pairs = pairsResponse.data.data;

      currencies.forEach(currency => {
        const currency1 = pairs.find(pair => pair.source_currency_id === currency.id);
        const currency2 = pairs.find(pair => pair.target_currency_id === currency.id);

        if (currency1 || currency2) {
          availableCurrenciesTable.value.push({
            id: currency.id,
            title: `${currency.code + ' - ' + currency.infos}`,
          });
        }
      });
    }
  } catch (err) {
    console.log(err);
  }
}

async function handleConvert(){
    try {
    const pairsResponse = await getPairs();

    if (pairsResponse.data.message === 'Paires récupérées !') {
      const pairs = pairsResponse.data.data;
      console.log(selectedItem1)
      let item1Id = JSON.parse(JSON.stringify(selectedItem1.value));
      let item2Id = JSON.parse(JSON.stringify(selectedItem2.value));
      pairs.forEach(pair => {
        if(pair.source_currency_id === item1Id && pair.target_currency_id === item2Id){
            let converted = pair.rate * valueToConvert.value;
            valueConverted.value = converted.toFixed(2);
            incrementConversions(pair.id);
        }
      });
    }
  } catch (err) {
    console.log(err);
  }
}

async function incrementConversions(id){
    try{
        await pairConversions(id);
    } catch (err) {
    console.log(err);
  }
}
</script>

<template>
    <form @submit.prevent="handleConvert">
      <v-container>
        <v-row align="center">
          <v-col>
            <v-autocomplete
              v-model="selectedItem1"
              :items="availableCurrenciesTable"
              label="Saisissez votre recherche..."
              item-title="title"
              item-value="id"
            ></v-autocomplete>
          </v-col>
          <v-text-field v-model="valueToConvert" label="Valeur numérique" type="number"></v-text-field>
  
          <v-col>
            <v-icon>mdi-arrow-right</v-icon>
          </v-col>
  
          <v-col>
            <v-autocomplete
              v-model="selectedItem2"
              :items="availableCurrenciesTable"
              label="Saisissez votre recherche..."
              item-title="title"
              item-value="id"
            ></v-autocomplete>
          </v-col>
  
          <v-col>
            <v-text-field v-model="valueConverted" label="Valeur numérique" type="number" :disabled="true"></v-text-field>
          </v-col>
  
          <v-col>
            <v-btn type="submit" color="primary">Convertir</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </form>
  </template>
