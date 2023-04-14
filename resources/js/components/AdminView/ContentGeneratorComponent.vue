<template>
    <div class="content-container">
        <div
            v-for="(content, index) in Sitecontent"
            :key="index"
            class="sitecontent"
        >
            <!-- <article v-html="content" class="paragraph"></article> -->
            <article
                class="article-border single-part"
                v-for="paragraph in content"
                :key="paragraph.createdAt"
            >
                <SelectComponent
                    :preselectedContent="paragraph.contentType"
                    class="hide"
                    @change="kindOfContent($event, paragraph.createdAt)"
                />

                <p v-html="paragraph.description"></p>
                <ButtonComponent
                    :buttonName="EditButton"
                    class="hide"
                    @click="editContent(paragraph.createdAt)"
                />
                <ButtonComponent
                    :buttonName="DeleteButton"
                    class="hide"
                    @click="deleteParagraph(paragraph.createdAt)"
                />
            </article>
        </div>
    </div>
    <br /><br /><br />
    <br /><br />
    <!-- EditField -->
    <div class="edit-background">
        <div
            class="edit-field"
            :class="[{ 'edit-container': hideEditContainer }]"
        >
            <p>Preview:</p>

            <p v-html="EditTiptapField.description"></p>

            <div
                class="edit-text"
                :class="[{ 'edit-container': hideEditContainer }]"
            >
                <p>New Text:</p>
                <TiptapComponent v-model="EditTiptapField.description" />
                <ButtonComponent
                    :buttonName="SaveChangeButton"
                    @click="updateSiteContent(this.EditContent.id)"
                />
                <ButtonComponent
                    :buttonName="CancelButton"
                    @click="closeEditTiptapField()"
                />
            </div>
        </div>
    </div>

    <br /><br /><br /><br />
    <div class="new-content-field">
        <ButtonComponent
            :buttonName="PrepareNewContent"
            @click="showEditField"
        />

        <div :class="[{ 'hide-edit-field': hideEditField }]">
            <div>
                <span>Number of Collumns:</span>
                <CounterFieldComponent
                    class="counter-field"
                    :count="counter"
                    @logCountUp="logNumUp()"
                    @logCountDown="logNumDown()"
                />

                <p>Preview:</p>
                <div class="grid-row" :style="columnCount">
                    <div
                        v-for="paragraph in Columns"
                        :key="paragraph.createdAt"
                    >
                        <SelectComponent
                            :preselectedContent="'start'"
                            @change="
                                kindOfNewContent($event, paragraph.createdAt)
                            "
                        />
                        <p v-html="paragraph.description"></p>
                        <!-- If Text selected -->

                        <div
                            :class="[
                                {
                                    'hide-edit-field':
                                        paragraph.hideTiptapActive,
                                },
                            ]"
                        >
                            <TiptapComponent v-model="paragraph.description" />
                        </div>
                        <!-- If  picture from database is selected-->
                        <div
                            :class="[
                                {
                                    'hide-edit-field':
                                        paragraph.hidePicDatabaseActive,
                                },
                            ]"
                        >
                            <PictureDatabaseComponent
                                @imgToParagraph="
                                    addImgToParagraph(
                                        paragraph.createdAt,
                                        $event
                                    )
                                "
                            />
                        </div>
                        <!-- If picture upload selected -->
                        <PictureUploadComponent
                            @imgToParagraph="
                                addImgToParagraph(paragraph.createdAt, $event)
                            "
                            :class="[
                                {
                                    'hide-edit-field': paragraph.hidePicUpload,
                                },
                            ]"
                        />
                        <!-- If youtube selected -->
                        <div
                            :class="[
                                {
                                    'hide-edit-field': paragraph.hideTubeComp,
                                },
                            ]"
                        >
                            <span>Add YouTube-Link:</span>
                            <InputComponent />
                            <ButtonComponent :buttonName="AddLink" />
                        </div>
                        <!-- If button selected -->
                        <div
                            :class="[
                                {
                                    'hide-edit-field': paragraph.hideBtnComp,
                                },
                            ]"
                        >
                            <span>Add button text:</span>
                            <InputComponent />
                            <ButtonComponent :buttonName="AddBtn" />
                        </div>
                    </div>
                </div>
                <ButtonComponent
                    :buttonName="AddCollumnsButton"
                    @click="createCollumns()"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { getContent, updateContent } from "../shared/api.js";

export default {
    data() {
        return {
            Subs: {},
            Sitecontent: [],
            SaveNewContent: "Save",
            CancelButton: "Cancel",
            EditButton: "Edit",
            DeleteButton: "Delete",
            SaveChangeButton: "Save Change",
            AddCollumnsButton: "Add Collumns",
            PrepareNewContent: "New Paragraph",
            AddLink: "Add Link",
            AddBtn: "Add Button Text",
            TiptapField: "Hier bitte Text einfügen.",
            hideSelect: true,
            Columns: [],
            EditTiptapField: {
                description: "",
                createdAt: "",
                contentType: "",
                tiptapActive: "",
                picDatabaseActive: "",
                picUpload: "",
                tubeComp: "",
                btnComp: "",
            },
            newParagraph: {
                description: "",
                createdAt: "",
            },
            EditContent: {},
            hideEditField: true,
            hideEditContainer: true,
            counter: 1,
            PreviewText:
                "Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, laboriosam et? Laborum necessitatibus itaque alias rerum porro dolores, quas quos perspiciatis hic quibusdam aut exercitationem repellat nesciunt nam beatae voluptates.",
            PreviewButton: "<button>Button</button>",
        };
    },
    async mounted() {
        await this.loadContent();
        this.Sitecontent === null ? (this.Sitecontent = []) : null;
    },
    computed: {
        columnCount() {
            return { gridTemplateColumns: `repeat(${this.counter}, 1fr)` };
        },
    },
    methods: {
        async loadContent() {
            this.Subs = await getContent();
            this.Sitecontent = this.Subs[0].content;
        },

        async kindOfNewContent(event, id) {
            const eValue = event.target.value;
            // console.log(eValue, event.target);
            for (let item of this.Columns) {
                item.hidePicDatabaseActive = true;
                item.hidePicUpload = true;
                item.hideTubeComp = true;
                item.hideBtnComp = true;
                item.createdAt === id
                    ? eValue === "text"
                        ? ((item.description = this.PreviewText),
                          (item.contentType = "text"),
                          (item.hideTiptapActive = false))
                        : eValue === "pictureFromDatabase"
                        ? ((item.description = ""),
                          (item.contentType = "pictureFromDatabase"),
                          (item.hidePicDatabaseActive = false))
                        : eValue === "pictureUpload"
                        ? ((item.description = ""),
                          (item.contentType = "pictureUpload"),
                          (item.hidePicUpload = false))
                        : eValue === "youtube"
                        ? ((item.description = ""), (item.hideTubeComp = false))
                        : eValue === "button"
                        ? ((item.description = ""), (item.hideBtnComp = false))
                        : null
                    : null;
            }
        },

        async kindOfContent(event, id) {
            this.EditContent = this.Subs[0];
            for (let item of this.EditContent.content) {
                for (let part of item) {
                    part.createdAt === id
                        ? event.target.value === "text"
                            ? (part.description = this.PreviewText)
                            : event.target.value === "pictureFromDatabase"
                            ? (part.description = '<img src="" alt="">')
                            : event.target.value === "pictureUpload"
                            ? (part.description = '<img src="" alt="">')
                            : event.target.value === "youtube"
                            ? (part.description = this.PreviewButton)
                            : event.target.value === "button"
                            ? (part.description = this.PreviewButton)
                            : null
                        : null;
                }
            }
            await updateContent(1, this.EditContent);
            await this.loadContent();
        },

        async editContent(id) {
            this.hideSelect = false;
            this.hideEditContainer = false;

            this.EditContent = this.Subs[0];
            // find Paragraph, witch you want to edit & put Text and id into the EditTiptapField
            for (let item of this.EditContent.content) {
                for (let part of item) {
                    part.createdAt === id
                        ? (this.EditTiptapField = part)
                        : null;
                }
            }
        },

        async updateSiteContent(id) {
            await updateContent(id, this.EditContent);
            await this.loadContent();
            this.closeEditTiptapField();
        },

        closeEditTiptapField() {
            this.EditTiptapField = "";
            this.hideEditContainer = true;
        },

        async deleteParagraph(id) {
            // because it will only delete a array of the Sitecontent, we need the updateContent-method
            this.EditContent = this.Subs[0];
            for (let item of this.EditContent.content) {
                for (let part of item) {
                    part.createdAt === id
                        ? item.splice(item.indexOf(part), 1)
                        : null;
                }
            }

            await updateContent(this.EditContent.id, this.EditContent);
            await this.loadContent();
        },

        showEditField() {
            this.Columns = [
                {
                    description: "New Field",
                    createdAt: Date() + 1,
                    contentType: "",
                    hideTiptapActive: true,
                    hidePicDatabaseActive: true,
                    hidePicUpload: true,
                    hideTubeComp: true,
                    hideBtnComp: true,
                },
            ];
            return (this.hideEditField = !this.hideEditField);
        },

        logNumUp() {
            this.counter++;

            for (let i = 1; i <= this.counter; i++) {
                let newParagraph = {
                    description: "New Field",
                    createdAt: Date() + i,
                    contentType: "",
                    hideTiptapActive: true,
                    hidePicDatabaseActive: true,
                    hidePicUpload: true,
                    hideTubeComp: true,
                    hideBtnComp: true,
                };
                i > this.Columns.length
                    ? this.Columns.push(newParagraph)
                    : null;
            }
        },

        logNumDown() {
            this.counter > 1 ? (this.counter--, this.Columns.pop()) : null;
        },

        addImgToParagraph(id, imgToParagraph) {
            for (let item of this.Columns) {
                console.log("id: ", id, "item.id: ", item.createdAt);
                id === item.createdAt
                    ? ((item.description = `<img src="storage/${imgToParagraph.image}" />`),
                      console.log(item))
                    : null;
            }
        },

        async createCollumns() {
            this.Sitecontent.push(this.Columns);
            //load all information for the put method and add the content of the current view
            this.EditContent = this.Subs[0];
            this.EditContent.content = this.Sitecontent;
            this.Columns = [];
            this.counter = 1;
            this.showEditField();
            await updateContent(1, this.EditContent);
            await this.loadContent();
        },
    },
};
</script>

<style>
.content-container {
    display: grid;
}

.single-part {
    margin: 0.5rem;
    padding: 0.5rem;
}

.edit-container {
    display: none;
}

#border {
    border: 0.1rem solid black;
}

.sitecontent {
    /* for columns of new paragraphs */
    display: flex;
    justify-content: center;
    align-items: center;
}

.paragraph {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.hide {
    display: none;
}

/* .hide-select {
    display: none;
} */

.sitecontent:hover .hide {
    display: inline;
}

.sitecontent:hover .article-border {
    border: 0.1rem solid black;
    border-radius: 1rem;
}

.edit-background {
    background-color: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 0;
    height: 100vh;
}

.edit-field {
    border: 0.1rem solid black;
    border-radius: 2rem;
    padding: 2rem;
    background-color: antiquewhite;
    width: 75%;
    transform: translate(12.5%, 50%);
    /* transform: translateY(50%); */
}

.hide-edit-field {
    display: none;
}

.grid-row {
    display: grid;
}

.new-content-field {
    margin-bottom: 5rem;
}

.counter-field {
    display: grid;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
}
</style>
