<script setup>
import { ref, defineEmits, defineProps } from 'vue';
import { editPair } from '../services/requests';
import { useRouter } from 'vue-router';

const dialog = ref(true);
const { pairId } = defineProps(['pairId']);
const router = useRouter();
const editedRate = ref(null);

async function submitEdit(){
  try{
    const response = await editPair(pairId, editedRate.value);
    if (response.data.message === 'Paire mise à jour avec succès!'){
      dialog.value = false;
      emit('closePopup');
      router.go();
    }else{
      console.log('Echec de la mise à jour de pair !')
    }
  } catch (err) {
        console.log(err);
  }
}

const closePopup = () => {
  dialog.value = false;
  emit('closePopup');
};

const emit = defineEmits();

{ dialog, closePopup, submitEdit, emit }
</script>

<template>
  <div>
    <v-dialog v-model="dialog" max-width="400">
      <v-card>
        <v-card-title>Edit Pair</v-card-title>
        <v-card-text>
          <v-form>
            <v-text-field v-model="editedRate" label="Rate" type="number"></v-text-field>

            <v-btn @click="submitEdit" color="primary">Submit</v-btn>
            <v-btn @click="closePopup">Cancel</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
