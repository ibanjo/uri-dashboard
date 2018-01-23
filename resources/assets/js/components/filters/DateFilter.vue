<template>
    <el-form-item :label="label">
        <el-checkbox v-if="!deletable" v-model="disable_min" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        <el-date-picker
                v-model="date_min"
                type="date" :disabled="disable_min"
                :format="dateFormat"
                :value-format="valueFormat"
                :placeholder="placeholder"/>
        <i class="fa fa-fw fa-arrows-h"></i>
        <el-date-picker
                v-model="date_max"
                type="date" :disabled="disable_max"
                :format="dateFormat"
                :value-format="valueFormat"
                :placeholder="placeholder"/>
        <el-checkbox v-model="disable_max" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        <el-button type="primary" plain v-if="deletable" @click="deleteMe"><i class="fa fa-fw fa-trash"></i></el-button>
    </el-form-item>
</template>

<script>
    export default {
        name: 'date-filter',
        props: {
            label: {type: String, default: 'Date filter'},
            dateFormat: {type: String, default: 'dd-MM-yyyy'},
            valueFormat: {type: String, default: 'dd-MM-yyyy'},
            placeholder: {type: String, default: ''},
            deletable: {type: Boolean, default: false},
            name: {type: String, required: true}
        },
        data: function() {
            return {
                date_min: '',
                date_max: '',
                disable_min: false,
                disable_max: false
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