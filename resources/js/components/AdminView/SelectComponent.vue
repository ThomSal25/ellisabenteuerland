<template>
    <select
        name="auswahl"
        id="auswahl"
        v-model="preselectedContent"
        @change="showOption()"
    >
        <option v-if="firstClick" value="start">--Add content--</option>
        <option value="text">Text</option>
        <option value="pictureFromDatabase">Picture from Database</option>
        <option value="pictureUpload">Upload Picture</option>
        <option value="youtube">Youtube Video</option>
        <option value="button">Button</option>
    </select>
</template>

<script>
export default {
    name: "SelectComponent",
    props: {
        preselectedContent: String,
    },
    data() {
        return {
            firstClick: true,
        };
    },
    methods: {
        showOption() {
            this.firstClick = false;
        },
    },
};
</script>

<style></style>
