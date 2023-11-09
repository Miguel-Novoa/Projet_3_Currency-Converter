<script setup>
import { getPairs } from '../services/requests';

async function allPairs(){
    const response = await getPairs();

    console.log(response)
}

allPairs();
</script>

<template>
    <v-table density="compact">
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
            <tr>
                <td>EUR -> USD</td>
                <td>1.07</td>
                <td>53</td>
                <td>
                    <Button>Edit</Button>
                </td>
                <td>
                    <button>Delete</button>
                </td>
            </tr>
        </tbody>

    </v-table>
</template>