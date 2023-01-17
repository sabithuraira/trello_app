<template>
  <div id="app">
    <Dashboard msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
  import Dashboard from './components/Dashboard.vue'

  export default {
    name: 'App',
    components: {
      Dashboard
    }
  }
</script>

<style>
    :root {
        font-size: 10px;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        background-color: #0079bf;
    }

    .btn {
        display: flex;
        justify-content: center;
        align-items: center;
        font: inherit;
        background: none;
        border: none;
        color: inherit;
        padding: 0;
        cursor: pointer;
    }

    :focus {
        outline-color: #fa0;
    }

    @supports (display: grid) {
        body {
            display: grid;
            grid-template-rows: 4rem 3rem auto;
            grid-row-gap: 0.8rem;
        }

        .masthead {
            display: grid;
            grid-template-columns: auto 1fr auto;
            grid-column-gap: 2rem;
        }

        .boards-menu {
            display: grid;
            grid-template-columns: 9rem 18rem;
            grid-column-gap: 0.8rem;
        }

        .user-settings {
            display: grid;
            grid-template-columns: repeat(4, auto);
            grid-column-gap: 0.8rem;
        }

        .board-controls {
            display: grid;
            grid-auto-flow: column;
            grid-column-gap: 1rem;
        }

        .lists-container {
            display: grid;
            grid-auto-columns: 27rem;
            grid-auto-flow: column;
            grid-column-gap: 1rem;
        }

        .list {
            display: grid;
            grid-template-rows: auto minmax(auto, 1fr) auto;
        }

        .list-items {
            display: grid;
            grid-row-gap: 0.6rem;
        }

        .logo,
        .list,
        .list-items li,
        .boards-btn,
        .board-info-bar,
        .board-controls .btn,
        .user-settings-btn {
            margin: 0;
        }
    }

    .modal-form{
        padding: 10px;
    }
</style>
