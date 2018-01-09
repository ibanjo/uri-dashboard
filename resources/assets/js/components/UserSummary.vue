<template>
    <el-collapse v-model="active_tab" accordion>
        <el-collapse-item title="Dati anagrafici" name="registry">
            <dl>
                <dt>Nome</dt>
                <dd>{{ user.name }}</dd>
                <dt>Secondo nome</dt>
                <dd>{{ user.middle_name }}</dd>
                <dt>Cognome</dt>
                <dd>{{ user.surname }}</dd>
                <dt>Codice fiscale</dt>
                <dd>{{ user.fiscal_code }}</dd>
                <dt>Email</dt>
                <dd>{{ user.email }}</dd>
                <dt>Telefono</dt>
                <dd>{{ user.telephone }}</dd>
            </dl>
        </el-collapse-item>

        <el-collapse-item title="Dati accademici" name="academic">
            <dt>Ruolo</dt>
            <dd>{{ user.role.description }}</dd>
            <dt>Dipartimento</dt>
            <dd>{{ user.department.name }}</dd>
            <!-- TODO handle multiple register numbers -->
            <dt>Numero di matricola</dt>
            <dd v-for="reg in user.registers">{{ reg.number }}</dd>
            <dt>Tipo corso di laurea</dt>
            <dd>{{ user.degree_course.degree_course_type.name_ita }}</dd>
            <dt>Corso di laurea</dt>
            <dd>{{ user.degree_course.name_ita }}</dd>
        </el-collapse-item>

        <el-collapse-item title="Conti bancari registrati" name="bank">
            <p v-if="user.bank_accounts.length === 0">Nessun conto associato all'utente</p>
            <ul v-else>
                <li v-for="acc in user.bank_accounts">{{ acc.bank_name }}</li>
            </ul>
        </el-collapse-item>
    </el-collapse>
</template>

<script>
    export default {
        name: 'user-summary',
        data: function () {
            return {
                active_tab: 'registry'
            }
        },
        props: ['user']
    }
</script>

<style scoped>

</style>