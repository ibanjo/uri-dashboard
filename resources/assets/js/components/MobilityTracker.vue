<template>
    <div>
        <el-row style="margin-bottom: 20px">
            <el-col :span="24">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>Informazioni generali</span>
                    </div>
                    <div class="text item">
                        <el-form :inline="true">
                            <!-- FIXME only one mobility can be active at a time -->
                            <el-form-item label="Sede estera:">
                                <el-select v-model="mobility.university_branch_id"
                                           placeholder="Sede estera" :disabled="!editMobility"
                                           :style="universityBranchStyle" filterable>
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
                                        v-model="mobility.estimated_cfu_exams"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"></el-input-number>
                            </el-form-item>
                            <el-form-item label="CFU previsti da tesi:">
                                <el-input-number
                                        v-model="mobility.estimated_cfu_thesis"
                                        :disabled="!editMobility" controls-position="right"
                                        :min="0" style="width: 100px"></el-input-number>
                            </el-form-item>
                            <br>
                            <el-form-item label="Semestre:">
                                <el-select v-model="mobility.semester_id"
                                           placeholder="Semestre" :disabled="!editMobility"
                                           :style="semesterStyle">
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
                                        v-model="mobility.estimated_in"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        placeholder="Inizio contratto">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="Fine contratto:">
                                <el-date-picker
                                        v-model="mobility.estimated_out"
                                        type="date" :disabled="!editMobility"
                                        format="dd-MM-yyyy"
                                        placeholder="Fine contratto">
                                </el-date-picker>
                            </el-form-item>

                            <el-button type="primary" @click="triggerEditMobility">
                                Modifica
                            </el-button>
                            <el-button type="success" @click="">
                                Salva
                            </el-button>
                            <el-button type="warning" @click="">
                                Ripristina
                            </el-button>
                        </el-form>
                    </div>
                </el-card>
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
                mobilityTemp: {}
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
            triggerEditMobility() {
                if (!this.editMobility) {
                    this.mobilityTemp = Object.assign({}, this.mobility);
                    this.editMobility = true;
                } else {
                    this.$confirm('I cambiamenti effettuati verranno persi, continuare?', 'Attenzione', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annulla',
                        type: 'warning'
                    }).then(() => {
                        // FIXME this directly mutates the mobility prop, and should be avoided
                        this.mobility = Object.assign({}, this.mobilityTemp);
                        this.editMobility = false;
                    }).catch(() => {
                    })
                }
            },
            mobilityNextStep() {
                this.$confirm('Portare la mobilità al prossimo stato?', 'Info', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'info'
                }).then(() => {
                    axios.put('/edit/mobility', {
                        id: this.mobility.id,
                        new_status_id: this.mobility.mobility_status_id + 1
                    })
                        .then((response) => {
                            this.mobility.mobility_status_id++;
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