<template>
    <form action="{{ route('image.save') }}" method="POST">
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
            id="img-upload"
            v-html="FileName"
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
            FileName: "",
            FileLength: "",
            NewImg: {
                name: "",
                area: "",
                country: "",
            },
        };
    },
    computed: {},
    methods: {
        uploadImg() {
            this.ImgName.length > 1 &&
            this.ImgArea.length > 1 &&
            this.ImgCountry.length > 1 &&
            this.FileLength > 0
                ? ((this.NewImg.name =
                      "Ellisabenteuerland-" +
                      this.ImgCountry +
                      this.ImgArea +
                      this.ImgName),
                  (this.NewImg.area = this.ImgArea),
                  (this.NewImg.country = this.ImgCountry),
                  addImg(this.NewImg),
                  (this.ImgName = ""),
                  (this.ImgArea = ""),
                  (this.ImgCountry = ""))
                : null;
        },
        changeFile(event) {
            this.FileLength = event.target.files.length;
            console.log(event.target.files, event.target.files.length);
        },
    },
};
</script>

<style></style>
