<template>
    <ul class="img-preview">
        <li
            v-for="Pic in allPics"
            :key="Pic.id"
            class="img-focus"
            @click="selectImg(Pic)"
        >
            <img v-bind:src="'storage/' + Pic.image" width="250" />
        </li>
    </ul>
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
            this.allPics = await getPicture();
        },

        selectImg(element) {
            this.$emit("imgToParagraph", element);
        },
    },
};
</script>

<style>
.img-preview {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    align-items: center;
    gap: 1rem;
}

.img-focus {
    transition: 1s;
}

.img-focus:hover {
    border: 0.1rem solid black;
    transform: scale(1.2);
}
</style>
