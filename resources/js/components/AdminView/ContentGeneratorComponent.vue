<template>
    <!-- <form action="">
        <ul>
            <li v-for="content in Subs" :key="content.id">
                {{ content }}
                <ButtonComponent :buttonName="EditButton" @click="" />
                Edit
            </li>
        </ul>
    </form> -->
    <div
        v-for="content in Sitecontent"
        :key="content.createdAt"
        class="sitecontent"
    >
        <article v-html="content.description" class="paragraph"></article>
        <ButtonComponent :buttonName="EditButton" class="hide" @click="" />
        <ButtonComponent :buttonName="DeleteButton" class="hide" @click="" />
    </div>
    <br /><br /><br /><br /><br />

    <ButtonComponent :buttonName="PrepareNewContent" @click="showEditField" />

    <div :class="[{ 'hide-edit-field': hideEditField }]">
        <p>Preview:</p>
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sapiente
            unde animi dicta voluptatum quibusdam soluta et debitis
            reprehenderit? Dolore nihil, omnis velit ab quo officiis voluptatem
            praesentium laboriosam maiores quia.
        </p>
        <div>
            <span>Number of Collumns:</span> <InputComponent value="1" />
            <ButtonComponent :buttonName="AddCollumnsButton" />
        </div>
        <select name="auswahl" id="auswahl">
            <option value="">--Add content--</option>
            <option value="text">Text</option>
            <option value="pictureFromDatabase">Picture from Database</option>
            <option value="pictureUpload">Upload Picture</option>
            <option value="youtube">Youtube Video</option>
            <option value="button">Button</option>
        </select>

        <div id="border">
            <TiptapComponent v-model="TiptapField" />

            <ButtonComponent
                :buttonName="SaveNewContent"
                @click="addNewContent()"
            />
            <ButtonComponent :buttonName="CancelButton" @click="" />
            <!-- Cancel -->
        </div>
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
            DeleteButton: "Delete",
            AddCollumnsButton: "Add Collumns",
            PrepareNewContent: "New Paragraph",
            TiptapField: "Hier bitte Text einfügen.",
            newParagraph: {
                description: "",
                createdAt: "",
            },
            EditContent: {},
            hideEditField: true,
        };
    },
    async mounted() {
        await this.loadContent();
        if (this.Sitecontent === null) {
            this.Sitecontent = [];
        }
    },
    computed: {},
    methods: {
        async loadContent() {
            this.Subs = await getContent();
            this.Sitecontent = this.Subs[0].content;
        },
        async addNewContent() {
            // Add current text into a new paragraph, createdAt will be used as 'id' to identify it in a for-loop
            this.newParagraph.description = this.TiptapField;
            this.newParagraph.createdAt = Date();
            // new paragraph will be pushed in the array with the content of the current view
            this.Sitecontent.push(this.newParagraph);
            //load all information for the put method and add the content of the current view
            this.EditContent = this.Subs[0];
            this.EditContent.content = this.Sitecontent;

            this.TiptapField = "";
            await updateContent(1, this.EditContent);
            await this.loadContent();
        },
        showEditField() {
            return (this.hideEditField = !this.hideEditField);
        },
    },
};
</script>

<style>
#border {
    border: 0.1rem solid black;
}

.sitecontent {
    display: flex;
}

.paragraph {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.hide {
    display: none;
}

.sitecontent:hover .hide {
    display: inline;
}

.hide-edit-field {
    display: none;
}
</style>
