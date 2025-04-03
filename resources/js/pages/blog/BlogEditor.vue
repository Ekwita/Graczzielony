<template>
    <div class="container">
        <h1 class="title">Kreator wpisu na bloga</h1>
        <input type="text" v-model="title" placeholder="Tytuł wpisu" class="input" />
        <input type="file" @change="handleMainImage" class="file-input" />
        <img v-if="mainImagePreview" :src="mainImagePreview" class="preview" />

        <div v-for="(section, index) in content" :key="index" class="content-section">
            <input v-if="section.type === 'heading'" v-model="section.text" placeholder="Nagłówek" class="input" />
            <textarea v-else-if="section.type === 'paragraph'" v-model="section.text" placeholder="Akapit"
                class="textarea"></textarea>
            <div v-else-if="section.type === 'image'" class="image-preview">
                <img :src="section.src" class="preview" />
                <input v-model="section.caption" placeholder="Podpis zdjęcia" class="input" />
            </div>
            <button @click="removeSection(index)" class="remove-button">Usuń</button>
        </div>

        <div class="button-group">
            <button @click="addSection('heading')" class="button">Dodaj nagłówek</button>
            <button @click="addSection('paragraph')" class="button">Dodaj akapit</button>
            <button @click="addImageSection" class="button">Dodaj obraz</button>
        </div>

        <button @click="submitPost" class="submit-button">Zapisz wpis</button>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const title = ref('');
const mainImage = ref(null);
const mainImagePreview = ref(null);
const content = ref([{ type: 'heading', text: '' }, { type: 'paragraph', text: '' }]);

const addSection = (type) => {
    content.value.push({ type, text: '' });
};

const addImageSection = () => {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = (e) => {
        const file = e.target.files[0];
        if (file) {
            const imageUrl = URL.createObjectURL(file);
            content.value.push({ type: 'image', src: imageUrl, file, caption: '' });
        }
    };
    input.click();
};

const removeSection = (index) => {
    content.value.splice(index, 1);
};

const handleMainImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        mainImage.value = file;
        mainImagePreview.value = URL.createObjectURL(file);
    }
};

const submitPost = () => {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('main_image', mainImage.value);
    content.value.forEach((section, index) => {
        formData.append(`content[${index}][type]`, section.type);
        if (section.type === 'image' && section.file) {
            formData.append(`content[${index}][file]`, section.file);
            formData.append(`content[${index}][caption]`, section.caption);
        } else {
            formData.append(`content[${index}][text]`, section.text);
        }
    });

    router.post('/blog/store', formData);
};
</script>

<style scoped>
.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 30px;
    background: #121212;
    border-radius: 12px;
    color: #fff;
    box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.1);
}

.title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.input,
.textarea,
.file-input {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    background: #222;
    border: 1px solid #444;
    color: white;
    border-radius: 6px;
}

.textarea {
    height: 120px;
    resize: none;
}

.button-group {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.button {
    background: #ff6b00;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}

.button:hover {
    background: #e65a00;
}

.submit-button {
    width: 100%;
    background: #28a745;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.submit-button:hover {
    background: #218838;
}

.preview {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
    border-radius: 6px;
    border: 1px solid #444;
}

.image-preview {
    text-align: center;
    margin-bottom: 15px;
}

.remove-button {
    background: #dc3545;
    color: white;
    padding: 8px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
}

.remove-button:hover {
    background: #c82333;
}
</style>