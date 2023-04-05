<template>
    <form
        action="{{ route('image.save') }}"
        method="POST"
        @submit.prevent="uploadImg()"
        enctype="multipart/form-data"
    >
        <div>
            <h3>Picture Upload</h3>
            <span>Picture Description: </span>
            <InputComponent v-model="ImgName" name="name" required />
            <span>Area: </span>
            <InputComponent v-model="ImgArea" name="area" required />
            <span>Country: </span>
            <InputComponent v-model="ImgCountry" name="country" required />
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
</template>

<script>
import { addImg } from "../shared/api.js";

export default {
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
        };
    },
    computed: {},
    methods: {
        uploadImg() {
            const fileData = new FormData();
            fileData.append("image", this.UploadedFile);
            fileData.append("name", this.ImgName);
            fileData.append("area", this.ImgArea);
            fileData.append("country", this.ImgCountry);
            console.log(fileData);

            this.ImgName.length > 1 &&
            this.ImgArea.length > 1 &&
            this.ImgCountry.length > 1 &&
            this.FileLength > 0
                ? ((this.NewImg.image = fileData),
                  (this.NewImg.name = this.ImgName),
                  (this.NewImg.area = this.ImgArea),
                  (this.NewImg.country = this.ImgCountry),
                  addImg(fileData),
                  (this.ImgName = ""),
                  (this.ImgArea = ""),
                  (this.ImgCountry = ""))
                : null;
        },
        changeFile(event) {
            this.FileLength = event.target.files.length;
            this.UploadedFile = event.target.files[0];
            console.log(event.target.files[0], event.target.files.length);
            // console.log(event);
        },
    },
};
</script>

<style></style>
