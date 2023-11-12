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
      <v-card class="card">
        <v-card-title>Edit Pair</v-card-title>
        <v-card-text class="cardContent">
          <v-form>
            <v-text-field variant="solo" v-model="editedRate" label="Rate" type="number"></v-text-field>
            <div class="btns" role="region">
              <v-btn class="edit" @click="submitEdit">Edit</v-btn>
              <v-btn @click="closePopup" color="error">Cancel</v-btn>
            </div>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<style scoped>
  .card{
    display: flex;
    flex-flow: column;
    align-items: center;
  }

  .cardContent{
    width: 20rem;
  }

  .btns{
    display: flex;
    flex-flow: row;
    align-items: center;
    justify-content: center;
    column-gap: 2rem;
  }

  .edit{
    background-color: var(--main-color) !important;
    color: #fff;
  }

  button{
    cursor: pointer;
  }
</style>