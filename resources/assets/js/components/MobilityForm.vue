<template>
    <el-form :inline="inline" :model="mobility" :rules="rules.mobility" label-width="200px">
        <el-form-item label="Sede estera">
            <el-select v-model="mobility.university_branch_id" filterable
                       placeholder="Sede estera">
                <el-option
                        v-for="branch in universityBranches"
                        :key="branch.id"
                        :label="branch.name"
                        :value="branch.id">
                </el-option>
            </el-select>
        </el-form-item>

        <el-form-item label="CFU previsti da esami">
            <el-input-number v-model="mobility.estimated_cfu_exams"
                             controls-position="right" :min="0"></el-input-number>
        </el-form-item>

        <el-form-item label="CFU previsti da tesi">
            <el-input-number v-model="mobility.estimated_cfu_thesis"
                             controls-position="right" :min="0"></el-input-number>
        </el-form-item>

        <el-form-item label="Semestre">
            <el-select v-model="mobility.semester_id" placeholder="Semestre">
                <el-option
                        v-for="semester in semesters"
                        :key="semester.id"
                        :label="semester.name_ita"
                        :value="semester.id">
                </el-option>
            </el-select>
        </el-form-item>

        <el-form-item label="Inizio contratto">
            <el-date-picker
                    v-model="mobility.estimated_in"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Inizio contratto">
            </el-date-picker>
        </el-form-item>

        <el-form-item label="Fine contratto">
            <el-date-picker
                    v-model="mobility.estimated_out"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Fine contratto">
            </el-date-picker>
        </el-form-item>

        <el-form-item label="Anno accademico" prop="academic_year">
            <el-input
                    v-model="mobility.academic_year"
                    placeholder="Formato: 2015/16">
            </el-input>
        </el-form-item>

        <el-form-item label="Idoneo/Assegnatario">
            <el-switch
                    style="display: block"
                    v-model="mobility.granted"
                    active-color="#13ce66"
                    inactive-color="#ff4949"
                    active-text="Assegnatario"
                    inactive-text="Idoneo">
            </el-switch>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="onSubmit">Crea mobilità</el-button>
            <el-button @click="onCancel">Annulla</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name: 'mobility-form',
        props: {
            inline: {type: Boolean, default: false},
            labelWidth: {type: String, default: '200px'},
            action: {type: String, required: true},
            userId: {type: Number, required: true},
            countries: {type: Array, required: true},
            semesters: {type: Array, required: true},
            universityBranches: {type: Array, required: true}
        },
        data: function () {
            return {
                mobility: {
                    university_branch_id: '',
                    semester_id: 1,
                    estimated_in: '',
                    estimated_out: '',
                    estimated_cfu_exams: 0,
                    estimated_cfu_thesis: 0,
                    academic_year: '',
                    granted: false
                },
                rules: {
                    mobility: {
                        academic_year: [
                            {required: true, message: 'L\'anno accademico è richiesto', trigger: 'blur'},
                            {
                                validator: (rule, value, callback) => {
                                    if (!/\d{4}\/\d{2}$/.test(value)) {
                                        callback(new Error('Formato: AAAA/AA'))
                                    } else
                                        callback();
                                },
                                trigger: 'blur'
                            }
                        ]
                    }
                }
            }
        },
        computed: {
            // TODO implement automated expected days calculation
        },
        methods: {
            onSubmit: function () {
                axios.post(this.action, Object.assign({}, this.mobility, {user_id: this.userId}))
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        this.$emit('mobility-created', response.data);
                    })
                    .catch(error => {
                        this.$message({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
            },
            onCancel: function () {
                this.$emit('canceled');
            }
        }
    }
</script>

<style scoped>

</style>