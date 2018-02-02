<template>
    <el-form-item :label="label">
        <el-transfer
                v-model="value"
                :data="options"
                :props="{key: optionKey, label: optionLabel}"
                :titles="titles">
        </el-transfer>
        <el-button type="primary" plain v-if="deletable" @click="deleteMe"><i class="fa fa-fw fa-trash"></i></el-button>
    </el-form-item>
</template>

<script>
    export default {
        name: 'multiple-options-filter',
        props: {
            label: {type: String, default: 'Multiple options filter'},
            titles: {type: Array, default: ['Source', 'Target']},
            deletable: {type: Boolean, default: false},
            name: {type: String, required: true},
            queryScope: {type: Boolean, required: true},
            options: {type: Array, required: true},
            optionKey: {type: String, required: true},
            optionLabel: {type: String, required: true}
        },
        data: function () {
            return {
                value: []
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