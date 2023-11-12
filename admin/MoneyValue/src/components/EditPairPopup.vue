<script setup>
import { ref, defineEmits, defineProps } from 'vue';
import { editPair } from '../services/requests';
import { useRouter } from 'vue-router';

const dialog = ref(true);
const { pairId } = defineProps(['pairId']);
const router = useRouter();
const editedRate = ref(null);
const span = ref(null);

//Appel la requete editPair et en cas de succès apporte les modifications de la paire en base
async function submitEdit(){
  try{
    const response = await editPair(pairId, editedRate.value);
    if (response.data.message === 'Paire mise à jour avec succès!'){
      dialog.value = false;
      emit('closePopup');
      router.go();
    }else{
      span.value = true;
    }
  } catch (err) {
        console.log(err);
        span.value = true;
  }
}

//ferme la popup
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
            <span v-if="span">Error : failed to edit pair</span>
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

  form{
    display: flex;
    flex-flow: column;
    row-gap: 1rem;
  }

  .cardContent{
    width: 20rem;
  }

  span{
    color: #D70022;
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