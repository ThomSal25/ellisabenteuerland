<template>
    <div class="home">
        <Admin />
    </div>
</template>

<script>
// @ is an alias to /src
import Admin from "../Admin.vue";

export default {
    name: "HomeView",
    components: {
        Admin,
    },
};
</script>
