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
                                        @change="addModified('estimated_cfu_exams')"></el-input-number>
                            </el-form-item>
                            <el-form-item label="CFU previsti da tesi:">
                                <el-input-number
                                        v-model="mobilityBuffer.estimated_cfu_thesis"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"
                                        @change="addModified('estimated_cfu_thesis')"></el-input-number>
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
                                        placeholder="Inizio contratto"
                                        @change="addModified('estimated_in')">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="Fine contratto:">
                                <el-date-picker
                                        v-model="mobilityBuffer.estimated_out"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        placeholder="Fine contratto"
                                        @change="addModified('estimated_out')">
                                </el-date-picker>
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
                            <i class="fa fa-fw fa-exchange"></i> Transcript of Records
                        </span>
                        TOR
                    </el-tab-pane>
                    <el-tab-pane>
                        <span slot="label">
                            <i class="fa fa-fw fa-check-square-o"></i> Modulo Riconoscimento Crediti
                        </span>
                        Role
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>

        <el-row style="margin-bottom: 20px">
            <el-col :span="24">
                <el-steps :active="mobilityStatusActiveTab" finish-status="success"
                          align-center>
                    <el-step v-for="mob in mobilityStatuses" title=""
                             :description="mob.name" :key="mob.id"></el-step>
                </el-steps>
            </el-col>
        </el-row>

        <el-row type="flex" justify="space-around" style="margin-bottom: 20px">
            <el-col :span="1">
                <el-button @click="mobilityNextStep">Avanti</el-button>
            </el-col>
        </el-row>

        <attachment-manager :mobility-id="mobility.id" :attachments="attachments"></attachment-manager>
    </div>
</template>

<script>
    import AttachmentManager from "./AttachmentManager";

    export default {
        components: {AttachmentManager},
        name: 'mobility-tracker',
        props: {
            mobility: Object,
            attachments: Array,
            semesters: Array,
            mobilityStatuses: Array,
            universityBranches: Array
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
            getLearningAgreementSubset(mobility) {
                return Object.assign({},
                    (({university_branch_id, estimated_cfu_exams, estimated_cfu_thesis, semester_id, estimated_in, estimated_out, granted}) => ({
                        university_branch_id,
                        estimated_cfu_exams,
                        estimated_cfu_thesis,
                        semester_id,
                        estimated_in,
                        estimated_out,
                        granted
                    }))(mobility));
            },
            triggerEditMobility() {
                this.tempMobilityBuffer = this.getLearningAgreementSubset(this.mobilityBuffer);
                this.editMobility = true;
            },
            addModified(key) {
                this.modifiedKeys.push(key);
                this.modifiedKeys = this.modifiedKeys.filter((value, index, self) => {
                    return self.indexOf(value) === index;
                });
            },
            commitEditMobility() {
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
                    axios.put('/edit/mobility', modifiedMobility)
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
                            this.$message({
                                type: error.response.data.status,
                                message: error.response.data.message
                            });
                        });
                }).catch(() => {
                });
            },
            undoEditMobility() {
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
            },
            mobilityNextStep() {
                this.$confirm('Portare la mobilità al prossimo stato?', 'Info', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'info'
                }).then(() => {
                    axios.put('/edit/mobility/status', {
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
                            this.$message({
                                type: error.response.data.status,
                                message: error.response.data.message
                            });
                        });
                }).catch(() => {
                });
            },
            navigateToTab(navigateFunction, index) {
                // TODO direct navigation between statuses not implemented
            }
        }
    }
</script>

<style scoped>

</style>