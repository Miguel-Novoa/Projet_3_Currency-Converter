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
    <v-card class="card">
      <v-card-title>Add pair</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="addPairs" class="form">
          <v-autocomplete class="inputs"
            v-model="selectedSourceCurrency"
            :items="currencies"
            label="Choose source currency"
            item-title="code"
            item-id="id"
            item-value="id"
            variant="solo"
            return-object
          ></v-autocomplete>
          <v-autocomplete class="inputs"
            v-model="selectedTargetCurrency"
            :items="currencies"
            label="Choose target currency"
            item-title="code"
            item-id="id"
            item-value="id"
            variant="solo"
            return-object
          ></v-autocomplete>
          <v-text-field class="inputs" v-model="rate" label="Enter rate..." type="number" variant="solo"></v-text-field>
          <div class="btns">
            <v-btn class="add" type="submit" color="primary">Add</v-btn>
            <v-btn color="error" @click="closePopup">Close</v-btn>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<style scoped>
  .card{
    display: flex;
    flex-flow: column;
    align-items: center;
  }

  .form{
    display: flex;
    flex-flow: column;
    align-items: center;
  }

  .inputs{
    width: 30rem;
  }

  .btns{
    display: flex;
    flex-flow: row;
    column-gap: 2rem;
  }

  .add{
    background-color: var(--main-color) !important;
    color: #fff;
  }

  button{
    cursor: pointer;
  }
</style>
