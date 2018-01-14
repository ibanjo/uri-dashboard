<template>
    <el-form :inline="inline" :rules="rules" :model="country" :label-width="labelWidth" ref="countryForm">
        <el-form-item prop="name_ita" label="Nome (ITA): ">
            <el-input v-model="country.name_ita"/>
        </el-form-item>
        <el-form-item prop="name_eng" label="Nome (ENG): ">
            <el-input v-model="country.name_eng"/>
        </el-form-item>
        <el-form-item prop="monthly_grant" label="Monthly grant: ">
            <el-input-number v-model="country.monthly_grant" controls-position="right" :min="0"/>
        </el-form-item>
        <el-form-item prop="travel_grant" label="Travel grant: ">
            <el-input-number v-model="country.travel_grant" controls-position="right" :min="0"/>
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
        name: 'country-form',
        props: {
            inline: {type: Boolean, default: false},
            labelWidth: {type: String, default: '200px'},
            action: {type: String, required: true}
        },
        data: function () {
            return {
                country: {
                    name_ita: '',
                    name_eng: '',
                    monthly_grant: 0,
                    travel_grant: 0
                },
                rules: {
                    name_ita: [
                        {required: true, message: 'Inserire il nome italiano del Paese', trigger: 'blur'}
                    ],
                    name_eng: [
                        {required: true, message: 'Inserire il nome inglese del Paese', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submit: function () {
                axios.post(this.action, Object.assign({}, this.country))
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        this.$emit('country-added', response.data.country);
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
                this.$refs.countryForm.resetFields();
            }
        }
    }
</script>

<style scoped>

</style>