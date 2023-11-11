<script setup>
import VerifyLogin from './VerifyLogin.vue';
import { removeTokenLocalStorage } from '../services/localStorageService';
import { RouterLink, useRouter } from 'vue-router';

const router = useRouter();

function logout() {
    removeTokenLocalStorage();
    router.push({ name: 'login' });
}

</script>

<template>
    <VerifyLogin />
    <nav>
        <h2>MoneyValue</h2>
        <li>
            <ul>
                <RouterLink :to="{name : 'converter'}">Converter</RouterLink>
            </ul>
            <ul>
                <button @click="logout">Logout</button>
            </ul>
        </li>
    </nav>
</template>

<style scoped>
    nav {
        display: flex;
        flex-flow: row;
        justify-content: space-between;
        max-width: 100%;
        border: 1px solid black;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    li {
        list-style: none;
        display: flex;
        flex-flow: row;
        align-items: center;
    }
</style>
