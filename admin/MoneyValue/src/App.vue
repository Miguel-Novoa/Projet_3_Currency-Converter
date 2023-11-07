<script setup>
  import Navbar from './components/Navbar.vue';
import router from './router';
</script>

<template>
  <header>
    <!-- Navbar -->
    <Navbar/>
  </header>

  <main>
    <routerView/>
  </main>
</template>

<style>

  body{
    width: 100%;
    margin: 0;
  }
</style>
