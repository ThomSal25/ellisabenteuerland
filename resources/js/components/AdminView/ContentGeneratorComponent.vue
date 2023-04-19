<template>
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
            :style="getCoordinates(paragraph.rowStart, paragraph.rowEnd)"
        >
            <!-- <div>
                <ButtonComponent
                    buttonName="Add Above"
                    class="hide"
                    @click="addContentAbove(paragraph.createdAt)"
                />
            </div> -->
            <SelectComponent
                :preselectedContent="paragraph.contentType"
                class="hide"
                @change="kindOfContent($event, paragraph.createdAt)"
            />
            <div class="content-row">
                <!-- <ButtonComponent buttonName="Add Left" class="hide" /> -->
                <p v-html="paragraph.description"></p>
                <!-- <ButtonComponent buttonName="Add Right" class="hide" /> -->
            </div>
            <div>
                <ButtonComponent
                    buttonName="Edit"
                    class="hide"
                    @click="editContent(paragraph.createdAt)"
                />
                <ButtonComponent
                    buttonName="Delete"
                    class="hide"
                    @click="deleteParagraph(paragraph.createdAt)"
                />
            </div>
            <!-- <ButtonComponent buttonName="Add Below" class="hide" /> -->
        </article>
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
                    buttonName="Save Change"
                    @click="updateSiteContent(this.EditContent.id)"
                />
                <ButtonComponent
                    buttonName="Cancel"
                    @click="closeEditTiptapField()"
                />
            </div>
        </div>
    </div>

    <br /><br /><br /><br />
    <div class="new-content-field">
        <ButtonComponent buttonName="New Paragraph" @click="showEditField" />

        <div :class="[{ 'hide-edit-field': hideEditField }]">
            <div>
                <div class="counter-field">
                    <div>
                        <span>Number of Columns:</span>
                        <CounterFieldComponent
                            class="counter-field"
                            :count="counter"
                            @logCountUp="logNumUp()"
                            @logCountDown="logNumDown()"
                        />
                    </div>
                    <div>
                        <ButtonComponent
                            buttonName="New Content"
                            class="counter-field"
                            @click="addContentToParagraph()"
                        />
                        <ButtonComponent
                            buttonName="Delete Content"
                            class="counter-field"
                            @click="delContentToParagraph"
                        />
                    </div>
                </div>

                <p>Preview:</p>
                <div class="grid-row" :style="columnCount">
                    <div
                        v-for="paragraph in Columns"
                        :key="paragraph.createdAt"
                        id="border"
                        :style="
                            getCoordinates(paragraph.rowStart, paragraph.rowEnd)
                        "
                    >
                        <div class="counter-field">
                            <div>
                                <span>Start in row:</span
                                ><CounterFieldComponent
                                    class="counter-field"
                                    :count="paragraph.rowStart"
                                    @logCountUp="
                                        logRowSpan(
                                            paragraph.createdAt,
                                            paragraph.rowStart++
                                        )
                                    "
                                    @logCountDown="
                                        logRowSpan(
                                            paragraph.createdAt,
                                            paragraph.rowStart--
                                        )
                                    "
                                />
                            </div>
                            <div>
                                <span>End in row:</span>
                                <CounterFieldComponent
                                    class="counter-field"
                                    :count="paragraph.rowEnd"
                                    @logCountUp="
                                        logRowSpan(
                                            paragraph.createdAt,
                                            paragraph.rowEnd++
                                        )
                                    "
                                    @logCountDown="
                                        logRowSpan(
                                            paragraph.createdAt,
                                            paragraph.rowEnd--
                                        )
                                    "
                                />
                            </div>
                        </div>
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
                            <div>
                                <ol class="tube-instruction">
                                    Grundlagen für DSGVO-konformes Einbetten:
                                    <li>Video auf YouTube aufrufen</li>
                                    <li>"Teilen" anclicken</li>
                                    <li>"Einbetten" auswählen</li>
                                    <li>
                                        Erweiterten Datenschutzmodus aktivieren
                                    </li>
                                    <li>"iframe" kopieren</li>
                                    <li>
                                        "width" und "height" auf Anforderungen
                                        anpassen
                                    </li>
                                </ol>
                            </div>
                            <div>
                                <span>Add YouTube-Link:</span>
                                <!-- <InputComponent
                                    v-model="tubeLink"
                                    class="link-field"
                                /> -->
                                <textarea
                                    name="tubeLink"
                                    id=""
                                    cols="30"
                                    rows="10"
                                    v-model="tubeLink"
                                    class="link-field"
                                ></textarea>
                                <ButtonComponent
                                    buttonName="Add Link"
                                    @click="addTubeLink(paragraph.createdAt)"
                                />
                            </div>
                        </div>
                        <!-- If button selected -->
                        <div
                            :class="[
                                {
                                    'hide-edit-field': paragraph.hideBtnComp,
                                },
                            ]"
                        >
                            <div>
                                <span>Add button text:</span>
                                <InputComponent v-model="BtnText" />
                            </div>
                            <div>
                                <span>Add button link:</span>
                                <InputComponent v-model="BtnLink" />
                            </div>
                            <ButtonComponent
                                buttonName="Add Button"
                                @click="createBtn(paragraph.createdAt)"
                            />
                        </div>
                    </div>
                </div>
                <ButtonComponent
                    buttonName="Add Collumns"
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
            TiptapField: "Hier bitte Text einfügen.",
            tubeLink: "",
            BtnText: "",
            BtnLink: "",
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
            counterContent: 1,
            numOfRows: 1,
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
            return {
                gridTemplateColumns: `repeat(${this.counter}, 1fr)`,
            };
        },
    },
    methods: {
        async loadContent() {
            this.Subs = await getContent();
            this.Sitecontent = this.Subs[0].content;
        },

        // async addContentAbove(id){},

        async addContentAbove(id) {
            const newField = {
                description: "New Field",
                createdAt: Date() + Math.floor(Math.random() * 1000000),
                contentType: "",
                hideTiptapActive: true,
                hidePicDatabaseActive: true,
                hidePicUpload: true,
                hideTubeComp: true,
                hideBtnComp: true,
            };
            let contentIndex = "";
            let siteIndex = "";
            for (let item of this.Sitecontent) {
                for (let part of item) {
                    id === part.createdAt
                        ? ((siteIndex = this.Sitecontent.indexOf(item)),
                          (contentIndex = item.indexOf(part)))
                        : null;
                }
            }
            this.Sitecontent[siteIndex].splice(contentIndex, 0, newField);
        },

        async kindOfNewContent(event, id) {
            const eValue = event.target.value;
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
                        ? ((item.description = ""),
                          (item.contentType = "youtube"),
                          (item.hideTubeComp = false))
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
            for (let item of this.Sitecontent) {
                item.length <= 0
                    ? this.Sitecontent.splice(this.Sitecontent.indexOf(item), 1)
                    : null;
            }
            await this.loadContent();
        },

        showEditField() {
            this.Columns = [
                {
                    description: "New Field",
                    createdAt: Date() + 1,
                    rowStart: 1,
                    rowEnd: 1,
                    contentType: "",
                    hideTiptapActive: true,
                    hidePicDatabaseActive: true,
                    hidePicUpload: true,
                    hideTubeComp: true,
                    hideBtnComp: true,
                },
            ];
            this.counter = 1;
            this.counterContent = 1;
            return (this.hideEditField = !this.hideEditField);
        },

        addContentToParagraph() {
            this.counterContent++;
            for (let i = 1; i <= this.counterContent; i++) {
                let newParagraph = {
                    description: "New Field",
                    createdAt: Date() + i,
                    rowStart: 1,
                    rowEnd: 1,
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

        delContentToParagraph() {
            this.counterContent > 1
                ? (this.counterContent--, this.Columns.pop())
                : null;
        },

        logNumUp() {
            this.counter++;
        },

        logNumDown() {
            this.counter > 1 ? this.counter-- : null;
        },

        logRowSpan(id, itemCount) {
            for (let item of this.Columns) {
                id === item.createdAt ? itemCount : null;
            }
        },

        getCoordinates(rowStart, rowEnd) {
            return {
                gridRowStart: rowStart,
                gridRowEnd: rowEnd,
            };
            // this.counter > 1
            //     ? {
            //           gridRowStart: rowStart,
            //           gridRowEnd: rowEnd,
            //       }
            //     : null;
        },

        addImgToParagraph(id, imgToParagraph) {
            for (let item of this.Columns) {
                id === item.createdAt
                    ? (item.description = `<img src="storage/${imgToParagraph.image}" />`)
                    : null;
            }
        },

        addTubeLink(id) {
            for (let item of this.Columns) {
                id === item.createdAt
                    ? (item.description = `${this.tubeLink}`)
                    : null;
            }
        },

        createBtn(id) {
            console.log("👍");
            for (let item of this.Columns) {
                id === item.createdAt
                    ? (item.description = `<button>
                                <a href="${this.BtnLink}">${this.BtnText}</a>
                            </button>`)
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
.sitecontent {
    /* for columns of new paragraphs */
    display: grid;
    justify-content: center;
    align-items: center;
}

.change-orientation {
    display: grid;
    text-align: center;
}

.single-part {
    margin: 0.5rem;
    padding: 0.5rem;
}

.content-row {
    display: flex;
    justify-content: center;
}

.edit-container {
    display: none;
}

#border {
    border: 0.1rem solid black;
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
    grid-template-columns: repeat(2, 1fr);
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
}

.tube-instruction {
    display: inline-block;
    text-align: left;
}

.link-field {
    width: 25rem;
    height: 10rem;
}
</style>
