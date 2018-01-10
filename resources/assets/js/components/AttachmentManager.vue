<template>
    <div>
        <el-row type="flex" justify="space-between" align="middle">
            <el-col :span="6">
                <el-upload
                        action="/file/attach"
                        ref="attachmentUploader"
                        :data="attachmentAdditions.data"
                        :headers="attachmentAdditions.headers"
                        name="attachment"
                        :show-file-list="false"
                        :multiple="false"
                        :auto-upload="false"
                        :on-change="onAttachmentSelected"
                        :on-success="onAttachmentUploaded">
                    <el-button slot="trigger" size="small" type="primary">Scegli allegato
                    </el-button>
                    <el-button size="small" type="success" @click="uploadAttachment">
                        Carica file
                    </el-button>
                    <div slot="tip" class="el-upload__tip">Massima dimensione: 10Mb</div>
                </el-upload>
            </el-col>
            <el-col :span="8">
                <upload-preview v-if="attachment_buffer.length > 0"
                                :name="attachment_buffer[0].name"/>
            </el-col>
            <el-col :span="10" v-if="attachment_buffer.length > 0">
                <el-input placeholder="Descrizione dell'allegato (opzionale)"
                          v-model="attachment_description"></el-input>
            </el-col>
        </el-row>

        <el-row v-if="hasAttachments">
            <el-table :data="attachmentArray" style="width: 100%" @cell-click="onAttachmentClicked">
                <el-table-column label="Download">
                    <template slot-scope="scope">
                        <i class="fa fa-fw fa-file-pdf-o"></i>
                    </template>
                </el-table-column>

                <el-table-column label="Nome" prop="name" sortable>
                </el-table-column>

                <el-table-column label="Descrizione" prop="description" sortable>
                </el-table-column>

                <el-table-column label="Data" prop="created_at" sortable>
                    <!--TODO integrate momentJs in webpack to format dates -->
                </el-table-column>

                <el-table-column label="Elimina">
                    <template slot-scope="scope">
                        <i class="fa fa-fw fa-trash"></i>
                    </template>
                </el-table-column>
            </el-table>
        </el-row>

        <el-row v-else>
            <p>Nessun allegato presente</p>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: 'attachment-manager',
        props: {
            mobilityId: Number,
            attachments: Array
        },
        data: function () {
            return {
                attachment_description: '',
                attachment_buffer: [],
                attachmentArray: this.attachments
            }
        },
        computed: {
            hasAttachments: function () {
                return this.attachmentArray.length > 0;
            },
            attachmentAdditions: function () {
                return {
                    data: {
                        mobility_id: this.mobilityId,
                        description: this.attachment_description
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            }
        },
        methods: {
            onAttachmentSelected: function () {
                this.attachment_buffer = this.$refs.attachmentUploader.uploadFiles;
            },
            uploadAttachment: function () {
                let fileList = this.$refs.attachmentUploader.uploadFiles;
                this.$refs.attachmentUploader.uploadFiles = [fileList[fileList.length - 1]];
                this.$refs.attachmentUploader.submit();
            },
            onAttachmentUploaded: function (response, file, fileList) {
                this.$message({
                    type: response.status,
                    message: response.message
                });
                this.attachmentArray.push(response.file);
                this.$refs.attachmentUploader.uploadFiles = [];
                this.attachment_description = '';
            },
            onAttachmentClicked: function (file, column, cell, event) {
                switch (column.label) {
                    case "Download":
                        this.downloadAttachment(file);
                        break;
                    case "Elimina":
                        this.$confirm('Eliminare l\'allegato?', 'Info', {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Annulla',
                            type: 'info'
                        }).then(() => {
                            this.removeAttachment(file);
                        }).catch(() => {
                        });
                        break;
                    default:
                        break;
                }
            },
            downloadAttachment: function (file) {
                axios.post('/file/retrieve/', {id: file.id})
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        window.open(response.data.url);
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },
            removeAttachment: function (file) {
                axios.delete('/file/delete/' + file.id)
                    .then(response => {
                        this.attachmentArray = this.attachmentArray.filter(att => {
                            return att.id !== file.id
                        });
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                    })
                    .catch(error => {
                        console.log(error);
                        this.$message({
                            type: error.response.data.status,
                            message: error.response.data.message
                        });
                    })
            }
        },
        components: {
            'upload-preview': {
                template: `<div><i class="fa fa-fw fa-file"></i>In caricamento: {{ name }}</div>`,
                props: ['name', 'type']
            }
        }
    }
</script>

<style scoped>

</style>