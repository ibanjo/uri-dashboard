<!-- Manages single file upload and retrieval for important documents (e.g. learning agreement) -->
<template>
    <el-form :inline="true">
        <el-form-item :label="label">
            <el-upload
                    :action="uploadUrl"
                    ref="DocumentUploader"
                    :data="uploaderAdditions.data"
                    :headers="uploaderAdditions.headers"
                    :name="fileKey"
                    :show-file-list="false"
                    :multiple="false"
                    :auto-upload="false"
                    :on-change="onDocumentSelected"
                    :on-success="onDocumentUploaded">
                <el-button slot="trigger" size="small" type="primary" :disabled="disabled">Scegli allegato
                </el-button>
                <el-button size="small" type="success" @click="uploadDocument" :disabled="disabled">
                    Carica file
                </el-button>
                <div slot="tip" class="el-upload__tip">Massima dimensione: 10Mb</div>
            </el-upload>
        </el-form-item>
        <el-form-item v-if="readyToUpload" label="">
            <i class="fa fa-fw fa-file-pdf-o"></i><span> {{ namePreview }}</span>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name: 'document-uploader',
        props: {
            uploadUrl: {type: String, required: true},
            documentType: {type: String, required: true},
            mobilityBuffer: {type: Object, required: true},
            label: {type: String, default: 'Document'},
            fileKey: {type: String, default: 'document'},
            disabled: {type: Boolean, default: false},
        },
        data: function () {
            return {
                attachmentBuffer: [],
                namePreview: ''
            }
        },
        computed: {
            uploaderAdditions: function () {
                return {
                    data: {
                        mobility_id: this.mobilityBuffer.id,
                        document_type: this.documentType
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            },
            readyToUpload: function () {
                return this.attachmentBuffer.length > 0;
            }
        },
        methods: {
            onDocumentSelected: function () {
                let fileList = this.$refs.DocumentUploader.uploadFiles;
                if(fileList.length > 0) {
                    this.attachmentBuffer = [fileList[fileList.length - 1]];
                    this.namePreview = this.attachmentBuffer[0].name;
                }
            },
            uploadDocument: function () {
                this.$refs.DocumentUploader.uploadFiles = this.attachmentBuffer;
                this.$refs.DocumentUploader.submit();
            },
            onDocumentUploaded: function (response, file, fileList) {
                this.$message({
                    type: response.status,
                    message: response.message
                });
                this.mobilityBuffer[this.documentType] = response.file;
                this.$refs.DocumentUploader.uploadFiles = [];
                this.attachmentBuffer = [];
            }
        }
    }
</script>

<style scoped>

</style>