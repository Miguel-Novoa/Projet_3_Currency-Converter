<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import { addPair } from '../services/requests';
import { useRouter } from 'vue-router';

const dialog = ref(true);
const selectedSourceCurrency = ref(null);
const selectedTargetCurrency = ref(null);
const rate = ref(null);
const { currencies } = defineProps(['currencies']);
const router = useRouter();
const emit = defineEmits();


async function addPairs() {
  let sourceCurrency = JSON.parse(JSON.stringify(selectedSourceCurrency.value.id));
  let targetCurrency = JSON.parse(JSON.stringify(selectedTargetCurrency.value.id));
  let newRate = JSON.parse(JSON.stringify(rate.value));

       try {
        const response = await addPair(sourceCurrency, targetCurrency, newRate);
        if (response.data.message === 'Nouvelle paire ajoutée !') {
          let oppositeRate = 1 / newRate;
          const res = await addPair(targetCurrency, sourceCurrency, oppositeRate);
          if(res.data.message === 'Nouvelle paire ajoutée !'){
            dialog.value = false;
            emit('closePairPopup');
            router.go();
          }else{
            console.log("L'ajout de la paire opposée a échoué");
          }
        } else {
          console.log("L'ajout de paire a échoué");
        }
      } catch (err) {
        console.log(err);
      }
};

const closePopup = () => {
  dialog.value = false;
  emit('closePairPopup');
}

{ dialog, closePopup, addPairs, emit }
</script>

<template>
  <v-dialog v-model="dialog" max-width="600">
    <v-card>
      <v-card-title>Ajouter une paire</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="addPairs">
          <v-autocomplete
            v-model="selectedSourceCurrency"
            :items="currencies"
            label="Devise source"
            item-title="code"
            item-id="id"
            item-value="id"
            return-object
          ></v-autocomplete>
          <v-autocomplete
            v-model="selectedTargetCurrency"
            :items="currencies"
            label="Devise cible"
            item-title="code"
            item-id="id"
            item-value="id"
            return-object
          ></v-autocomplete>
          <v-text-field v-model="rate" label="Taux" type="number"></v-text-field>
          <v-btn type="submit" color="primary">Ajouter</v-btn>
          <v-btn @click="closePopup">Fermer</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
