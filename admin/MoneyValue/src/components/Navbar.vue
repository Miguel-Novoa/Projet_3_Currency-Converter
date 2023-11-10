<script setup>
import VerifyLogin from './VerifyLogin.vue';
import { removeTokenLocalStorage, getTokenLocalStorage } from '../services/localStorageService';
import { useRouter } from 'vue-router';
import { ref, watch } from 'vue';

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
                <a href="">Converter</a>
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
