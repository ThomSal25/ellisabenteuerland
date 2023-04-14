<template>
    <div class="form-orientation">
        <form
            class="pic-form"
            action="{{ route('image.save') }}"
            method="POST"
            @submit.prevent="uploadImg()"
            enctype="multipart/form-data"
        >
            <div>
                <h3>Picture Upload</h3>
                <p class="pic-info">
                    <span>Picture Description: </span>
                    <InputComponent v-model="ImgName" name="name" required />
                    <span>Area: </span>
                    <InputComponent v-model="ImgArea" name="area" required />
                    <span>Country: </span>
                    <InputComponent
                        v-model="ImgCountry"
                        name="country"
                        required
                    />
                </p>
            </div>
            <input
                type="file"
                accept="image/png, image/gif, image/jpeg"
                name="image"
                id="image"
                required
                @change="changeFile"
            />
            <ButtonComponent :buttonName="UploadButton" />
        </form>
    </div>
    <!-- <PictureDatabaseComponent /> -->
</template>

<script>
import { addImg, getPicture } from "../shared/api.js";

export default {
    emits: ["imgToParagraph"],
    data() {
        return {
            UploadButton: "Upload",
            ImgName: "",
            ImgArea: "",
            ImgCountry: "",
            FileLength: "",
            UploadedFile: "",
            NewImg: {
                image: "",
                area: "",
                country: "",
            },
            allPics: [],
            lastPic: {},
        };
    },
    computed: {},
    methods: {
        async uploadImg() {
            // send img to img-backend
            const fileData = new FormData();
            fileData.append("image", this.UploadedFile);
            fileData.append("name", this.ImgName);
            fileData.append("area", this.ImgArea);
            fileData.append("country", this.ImgCountry);

            this.ImgName.length > 1 &&
            this.ImgArea.length > 1 &&
            this.ImgCountry.length > 1 &&
            this.FileLength > 0
                ? ((this.NewImg.image = fileData),
                  (this.NewImg.name = this.ImgName),
                  (this.NewImg.area = this.ImgArea),
                  (this.NewImg.country = this.ImgCountry),
                  await addImg(fileData),
                  (this.ImgName = ""),
                  (this.ImgArea = ""),
                  (this.ImgCountry = ""))
                : null;

            // show uploaded img in paragraph
            this.allPics = await getPicture();
            console.log("👍", this.allPics);
            console.log("👍👍");
            this.lastPic = this.allPics.pop();
            console.log(this.lastPic);
            this.$emit("imgToParagraph", this.lastPic);
        },

        changeFile(event) {
            this.FileLength = event.target.files.length;
            this.UploadedFile = event.target.files[0];
        },
    },
};
</script>

<style>
.form-orientation {
    display: inline-block;
}
.pic-form {
    border: 0.1rem solid black;
    border-radius: 1rem;
    max-width: 50rem;
    padding: 1rem;
    margin: 1rem;
    text-align: center;
}

.pic-info {
    display: grid;
    grid-template-columns: 1fr 3fr;
}
</style>
