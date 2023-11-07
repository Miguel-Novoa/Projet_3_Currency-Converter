<script setup>

</script>

<template>
    <nav>
        <h2>MoneyValue</h2>
        <li>
            <ul>
                <a href="">Converter</a>
            </ul>
            <ul>
                <button>Logout</button>
            </ul>
        </li>
    </nav>
</template>

<style scoped>
    nav{
        display: flex;
        flex-flow: row;
        justify-content: space-between;
        max-width: 100%;
        border: 1px solid black;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    li{
        list-style: none;
        display: flex;
        flex-flow: row;
        align-items: center;
    }
</style>