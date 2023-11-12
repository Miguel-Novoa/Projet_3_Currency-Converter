<script setup>
import EditPairPopup from '../components/EditPairPopup.vue';
import { ref, onMounted, defineProps } from 'vue';
import { getPairs, deletePair } from '../services/requests';
import { useRouter } from 'vue-router';

const pairsDatas = ref([]);
const showEditPairPopup = ref(false);
const selectedPairId = ref(null);
const { currencies } = defineProps(['currencies']);
const router = useRouter();

onMounted(async () => {
    const pairs = await getPairs();
    pairsDatas.value = pairs.data.data;
});

//Ouvre la popup d'édition de paire
const openPopup = (pairId) => {
    selectedPairId.value = pairId;
    showEditPairPopup.value = true;
};

//Appel la requete deletePair et en cas de succès supprime la paire de la base
async function destroyPair(id) {
    try {
        const response = await deletePair(id);
        if (response.data.message === 'Paire correctement supprimée !') {
            router.go();
        } else {
            console.log("La suppression de paire a échoué");
        }
    } catch (err) {
        console.log(err);
    }
}

</script>

<template>
    <v-table class="listBlock" density="compact">
        <thead>
            <tr>
                <th class="text-left">Pair</th>
                <th class="text-left">Rate</th>
                <th class="text-left">Conversions</th>
                <th class="text-left"></th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="pair in pairsDatas" :key="pair.id">
                <td>{{ currencies[pair.source_currency_id - 1].code }} -> {{ currencies[pair.target_currency_id - 1].code }}
                </td>
                <td>{{ pair.rate }}</td>
                <td :class="{ 'red': pair.nb_conversions === 0, 'main': pair.nb_conversions > 0 }">{{ pair.nb_conversions }}
                </td>
                <td>
                    <v-btn color="primary" class="editBtn" @click="() => openPopup(pair.id)">Edit</v-btn>
                </td>
                <td>
                    <v-btn color="error" @click="() => destroyPair(pair.id)">Delete</v-btn>
                </td>
            </tr>
        </tbody>
        <EditPairPopup v-if="showEditPairPopup" :pairId="selectedPairId" @closePopup="showEditPairPopup = false" />

    </v-table>
</template>

<style scoped>
.listBlock {
    width: 60%;
    margin-top: 4rem;
}

tr {
    height: 4rem;
}

td {
    text-align: center;
    font-weight: bold;
}

thead {
    background-color: var(--main-color);
}

thead th {
    color: #fff !important;
    text-align: center !important;
    font-weight: bold !important;
}

button {
    cursor: pointer;
}

.editBtn {
    background-color: var(--main-color) !important;
    color: #fff;
}

.red {
    color: #D70022;
}

.main {
    color: var(--main-color);
}
</style>