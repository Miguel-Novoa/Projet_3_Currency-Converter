<script setup>
import VerifyLogin from './VerifyLogin.vue';
import { removeTokenLocalStorage } from '../services/localStorageService';
import { RouterLink, useRouter } from 'vue-router';

const router = useRouter();

// Déconnecte l'utilisateur. Retire le token du local storage et redirige sur la page de connexion
function logout() {
    removeTokenLocalStorage();
    router.push({ name: 'login' });
}

</script>

<template>
    <VerifyLogin />
    <nav>
        <li>
            <RouterLink class="fontColor" :to="{ name: 'home' }">MoneyValue</RouterLink>
        </li>
        <li v-if="router.currentRoute.value.name !== 'login'">
            <ul>
                <RouterLink class="fontColor" :to="{ name: 'converter' }">Converter</RouterLink>
            </ul>
            <ul>
                <RouteurLink class="fontColor logout" @click="logout">Logout</RouteurLink>
            </ul>
        </li>
    </nav>
</template>

<style>
:root {
    --main-color: #284b63;
}

body {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}

nav {
    display: flex;
    flex-flow: row;
    justify-content: space-between;
    max-width: 100%;
    background-color: var(--main-color);
    padding-left: 1rem;
    padding-right: 1rem;
    color: #fff;
    height: 4rem;
}

nav li {
    list-style: none;
    display: flex;
    flex-flow: row;
    align-items: center;
}

.fontColor {
    color: #fff;
    text-decoration: none;
}

.logout {
    cursor: pointer;
}</style>
