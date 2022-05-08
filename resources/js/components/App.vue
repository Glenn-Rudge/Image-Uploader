<template>
    <div>
        <div class="mt-4">
            <file-pond
                name="image"
                ref="pond"
                label-idle="Click to choose image or drag here..."
                v-on:init="filepondInitialized"
                accepted-file-types="image/jpg, image/jpeg, image/png"
                :allowMultiple="true"
                :allowReorder="true"
                max-file-size="1MB"
                @processfile="handleProcessedFile"
            />
        </div>
        <div class="mt-8 mb-24">
            <h3 class="text-2xl font-medium text-center">Image Gallery</h3>
            <div class="grid grid-cols-3 gap-2 justify-evenly mt-4">
                <div v-for="(image, index) in images" :key="index">
                    <img :src="'/storage/images/' + image" :alt="image">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vueFilePond, {setOptions} from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidationType from "filepond-plugin-file-validate-type";
import FilePondPluginFileValidationSize from "filepond-plugin-file-validate-size";

let serverMessage = {};

setOptions({
    server: {
        process: {
            url: "./upload",
            onError: (response) => {
                serverMessage = JSON.parse(response);
            },
            headers: {
                "X-CSRF-TOKEN": document.head.querySelector("meta[name='csrf_token']").content
            }
        }
    },
    labelFileProcessingError: () => {
        return serverMessage.error;
    }
})

const FilePond = vueFilePond(FilePondPluginFileValidationType, FilePondPluginFileValidationSize);

export default {
    name: "App",

    components: {
        FilePond,
    },

    data() {
        return {
            images: [],
        }
    },

    methods: {
        filepondInitialized() {
        },

        handleProcessedFile(error, file) {
            if(error) {
                console.log(error);
                return;
            }

            this.images.unshift(file.serverId);
        }
    },

    mounted() {
        axios.get("/images")
            .then((response) => {
                this.images = response.data;
            })
            .catch((error) => {
                console.log(error);
            })
    }
}
</script>

<style scoped>

</style>
