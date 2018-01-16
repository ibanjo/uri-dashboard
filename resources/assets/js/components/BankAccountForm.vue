<template>
    <el-form :model="bank" label-position="left" :label-width="labelWidth" :rules="rules"
             ref="bankAccountForm" :inline="inline">
        <el-form-item label="Banca" prop="bank_name">
            <el-input v-model="bank.bank_name" placeholder="Nome istituto bancario"></el-input>
        </el-form-item>

        <el-form-item label="IBAN" prop="iban">
            <el-input v-model="bank.iban" placeholder="IBAN completo"></el-input>
        </el-form-item>

        <el-form-item>
            <el-checkbox v-model="bank.user_is_holder">L'utente coincide con l'intestatario
            </el-checkbox>
        </el-form-item>

        <el-form-item label="Nome">
            <el-row>
                <el-col :span="12">
                    <el-input :disabled="bank.user_is_holder" v-model="bank.holder_name"
                              placeholder="Nome dell'intestatario"></el-input>
                </el-col>
                <el-col :span="12">
                    <el-input :disabled="bank.user_is_holder" v-model="bank.holder_middle_name"
                              placeholder="Secondo nome dell'intestatario"></el-input>
                </el-col>
            </el-row>
        </el-form-item>
        <el-form-item label="Cognome">
            <el-input :disabled="bank.user_is_holder" v-model="bank.holder_surname"
                      placeholder="Cognome dell'intestatario"></el-input>
        </el-form-item>

        <el-form-item>
            <el-checkbox v-model="bank.set_primary">Imposta come conto principale</el-checkbox>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="onSubmit">Crea conto</el-button>
            <el-button @click="onCancel">Annulla</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name: 'bank-account-form',
        props: {
            inline: {type: Boolean, default: false},
            userId: {type: Number, required: true},
            labelWidth: {type: String, default: '200px'},
            action: {type: String, required: true}
        },
        data: function () {
            return {
                bank: {
                    bank_name: '',
                    iban: '',
                    holder_name: '',
                    holder_middle_name: '',
                    holder_surname: '',
                    user_is_holder: true,
                    set_primary: true
                },
                rules: {
                    bank_name: [
                        {required: true, message: 'Inserisci il nome della banca', trigger: 'blur'}
                    ],
                    iban: [
                        {
                            validator: (rule, value, callback) => {
                                if (!IBAN.isValid(value)) {
                                    callback(new Error('Il codice IBAN inserito non è valido'));
                                } else {
                                    callback();
                                }
                            },
                            trigger: 'blur'
                        },
                        {required: true, message: 'Il codice IBAN è richiesto', trigger: 'blur'}
                    ]
                },
            }
        },
        methods: {
            onSubmit: function () {
                axios.post(this.action, Object.assign({}, this.bank, {user_id: this.userId}))
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        this.$emit('bank-account-created', {
                            bank_account: response.data.bank_account,
                            set_primary: this.bank.set_primary
                        });
                        this.$refs.bankAccountForm.resetFields();
                    })
                    .catch(error => {
                        this.$message.error(error.response.data.message);
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