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

/* Appel les requetes getCurrencies et getPairs afin de récupérer toutes les devises et paires.
Puis pour chaque devise, compare l'id avec les id source et target des paires afin de vérifier
si la devise est impliquée dans une paire, si c'est le cas ajoute la devise au tableau availableCurrenciesTable.
 */
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

/*Appel la requête getPairs afin de récupérer toutes les paires.
Compare les valeurs des selectedItem1 et selectedItem2 et les compare respectivement aux
id source et cible de chaque pair. Dans le cas où il y a correspondance, calcul la valeur
de la somme convertie en fonction de la somme entrée par l'utilisateur et du taux de la paire.
*/
async function handleConvert(){
    try {
    const pairsResponse = await getPairs();

    if (pairsResponse.data.message === 'Paires récupérées !') {
      const pairs = pairsResponse.data.data;
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

/* Appel la requete pairConversions afin d'incrémenter le nombre de conversions de la
paire à chaque fois qu'une conversion est effectuée. */
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
      <v-container class="container">
        <h1>Convert</h1>
  
        <div class="row">
          <v-autocomplete
            v-model="selectedItem1"
            :items="availableCurrenciesTable"
            label="Enter the source currency..."
            item-title="title"
            item-value="id"
            class="autocomplete"
            variant="solo"
          ></v-autocomplete>
  
          <v-icon class="icon">mdi-arrow-right</v-icon>
  
          <v-autocomplete
            v-model="selectedItem2"
            :items="availableCurrenciesTable"
            label="Enter the target currency..."
            item-title="title"
            item-value="id"
            class="autocomplete"
            variant="solo"
          ></v-autocomplete>
        </div>
  
        <div class="row2">
          <v-text-field variant="solo" v-model="valueToConvert" label="Enter the amount to convert..." type="number"></v-text-field>
          <v-text-field variant="solo" v-model="valueConverted" label="Converted amount..." type="number" :disabled="true"></v-text-field>
        </div>
  
        <v-btn type="submit" class="button">Convertir</v-btn>
      </v-container>
    </form>
  </template>
  

<style scoped>
  .container {
    text-align: center;
    margin-top: 50px;
  }

  .row {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
  }

  .autocomplete {
    margin-right: 10px;
    width: 200px;
  }

  .icon {
    margin: 0 10px;
    font-size: 24px;
  }

  .row2 {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 20px;
    column-gap: 2rem;
  }

  .button {
    margin-top: 20px;
    background-color: var(--main-color);
    color: #fff;
    cursor: pointer;
  }
</style>

