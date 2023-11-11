<script setup>
import { ref, defineEmits } from 'vue';
import { addCurrency } from '../services/requests';
import { useRouter } from 'vue-router';

const dialog = ref(true);

const code = ref('');
const description = ref('');
const emit = defineEmits();
const router = useRouter();

const codeRules = [
    (v) => !!v || 'Le code est requis',
    (v) => /^[a-zA-Z]{0,3}$/.test(v) || 'Le code doit contenir maximum 3 lettres sans chiffre ni caractère spécial',
];

const descriptionRules = [
    (v) => !!v || 'La description est requise',
    (v) => v.length <= 50 || 'La description doit contenir maximum 50 caractères',
];

async function submitCurrency(){
    try{
        const response = await addCurrency(code.value, description.value);
        if(response.data.message === 'Nouvelle devise ajoutée !'){
            dialog.value = false;
            emit('closeCurrencyPopup');
            router.go();
        }else{
            console.log("L'ajout d'une nouvelle devise a échoué");
        }
    } catch (error) {
    throw error;
  }
};

const closePopup = () => {
    dialog.value = false;
    emit('closeCurrencyPopup');
};

{ dialog, closePopup, submitCurrency, emit }
</script>

<template>
    <v-form>
        <v-dialog v-model="dialog" max-width="400">
            <v-card>
                <v-card-title>Edit Pair</v-card-title>
                <v-card-text>
                    <v-text-field v-model="code" label="Code" type="text" :rules="codeRules" maxlength="3"></v-text-field>

                    <v-textarea v-model="description" label="Description" :rules="descriptionRules"
                        maxlength="50"></v-textarea>

                    <v-btn @click="submitCurrency" color="primary">Add currency</v-btn>
                    <v-btn @click="closePopup" color="error">Close</v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-form>
</template>

  