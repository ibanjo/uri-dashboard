<template>
    <el-form :inline="inline" :rules="rules" :model="universityBranch" :label-width="labelWidth" ref="universityBranchForm">
        <el-form-item prop="name" label="Nome originale: ">
            <el-input v-model="universityBranch.name"/>
        </el-form-item>
        <el-form-item prop="name_eng" label="Nome internazionale: ">
            <el-input v-model="universityBranch.name_eng"/>
        </el-form-item>
        <el-form-item prop="country_id" label="Paese: ">
            <el-select v-model="universityBranch.country_id" filterable
                       placeholder="Paese">
                <el-option
                        v-for="country in countries"
                        :key="country.id"
                        :label="country.name_ita"
                        :value="country.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item prop="erasmus_code" label="Travel grant: ">
            <el-input v-model="universityBranch.erasmus_code"/>
        </el-form-item>
        <el-form-item prop="max_outgoing" label="Posti disponibili: ">
            <el-input-number v-model="universityBranch.max_outgoing" controls-position="right" :min="0"/>
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
            action: {type: String, required: true}
        },
        data: function () {
            return {
                universityBranch: {
                    name: '',
                    name_eng: '',
                    country_id: 1,
                    erasmus_code: '',
                    max_outgoing: 0
                },
                rules: {
                    name: [
                        {required: true, message: 'Inserire il nome originale della sede', trigger: 'blur'}
                    ],
                    name_eng: [
                        {required: true, message: 'Inserire il nome in inglese della sede', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submit: function () {
                axios.post(this.action, Object.assign({}, this.universityBranch))
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
            clean: function () {
                this.$refs.universityBranchForm.resetFields();
            }
        }
    }
</script>

<style scoped>

</style>