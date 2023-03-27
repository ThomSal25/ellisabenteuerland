<template>
    <div class="nav-container">
        <nav>
            <ul>
                <li v-for="content in Subs" :key="content.id">
                    <router-link
                        :to="content.route"
                        :class="[{ 'is-active': !content.isActive }]"
                        >{{ content.name }}</router-link
                    >
                    <input
                        type="checkbox"
                        class="hide"
                        name=""
                        :id="content.id"
                        @click="setActive(content.id)"
                        v-model="content.isActive"
                    />
                    <ButtonComponent
                        :buttonName="EditContent"
                        @click="toggleEditForm(content.id)"
                        class="hide"
                    />
                    <ButtonComponent
                        :buttonName="DeleteContent"
                        @click="deleteTopic(content.id)"
                        class="hide"
                    />
                </li>
            </ul>
        </nav>
        <ButtonComponent :buttonName="NewContent" @click="toggleForm" />
        <form
            class="add-form"
            action="./api/list_entries"
            method="POST"
            @submit.prevent="addNewContent()"
            :class="[{ 'show-form': showForm }]"
        >
            <InputComponent v-model="newContent.name" />
            <ButtonComponent :buttonName="AddContent" :disabled="isDisabled" />
        </form>
    </div>
    <div :class="[{ 'show-editform': showEditform }]">
        <span>New Site Name: </span>
        <InputComponent v-model="editContent.name" />
        <ButtonComponent
            :buttonName="SaveChange"
            @click="editContentName(editContent.id)"
            :disabled="editIsDisabled"
        />
        <ButtonComponent :buttonName="Cancel" @click="CloseEditForm()" />
    </div>
</template>

<script>
import {
    getContent,
    addContent,
    updateContent,
    deleteContent,
} from "../shared/api.js";

export default {
    data() {
        return {
            NewContent: "New Content",
            AddContent: "Add Content",
            EditContent: "Edit Content",
            DeleteContent: "Delete Content",
            SaveChange: "Save Change",
            Cancel: "Cancel",
            showForm: true,
            showEditform: true,
            newContent: {
                name: "",
                route: "",
                content: "",
                isActive: "",
            },
            editContent: {
                name: "",
                route: "",
                content: "",
                isActive: "",
            },
            Subs: {},
        };
    },
    async mounted() {
        await this.loadContent();
    },
    computed: {
        isHidden() {
            return this.hiddenState;
        },
        isDisabled() {
            return this.newContent.name.length === 0;
        },
        editIsDisabled() {
            return this.editContent.name.length === 0;
        },
    },
    methods: {
        toggleForm() {
            this.showForm = !this.showForm;
        },

        toggleEditForm(id) {
            this.showEditform = false;
            for (let item of this.Subs) {
                if (id === item.id) {
                    this.editContent = item;
                }
            }
        },

        CloseEditForm() {
            this.showEditform = true;
        },

        async loadContent() {
            this.Subs = await getContent();
        },

        async addNewContent() {
            this.newContent.route = this.newContent.name;
            this.replaceUmlauts(this.newContent.route);
            this.newContent.content = "{}";
            this.newContent.isActive = false;
            await addContent(this.newContent);
            await this.loadContent();
            this.newContent.name = "";
        },

        async setActive(id) {
            for (let item of this.Subs) {
                if (id === item.id) {
                    item.isActive = !item.isActive;
                    await updateContent(item.id, item);
                }
            }

            await this.loadContent();
        },

        async editContentName(id) {
            await updateContent(id, this.editContent);
            await this.loadContent();
            this.CloseEditForm();
        },

        async deleteTopic(id) {
            for (let item of this.Subs) {
                if (
                    id === item.id &&
                    confirm(
                        "Warning, whole content of this topic will be deleted!"
                    )
                ) {
                    await deleteContent(id);
                }
            }

            await this.loadContent();
        },

        replaceUmlauts(str) {
            this.newContent.route = str
                .toLowerCase()
                .replace(/ä/g, "ae")
                .replace(/ö/g, "oe")
                .replace(/ü/g, "ue")
                .replace(/ß/g, "ss")
                .replace(/\s/g, "-");
        },
    },
};
</script>

<style>
.nav-container {
    display: flex;
    justify-content: space-between;
}

ul {
    display: flex;
    list-style-type: none;
    justify-content: space-between;
    gap: 2rem;
}

li .hide {
    display: none;
}

li:hover .hide {
    display: inline;
}

.is-active {
    text-decoration: line-through;
    color: grey;
}

.show-form {
    display: none;
}

.show-editform {
    display: none;
}
</style>
