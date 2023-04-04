import axios from "axios";

export async function getContent() {
    const res = await axios.get("/content/list");
    for (let item of res.data) {
        if (item.isActive === 0) {
            item.isActive = false;
        } else {
            item.isActive = true;
        }
    }
    return res.data;
}

export async function addContent(content) {
    await axios.post("/content/createContent", content);
}

export async function updateContent(id, content) {
    await axios.put(`/content/updateContent/${id}`, content);
}

export async function deleteContent(id) {
    await axios.delete(`/content/deleteContent/${id}`);
}

export async function addImg(pic) {
    await axios.post("/image", pic);
}
