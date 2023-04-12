<template>
    <!-- <ul>
        <li v-for="Pic in allPics" :key="Pic.id">
            'storage/' +{{ Pic.image }}
            <img v-bind:src="'storage/' + Pic.image" />
        </li>
    </ul> -->
    <div class="img-preview">
        <div v-for="image in allPics" :key="image.id">
            <img v-bind:src="'/storage/' + image.image" width="250" />
        </div>
    </div>
</template>

<script>
import { getPicture } from "../shared/api.js";
export default {
    data() {
        return { allPics: [] };
    },
    async mounted() {
        await this.loadPics();
    },
    methods: {
        async loadPics() {
            // this.allPics = await getPicture();
            axios
                .get("/allImg")
                .then((response) => {
                    this.allPics = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
.img-preview {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
</style>
