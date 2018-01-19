<template>
    <div>
        <el-row style="margin-bottom: 20px">
            <el-col :span="24">
                <el-tabs type="border-card">
                    <el-tab-pane> <!-- Learning Agreement -->
                        <span slot="label">
                            <i class="fa fa-fw fa-handshake-o"></i> Learning Agreement
                        </span>
                        <el-form :inline="true">
                            <el-form-item label="Sede estera:">
                                <el-select v-model="mobilityBuffer.university_branch_id"
                                           placeholder="Sede estera" :disabled="!editMobility"
                                           :style="universityBranchStyle" filterable
                                           @change="addModified('university_branch_id')">
                                    <el-option
                                            v-for="branch in universityBranches"
                                            :key="branch.id"
                                            :label="branch.name"
                                            :value="branch.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="CFU previsti da esami:">
                                <el-input-number
                                        v-model="mobilityBuffer.estimated_cfu_exams"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('estimated_cfu_exams')"/>
                            </el-form-item>
                            <el-form-item label="CFU previsti da tesi:">
                                <el-input-number
                                        v-model="mobilityBuffer.estimated_cfu_thesis"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('estimated_cfu_thesis')"/>
                            </el-form-item>
                            <br>
                            <el-form-item label="Semestre:">
                                <el-select v-model="mobilityBuffer.semester_id"
                                           placeholder="Semestre" :disabled="!editMobility"
                                           :style="semesterStyle"
                                           @change="addModified('semester_id')">
                                    <el-option
                                            v-for="semester in semesters"
                                            :key="semester.id"
                                            :label="semester.name_ita"
                                            :value="semester.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item label="Inizio contratto:">
                                <el-date-picker
                                        v-model="mobilityBuffer.estimated_in"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        value-format="dd-MM-yyyy"
                                        placeholder="Inizio contratto"
                                        @change="addModified('estimated_in')">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="Fine contratto:">
                                <el-date-picker
                                        v-model="mobilityBuffer.estimated_out"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        value-format="dd-MM-yyyy"
                                        placeholder="Fine contratto"
                                        @change="addModified('estimated_out')">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="Anno accademico: ">
                                <el-input v-model="mobilityBuffer.academic_year" :disabled="!editMobility"
                                          @change="addModified('academic_year')"/>
                            </el-form-item>
                            <el-form-item label="Numero contratto: ">
                                <el-input
                                        v-model="mobilityBuffer.contract_number"
                                        :disabled="!editMobility" @change="addModified('contract_number')">
                                </el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-switch
                                        style="display: block"
                                        v-model="mobilityBuffer.granted"
                                        active-color="#13ce66"
                                        inactive-color="#ff4949"
                                        active-text="Assegnatario"
                                        inactive-text="Idoneo"
                                        :disabled="!editMobility"
                                        @change="addModified('granted')">
                                </el-switch>
                            </el-form-item>
                            <br>

                            <el-form-item label="Learning agreement caricato: ">
                                <div v-if="mobilityBuffer.learning_agreement === null">
                                    <i class="fa fa-fw fa-exclamation-triangle"></i>
                                    <span> Documento non caricato</span>
                                </div>
                                <div v-else>
                                    <i class="fa fa-fw fa-file-o"></i>
                                    <span> {{ mobilityBuffer.learning_agreement.name }} <i
                                            class="fa fa-fw fa-long-arrow-right"></i></span>
                                    <el-button-group>
                                        <el-tooltip class="item" effect="dark" content="Download" placement="top-start">
                                            <el-button type="primary" plain
                                                       @click="downloadDocument('learning_agreement')">
                                                <i class="fa fa-fw fa-download"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip class="item" effect="dark" content="Elimina" placement="top-start">
                                            <el-button type="danger" plain :disabled="!editMobility"
                                                       @click="deleteDocument('learning_agreement')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </el-button>
                                        </el-tooltip>
                                    </el-button-group>
                                </div>
                            </el-form-item>

                            <document-uploader
                                    :upload-url="documentUploadAction"
                                    document-type="learning_agreement"
                                    label="Carica learning agreement: "
                                    :mobility-buffer="mobilityBuffer"
                                    :disabled="!editMobility"/>

                            <br>
                            <el-form-item>
                                <el-button type="primary" v-if="!editMobility" @click="triggerEditMobility">
                                    Modifica
                                </el-button>
                                <el-button type="success" v-if="editMobility" @click="commitEditMobility">
                                    Salva
                                </el-button>
                                <el-button type="danger" v-if="editMobility" @click="undoEditMobility">
                                    Annulla
                                </el-button>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane>
                        <span slot="label">
                            <i class="fa fa-fw fa-exchange"></i> Transcript of Records
                        </span>
                        <el-form :inline="true">
                            <el-form-item label="CFU da esami (Transcript):">
                                <el-input-number
                                        v-model="mobilityBuffer.transcript_cfu_exams"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('transcript_cfu_exams')"/>
                            </el-form-item>
                            <el-form-item label="CFU da tesi (Transcript):">
                                <el-input-number
                                        v-model="mobilityBuffer.transcript_cfu_thesis"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('transcript_cfu_thesis')"/>
                            </el-form-item>
                            <el-form-item label="Estensione mobilità (giorni):">
                                <el-input-number
                                        v-model="mobilityBuffer.extension" style="width: 100px"
                                        :disabled="!editMobility" controls-position="right"
                                        @change="addModified('extension')"/>
                            </el-form-item>
                            <br>
                            <el-form-item label="Inizio effettivo mobilità:">
                                <el-date-picker
                                        v-model="mobilityBuffer.acknowledged_in"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        value-format="dd-MM-yyyy"
                                        placeholder="Inizio effettivo mobilità"
                                        @change="addModified('acknowledged_in')">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="Fine effettiva mobilità:">
                                <el-date-picker
                                        v-model="mobilityBuffer.acknowledged_out"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        value-format="dd-MM-yyyy"
                                        placeholder="Fine effettiva mobilità"
                                        @change="addModified('acknowledged_out')">
                                </el-date-picker>
                            </el-form-item>
                            <br>
                            <el-form-item label="Individual support / EU grant:">
                                <el-input-number
                                        v-model="mobilityBuffer.eu_grant" style="width: 100px"
                                        :disabled="!editMobility" controls-position="right"
                                        @change="addModified('eu_grant')"/>
                            </el-form-item>
                            <el-form-item label="Travel grant:">
                                <el-input-number
                                        v-model="mobilityBuffer.travel_grant" style="width: 100px"
                                        :disabled="!editMobility" controls-position="right"
                                        @change="addModified('travel_grant')"/>
                            </el-form-item>
                            <br>
                            <div v-if="Array.isArray(mobilityBuffer.other_funding)">
                                <div v-for="(funding, index) in mobilityBuffer.other_funding">
                                    <el-form-item label="Altri finanziamenti (EUR):">
                                        <el-input-number
                                                v-model="mobilityBuffer.other_funding[index].amount"
                                                style="width: 150px"
                                                :disabled="!editMobility" controls-position="right"
                                                @change="addModified('other_funding')"/>
                                    </el-form-item>
                                    <span> - </span>
                                    <el-form-item label=" ">
                                        <el-input v-model="mobilityBuffer.other_funding[index].description"
                                                  style="width: 300px"
                                                  :disabled="!editMobility" @change="addModified('other_funding')"
                                                  placeholder="Note su altri finanziamenti"/>
                                    </el-form-item>
                                    <el-button type="danger" :disabled="!editMobility" plain
                                               @click="removeFundingSource(index)"><i class="fa fa-fw fa-trash"></i>
                                    </el-button>
                                    <el-button type="primary" :disabled="!editMobility" plain @click="addFundingSource">
                                        <i class="fa fa-fw fa-plus"></i></el-button>
                                    <br>
                                </div>
                            </div>
                            <div v-else>
                                <el-form-item label="Altri finanziamenti:">
                                    <el-button type="primary" :disabled="!editMobility" plain @click="addFundingSource">
                                        <i class="fa fa-fw fa-plus"></i></el-button>
                                </el-form-item>
                            </div>

                            <el-form-item label="Transcript of records caricato: ">
                                <div v-if="mobilityBuffer.transcript === null">
                                    <i class="fa fa-fw fa-exclamation-triangle"></i>
                                    <span> Documento non caricato</span>
                                </div>
                                <div v-else>
                                    <i class="fa fa-fw fa-file-o"></i>
                                    <span> {{ mobilityBuffer.transcript.name }} <i
                                            class="fa fa-fw fa-long-arrow-right"></i></span>
                                    <el-button-group>
                                        <el-tooltip class="item" effect="dark" content="Download" placement="top-start">
                                            <el-button type="primary" plain
                                                       @click="downloadDocument('transcript')">
                                                <i class="fa fa-fw fa-download"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip class="item" effect="dark" content="Elimina" placement="top-start">
                                            <el-button type="danger" plain :disabled="!editMobility"
                                                       @click="deleteDocument('transcript')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </el-button>
                                        </el-tooltip>
                                    </el-button-group>
                                </div>
                            </el-form-item>
                            <document-uploader
                                    :upload-url="documentUploadAction"
                                    document-type="transcript"
                                    label="Carica transcript of records: "
                                    :mobility-buffer="mobilityBuffer"
                                    :disabled="!editMobility"/>
                            <br>
                            <el-form-item>
                                <el-button type="primary" v-if="!editMobility" @click="triggerEditMobility">
                                    Modifica
                                </el-button>
                                <el-button type="success" v-if="editMobility" @click="commitEditMobility">
                                    Salva
                                </el-button>
                                <el-button type="warning" v-if="editMobility" @click="undoEditMobility">
                                    Annulla
                                </el-button>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane>
                        <span slot="label">
                            <i class="fa fa-fw fa-check-square-o"></i> Modulo Riconoscimento Crediti
                        </span>
                        <el-form :inline="true">
                            <el-form-item label="CFU da esami riconosciuti:">
                                <el-input-number
                                        v-model="mobilityBuffer.acknowledged_cfu_exams"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('acknowledged_cfu_exams')"/>
                            </el-form-item>
                            <el-form-item label="CFU da tesi riconosciuti:">
                                <el-input-number
                                        v-model="mobilityBuffer.acknowledged_cfu_thesis"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('acknowledged_cfu_thesis')"/>
                            </el-form-item>
                            <el-form-item label="CFU sovrannumerari:">
                                <el-input-number
                                        v-model="mobilityBuffer.acknowledged_cfu_supernumerary"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('acknowledged_cfu_supernumerary')"/>
                            </el-form-item>
                            <br>
                            <el-form-item label="MRC caricato: ">
                                <div v-if="mobilityBuffer.mobility_acknowledgement === null">
                                    <i class="fa fa-fw fa-exclamation-triangle"></i>
                                    <span> Documento non caricato</span>
                                </div>
                                <div v-else>
                                    <i class="fa fa-fw fa-file-o"></i>
                                    <span> {{ mobilityBuffer.mobility_acknowledgement.name }} <i
                                            class="fa fa-fw fa-long-arrow-right"></i></span>
                                    <el-button-group>
                                        <el-tooltip class="item" effect="dark" content="Download" placement="top-start">
                                            <el-button type="primary" plain
                                                       @click="downloadDocument('mobility_acknowledgement')">
                                                <i class="fa fa-fw fa-download"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip class="item" effect="dark" content="Elimina" placement="top-start">
                                            <el-button type="danger" plain :disabled="!editMobility"
                                                       @click="deleteDocument('mobility_acknowledgement')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </el-button>
                                        </el-tooltip>
                                    </el-button-group>
                                </div>
                            </el-form-item>

                            <document-uploader
                                    :upload-url="documentUploadAction"
                                    document-type="mobility_acknowledgement"
                                    label="Carica modulo riconoscimento crediti: "
                                    :mobility-buffer="mobilityBuffer"
                                    :disabled="!editMobility"/>
                            <br>
                            <el-form-item>
                                <el-button type="primary" v-if="!editMobility" @click="triggerEditMobility">
                                    Modifica
                                </el-button>
                                <el-button type="success" v-if="editMobility" @click="commitEditMobility">
                                    Salva
                                </el-button>
                                <el-button type="warning" v-if="editMobility" @click="undoEditMobility">
                                    Annulla
                                </el-button>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>

        <el-row style="margin-bottom: 20px">
            <el-col :span="24">
                <el-steps :active="mobilityStatusActiveTab" finish-status="success"
                          align-center>
                    <el-step v-for="mob in mobilityStatuses" title=""
                             :description="mob.name" :key="mob.id"/>
                </el-steps>
            </el-col>
        </el-row>

        <el-row type="flex" justify="center" style="margin-bottom: 20px">
            <el-col :span="4">
                <el-button type="danger" @click="abortMobility">Chiudi mobilità</el-button>
            </el-col>
            <el-col :span="4">
                <el-button type="primary" @click="mobilityNextStep">Avanti</el-button>
            </el-col>
        </el-row>

        <attachment-manager :mobility-id="mobility.id" :attachments="attachments"
                            :upload-action="attachmentUploadAction" :retrieve-action="attachmentRetrieveAction"
                            :delete-action="attachmentDeleteAction"/>
    </div>
</template>

<script>
    import AttachmentManager from "./AttachmentManager";
    import DocumentUploader from "./DocumentUploader";

    export default {
        components: {
            DocumentUploader,
            AttachmentManager
        },
        name: 'mobility-tracker',
        props: {
            mobility: Object,
            attachments: Array,
            semesters: Array,
            mobilityStatuses: Array,
            universityBranches: Array,
            abortAction: {type: String, required: true},
            editStatusAction: {type: String, required: true},
            editAction: {type: String, required: true},
            documentUploadAction: {type: String, required: true},
            documentRetrieveAction: {type: String, required: true},
            documentDeleteAction: {type: String, required: true},
            attachmentUploadAction: {type: String, required: true},
            attachmentRetrieveAction: {type: String, required: true},
            attachmentDeleteAction: {type: String, required: true}
        },
        data: function () {
            return {
                editMobility: false,
                mobilityBuffer: this.mobility,
                tempMobilityBuffer: {},
                modifiedKeys: []
            }
        },
        computed: {
            universityBranchStyle: function () {
                let id = this.mobility.university_branch_id,
                    branch = this.universityBranches.find(un => {
                        return un.id === id
                    });
                return {
                    'width': 20 + 8 * branch.name.length + 'px'
                }
            },
            semesterStyle: function () {
                return {
                    // FIXME seems not to have any effect
                    'width': '50 px'
                }
            },
            mobilityStatusActiveTab: function () {
                return this.mobility.mobility_status_id - 1;
            }
        },
        methods: {
            downloadDocument(documentType) {
                axios.post(this.documentRetrieveAction, {
                    id: this.mobilityBuffer[documentType].id,
                    document_type: documentType
                })
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        window.open(response.data.url);
                    })
                    .catch(error => {
                        this.$message.error(error.response.data)
                    });
            },
            deleteDocument(documentType) {
                axios.delete(this.documentDeleteAction + '/' + documentType + '/' + this.mobilityBuffer[documentType].id)
                    .then(response => {
                        this.mobilityBuffer[documentType] = null;
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                    })
                    .catch(error => {
                        this.$message.error(error.response.data)
                    });
            },
            addFundingSource() {
                if (!Array.isArray(this.mobilityBuffer.other_funding))
                    this.mobilityBuffer.other_funding = [];
                this.mobilityBuffer.other_funding.push({amount: 0, description: ''});
            },
            removeFundingSource(index) {
                this.addModified('other_funding');
                this.mobilityBuffer.other_funding.splice(index, 1);
                if (this.mobilityBuffer.other_funding.length === 0)
                    this.mobilityBuffer.other_funding = null;
            },
            triggerEditMobility() {
                this.tempMobilityBuffer = Object.assign({}, this.mobilityBuffer);
                this.editMobility = true;
            },
            addModified(key) {
                this.modifiedKeys.push(key);
                this.modifiedKeys = this.modifiedKeys.filter((value, index, self) => {
                    return self.indexOf(value) === index;
                });
            },
            commitEditMobility() {
                if (this.modifiedKeys.length > 0) {
                    this.$confirm('Applicare i cambiamenti?', 'Info', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annulla',
                        type: 'info'
                    }).then(() => {
                        let modifiedMobility = {};
                        this.modifiedKeys.forEach(k => {
                            modifiedMobility[k] = this.mobilityBuffer[k]
                        });
                        modifiedMobility.id = this.mobilityBuffer.id;
                        axios.put(this.editAction, modifiedMobility)
                            .then(response => {
                                this.$message({
                                    type: response.data.status,
                                    message: response.data.message
                                });
                                this.tempMobilityBuffer = {};
                                this.modifiedKeys = [];
                                this.editMobility = false;
                            })
                            .catch(error => {
                                this.$message.error(error.response.data.message);
                            });
                    }).catch(() => {
                    });
                } else {
                    this.tempMobilityBuffer = {};
                    this.editMobility = false;
                }
            },
            undoEditMobility() {
                if (this.modifiedKeys.length > 0) {
                    this.$confirm('I cambiamenti effettuati verranno persi, continuare?', 'Attenzione', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annulla',
                        type: 'warning'
                    }).then(() => {
                        Object.keys(this.tempMobilityBuffer)
                            .forEach(k => this.mobilityBuffer[k] = this.tempMobilityBuffer[k]);
                        this.tempMobilityBuffer = {};
                        this.modifiedKeys = [];
                        this.editMobility = false;
                    }).catch(() => {
                    });
                } else {
                    this.tempMobilityBuffer = {};
                    this.editMobility = false;
                }
            },
            mobilityNextStep() {
                this.$confirm('Portare la mobilità al prossimo stato?', 'Info', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'info'
                }).then(() => {
                    axios.put(this.editStatusAction, {
                        id: this.mobility.id,
                        new_status_id: this.mobility.mobility_status_id + 1
                    })
                        .then(response => {
                            this.mobilityBuffer.mobility_status_id++;
                            this.$message({
                                type: response.data.status,
                                message: response.data.message
                            });
                        })
                        .catch(error => {
                            this.$message.error(error.response.data.message);
                        });
                }).catch(() => {
                });
            },
            navigateToTab(navigateFunction, index) {
                // TODO direct navigation between statuses not implemented
            },
            abortMobility() {
                this.$prompt('Chiudere anticipatamente la mobilità?', 'Attenzione', {
                    confirmButtonText: 'Chiudi mobilità',
                    cancelButtonText: 'Annulla',
                    inputPlaceholder: 'Messaggio di chiusura'
                }).then(msg => {
                    axios.put(this.abortAction, {id: this.mobilityBuffer.id, message: msg.value})
                        .then(response => {
                            this.$message({type: response.data.status, message: response.data.message});
                            setTimeout(function () {
                                window.location = response.data.redirect;
                            }, 1000)
                        })
                        .catch(error => {
                            this.$message.error(error.response.data.message);
                        });
                }).catch(() => {
                });
            }
        }
    }
</script>

<style scoped>

</style>