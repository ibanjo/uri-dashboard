<template>
    <el-form :inline="inline" :rules="rules" :model="universityBranch" :label-width="labelWidth"
             ref="universityBranchForm">
        <el-form-item prop="name" label="Nome: ">
            <el-input v-model="universityBranch.name" @change="addModified('name')"/>
        </el-form-item>
        <el-form-item prop="name_eng" label="Nome internazionale: ">
            <el-input v-model="universityBranch.name_eng" @change="addModified('name_eng')"/>
        </el-form-item>
        <el-form-item prop="country_id" label="Paese: ">
            <el-select v-model="universityBranch.country_id" filterable
                       placeholder="Paese" @change="addModified('country_id')">
                <el-option
                        v-for="country in countries"
                        :key="country.id"
                        :label="country.name_ita"
                        :value="country.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item prop="erasmus_code" label="Codice Erasmus: ">
            <el-input v-model="universityBranch.erasmus_code" @change="addModified('erasmus_code')"/>
        </el-form-item>
        <el-form-item prop="max_outgoing" label="Posti disponibili: ">
            <el-input-number v-model="universityBranch.max_outgoing" controls-position="right" :min="0"
                             @change="addModified('max_outgoing')"/>
        </el-form-item>
        <el-form-item label="Livelli accettati: ">
            <el-select v-model="universityBranch.iad_levels" multiple @change="addModified('iad_levels')">
                <el-option
                        v-for="type in degreeCourseTypes"
                        :key="type.id"
                        :label="type.name_ita"
                        :value="type.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="Scadenza (semestre 1): ">
            <el-date-picker
                    @change="addModified('first_semester_deadline')"
                    v-model="universityBranch.first_semester_deadline"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Deadline primo semestre">
            </el-date-picker>
        </el-form-item>
        <el-form-item label="Scadenza (semestre 2): ">
            <el-date-picker
                    @change="addModified('second_semester_deadline')"
                    v-model="universityBranch.second_semester_deadline"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Deadline secondo semestre">
            </el-date-picker>
        </el-form-item>
        <el-form-item prop="expiration_date" label="Scadenza agreement: ">
            <el-date-picker
                    @change="addModified('expiration_date')"
                    v-model="universityBranch.expiration_date"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Scadenza agreement">
            </el-date-picker>
        </el-form-item>
        <el-form-item label="Livello lingua: ">
            <el-input v-model="universityBranch.language_level" placeholder="Certificazione linguistica richiesta"
                      @change="addModified('language_level')"/>
        </el-form-item>
        <el-form-item>
            <el-button-group>
                <el-button type="primary" icon="el-icon-check" @click="submit">Salva</el-button>
                <el-button type="primary" icon="el-icon-refresh" @click="clean">Pulisci</el-button>
            </el-button-group>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name: 'university-branch-form',
        props: {
            inline: {type: Boolean, default: false},
            labelWidth: {type: String, default: '200px'},
            countries: {type: Array, required: true},
            degreeCourseTypes: {type: Array, required: true},
            postAction: {type: String, required: true},
            editAction: {type: String, required: true},
            originalData: {type: Object},
            mode: {type: String, default: 'create'}
        },
        data: function () {
            return {
                emptyUniversityBranch: {
                    name: '',
                    name_eng: '',
                    country_id: 1,
                    erasmus_code: '',
                    max_outgoing: 0,
                    expiration_date: '',
                    first_semester_deadline: '',
                    second_semester_deadline: '',
                    language_level: '',
                    iad_levels: [],
                    // TODO add contact_person_id
                },
                universityBranch: {},
                modifiedKeys: [],
                rules: {
                    name: [
                        {required: true, message: 'Inserire il nome della sede', trigger: 'blur'}
                    ],
                    expiration_date: [
                        {required: true, message: 'Inserire la data di scadenza dell\'agreement', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submit: function () {
                if (this.mode === 'create')
                    this.saveNewBranch();
                else if (this.mode === 'edit')
                    this.saveExistingBranch()
            },
            saveNewBranch: function () {
                axios.post(this.postAction, Object.assign({}, this.universityBranch))
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        this.$emit('university-branch-added', response.data.university_branch);
                        this.clean();
                    })
                    .catch(error => {
                        this.$message({
                            type: error.response.data.status,
                            message: error.response.data.message
                        });
                    });
            },
            saveExistingBranch: function () {
                let modifiedBranch = {};
                this.modifiedKeys.forEach(k => {
                    modifiedBranch[k] = this.universityBranch[k]
                });
                modifiedBranch.id = this.universityBranch.id;
                axios.put(this.editAction, modifiedBranch)
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        this.$emit('university-branch-edited', {
                            university_branch: response.data.university_branch,
                            modifiedKeys: this.modifiedKeys});
                        this.modifiedKeys = [];
                        this.clean();
                    })
                    .catch(error => {
                        this.$message.error(error.response.data.message);
                    });
            },
            switchMode: function (mode) {
                if (mode === 'edit')
                    this.universityBranch = Object.assign({}, this.originalData);
                else
                    this.universityBranch = Object.assign({}, this.emptyUniversityBranch);
            },
            addModified(key) {
                this.modifiedKeys.push(key);
                this.modifiedKeys = this.modifiedKeys.filter((value, index, self) => {
                    return self.indexOf(value) === index;
                });
            },
            clean: function () {
                this.$refs.universityBranchForm.resetFields();
            }
        },
        watch: {
            mode: function (newMode) {
                this.switchMode(newMode);
            }
        },
        mounted: function () {
            this.switchMode(this.mode);
        }
    }
</script>

<style scoped>

</style>