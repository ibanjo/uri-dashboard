<template>
    <el-form-item :label="label">
        <el-checkbox v-if="!deletable" v-model="disabled" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        <el-switch :active-text="activeText" :inactive-text="inactiveText"
                   v-model="value" :disabled="disabled"/>
        <el-button type="primary" plain v-if="deletable" @click="deleteMe"><i class="fa fa-fw fa-trash"></i></el-button>
    </el-form-item>
</template>

<script>
    export default {
        name: 'boolean-filter',
        props: {
            label: {type: String, default: 'Boolean filter'},
            activeText: {type: String, default: 'True'},
            inactiveText: {type: String, default: 'False'},
            deletable: {type: Boolean, default: false},
            name: {type: String, required: true},
            queryScope: {type: Boolean, required: true}
        },
        data: function() {
            return {
                value: false,
                disabled: false
            }
        },
        methods: {
            deleteMe: function () {
                this.$emit('deleted');
            }
        }
    }
</script>

<style scoped>

</style>