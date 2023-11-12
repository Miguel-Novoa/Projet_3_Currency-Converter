<script setup>
import { ref, defineEmits } from 'vue';
import { addCurrency } from '../services/requests';
import { useRouter } from 'vue-router';

const dialog = ref(true);

const code = ref('');
const description = ref('');
const span = ref(false);
const emit = defineEmits();
const router = useRouter();

//Empêche l'utilisateur de rentrer autre chose qu'un code a 3 lettres
const codeRules = [
    (v) => !!v || 'Le code est requis',
    (v) => /^[a-zA-Z]{3}$/.test(v) || 'Le code doit contenir maximum 3 lettres sans chiffre ni caractère spécial',
];

//Empêche l'utilisateur de rentrer plus de 50 caractères
const descriptionRules = [
    (v) => !!v || 'La description est requise',
    (v) => v.length <= 50 || 'La description doit contenir maximum 50 caractères',
];

//Appel la requête addCurrency et en cas de succès ajoute la nouvelle devise a la base
async function submitCurrency(){
    try{
        const response = await addCurrency(code.value, description.value);
        if(response.data.message === 'Nouvelle devise ajoutée !'){
            dialog.value = false;
            span.value = false;
            emit('closeCurrencyPopup');
            router.go();
        }else{
            span.value = true;
        }
    } catch (error) {
      span.value = true;
    throw error;
  }
};

//ferme la popup
const closePopup = () => {
    dialog.value = false;
    emit('closeCurrencyPopup');
};

{ dialog, closePopup, submitCurrency, emit }
</script>

<template>
    <v-form>
      <v-dialog v-model="dialog" max-width="600">
        <v-card class="card">
          <v-card-title class="cardTitle">Edit Pair</v-card-title>
          <v-card-text class="cardContent">
            <v-text-field variant="solo" v-model="code" label="Code" type="text" :rules="codeRules" maxlength="3" class="inputs"></v-text-field>
  
            <v-textarea variant="solo" v-model="description" label="Description" :rules="descriptionRules" maxlength="50" class="inputs"></v-textarea>
            <span v-if="span">Error : failed to add currency</span>
            <v-row class="buttons" justify="center">
              <v-btn color="primary" @click="submitCurrency" class="add">Add currency</v-btn>
              <v-btn @click="closePopup" color="error">Close</v-btn>
            </v-row>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-form>
  </template>
  
  <style scoped>
  .card {
    height: 26rem;
    display: flex;
    flex-flow: column;
    align-items: center;
  }
  
  .cardContent{
    width: 30rem;
  }

  .buttons{
    display: flex;
    flex-flow: row;
    align-items: center;
    justify-content: center;
    column-gap: 2rem;
    margin-top: 1rem;
  }

  span{
    color: #D70022;
  }

  .add{
    background-color: var(--main-color) !important;
    color: #fff;
  }

  button{
    cursor: pointer;
  }
  </style>
  

  