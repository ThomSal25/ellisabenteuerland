<template>
    <form action="">
        <ul>
            <li v-for="content in Subs" :key="content.id">
                {{ content }}
                <ButtonComponent :buttonName="EditButton" @click="" />
                <!-- Edit -->
            </li>
        </ul>
    </form>
    <div v-for="(content, index) in Sitecontent" :key="index">
        <p v-html="content"></p>
    </div>

    <div id="border">
        <TiptapComponent v-model="newParagraph" />

        <ButtonComponent
            :buttonName="SaveNewContent"
            @click="addNewContent()"
        />
        <ButtonComponent :buttonName="CancelButton" @click="" />
        <!-- Cancel -->
    </div>
</template>

<script>
import { getContent, updateContent, deleteContent } from "../shared/api.js";

export default {
    data() {
        return {
            Subs: {},
            Sitecontent: [],
            SaveNewContent: "Save",
            CancelButton: "Cancel",
            EditButton: "Edit",
            newParagraph: "",
            EditContent: {},
        };
    },
    async mounted() {
        await this.loadContent();
    },
    computed: {},
    methods: {
        async loadContent() {
            this.Subs = await getContent();
            this.Sitecontent = this.Subs[0].content;
        },
        async addNewContent() {
            this.Sitecontent.push(this.newParagraph);
            this.EditContent = this.Subs[0];
            this.EditContent.content = this.Sitecontent;
            console.log(this.EditContent.content.length);

            this.newParagraph = "";
            await updateContent(1, this.EditContent);
            await this.loadContent();
        },
    },
};
</script>

<style>
#border {
    border: 0.1rem solid black;
}
</style>
