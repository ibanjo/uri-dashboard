<template>
    <el-form-item :label="label">
        <el-checkbox v-if="!deletable" v-model="disabled" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        <el-input
                v-model="value" :disabled="disabled"
                style="width: 200px" :placeholder="placeholder">
        </el-input>
        <el-button type="primary" plain v-if="deletable" @click="deleteMe"><i class="fa fa-fw fa-trash"></i></el-button>
    </el-form-item>
</template>

<script>
    export default {
        name: 'text-filter',
        props: {
            label: {type: String, default: 'Text filter'},
            placeholder: {type: String},
            deletable: {type: Boolean, default: false},
            name: {type: String, required: true}
        },
        data: function() {
            return {
                value: '',
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