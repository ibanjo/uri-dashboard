<template>
    <div>
        <div style="margin-bottom: 1em">
            <el-button v-if="!edit" type="primary" @click="triggerEditUser">Modifica</el-button>
            <el-button v-if="edit" type="success" @click="commitEditUser">Salva</el-button>
            <el-button v-if="edit" type="danger" @click="undoEditUser">Annulla</el-button>
        </div>
        <!-- TODO implement validation -->
        <el-form :inline="true">
            <el-collapse v-model="active_tab" :accordion="accordion">
                <el-collapse-item name="registry">
                    <template slot="title">
                        <p><i class="fa fa-fw fa-user"></i> Dati anagrafici</p>
                    </template>

                    <el-form-item label="Nome">
                        <el-input v-if="edit" v-model="user.name" @change="addModified('name')"></el-input>
                        <span v-else>{{ user.name }}</span>
                    </el-form-item>
                    <el-form-item label="Secondo nome">
                        <el-input v-if="edit" v-model="user.middle_name" @change="addModified('middle_name')"></el-input>
                        <span v-else>{{ user.middle_name }}</span>
                    </el-form-item>
                    <el-form-item label="Cognome">
                        <el-input v-if="edit" v-model="user.surname" @change="addModified('surname')"></el-input>
                        <span v-else>{{ user.surname }}</span>
                    </el-form-item>
                    <el-form-item label="Codice fiscale">
                        <el-input v-if="edit" v-model="user.fiscal_code" @change="addModified('fiscal_code')"></el-input>
                        <span v-else>{{ user.fiscal_code }}</span>
                    </el-form-item>
                    <el-form-item label="Email">
                        <el-input v-if="edit" v-model="user.email" @change="addModified('email')"></el-input>
                        <span v-else>{{ user.email }}</span>
                    </el-form-item>
                    <el-form-item label="Telefono">
                        <el-input v-if="edit" v-model="user.telephone" @change="addModified('telephone')"></el-input>
                        <span v-else>{{ user.telephone }}</span>
                    </el-form-item>
                </el-collapse-item>

                <el-collapse-item title="Dati accademici" name="academic">
                    <template slot="title">
                        <p><i class="fa fa-fw fa-graduation-cap"></i> Dati accademici</p>
                    </template>
                    <!-- TODO add role, department and degree course dropdowns -->
                    <el-form-item label="Ruolo">
                        <span>{{ user.role.id === 6 ? user.candidate_role.description : user.role.description }}</span>
                    </el-form-item>
                    <el-form-item label="Dipartimento">
                        <span>{{ user.department.name }}</span>
                    </el-form-item>
                    <!-- TODO handle multiple register numbers -->
                    <el-form-item label="Numero di matricola">
                        <ul style="list-style: none">
                            <li v-for="reg in user.registers">{{ reg.number }}</li>
                        </ul>
                    </el-form-item>
                    <el-form-item label="Tipo corso di laurea">
                        <span>{{ user.degree_course.degree_course_type.name_ita }}</span>
                    </el-form-item>
                    <el-form-item label="Corso di laurea">
                        <span>{{ user.degree_course.name_ita }}</span>
                    </el-form-item>
                </el-collapse-item>

                <el-collapse-item title="Conti bancari" name="bank">
                    <template slot="title">
                        <p><i class="fa fa-fw fa-bank"></i> Conti bancari</p>
                    </template>
                    <p v-if="user.bank_accounts.length === 0">Nessun conto associato all'utente</p>
                    <ul v-else>
                        <li v-for="acc in user.bank_accounts">{{ acc.bank_name }}</li>
                    </ul>
                </el-collapse-item>
            </el-collapse>
        </el-form>
    </div>
</template>

<script>
    export default {
        name: 'user-summary',
        data: function () {
            return {
                active_tab: this.defaultTab,
                edit: false,
                modifiedKeys: [],
                tempUserBuffer: {}
            }
        },
        props: {
            user: {type: Object, required: true},
            editAction: {type: String, required: true},
            accordion: {type: Boolean, default: false},
            defaultTab: {type: String, default: ''}
        },
        methods: {
            triggerEditUser: function () {
                this.edit = true;
                this.tempUserBuffer = Object.assign({}, this.user);
            },
            commitEditUser: function () {
                if (this.modifiedKeys.length > 0) {
                    this.$confirm('Applicare i cambiamenti?', 'Info', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annulla',
                        type: 'info'
                    }).then(() => {
                        let modifiedUser = {};
                        this.modifiedKeys.forEach(k => {
                            modifiedUser[k] = this.tempUserBuffer[k]
                        });
                        modifiedUser.id = this.tempUserBuffer.id;
                        axios.put(this.editAction, modifiedUser)
                            .then(response => {
                                this.$message({
                                    type: response.data.status,
                                    message: response.data.message
                                });
                                this.tempUserBuffer = {};
                                this.modifiedKeys = [];
                                this.edit = false;
                            })
                            .catch(error => {
                                this.$message.error(error.response.data.message);
                            });
                    }).catch(() => {
                    });
                } else {
                    this.tempUserBuffer = {};
                    this.edit = false;
                }
            },
            undoEditUser: function () {
                if (this.modifiedKeys.length > 0) {
                    this.$confirm('I cambiamenti effettuati verranno persi, continuare?', 'Attenzione', {
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Annulla',
                        type: 'warning'
                    }).then(() => {
                        Object.keys(this.tempUserBuffer)
                            .forEach(k => this.user[k] = this.tempUserBuffer[k]);
                        this.tempUserBuffer = {};
                        this.modifiedKeys = [];
                        this.edit = false;
                    }).catch(() => {
                    });
                } else {
                    this.tempUserBuffer = {};
                    this.edit = false;
                }
            },
            addModified(key) {
                this.modifiedKeys.push(key);
                this.modifiedKeys = this.modifiedKeys.filter((value, index, self) => {
                    return self.indexOf(value) === index;
                });
            }
        }
    }
</script>

<style scoped>

</style>