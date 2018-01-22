<template>
    <el-form :inline="inline" :model="query" :rules="rules.query" label-width="300px">
        <el-form-item label="Incoming / Outgoing">
            <el-checkbox v-model="flags.disable_incoming" border><i class="fa fa-fw fa-close"></i></el-checkbox>
            <el-switch active-text="Incoming" inactive-text="Outgoing"
                       v-model="query.incoming" :disabled="flags.disable_incoming"/>
        </el-form-item>
        <el-form-item label="Anno accademico" prop="academic_year">
            <el-checkbox v-model="flags.disable_academic_year" border><i class="fa fa-fw fa-close"></i></el-checkbox>
            <el-input
                    v-model="query.academic_year" :disabled="flags.disable_academic_year"
                    style="width: 200px" placeholder="Formato: 2015/16">
            </el-input>
        </el-form-item>
        <el-form-item label="Inizio mobilità (Learning Agreement)">
            <el-checkbox v-model="flags.disable_estimated_in_min" border><i class="fa fa-fw fa-close"></i></el-checkbox>
            <el-date-picker
                    v-model="query.estimated_in_min"
                    type="date" :disabled="flags.disable_estimated_in_min"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Inizio mobilità (LA)"/>
            <i class="fa fa-fw fa-arrows-h"></i>
            <el-date-picker
                    v-model="query.estimated_in_max"
                    type="date" :disabled="flags.disable_estimated_in_max"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Inizio mobilità (LA)"/>
            <el-checkbox v-model="flags.disable_estimated_in_max" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        </el-form-item>
        <el-form-item label="Fine mobilità (Learning Agreement)">
            <el-checkbox v-model="flags.disable_estimated_out_min" border><i class="fa fa-fw fa-close"></i></el-checkbox>
            <el-date-picker
                    v-model="query.estimated_out_min"
                    type="date" :disabled="flags.disable_estimated_out_min"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Fine mobilità (LA)"/>
            <i class="fa fa-fw fa-arrows-h"></i>
            <el-date-picker
                    v-model="query.estimated_out_max"
                    type="date" :disabled="flags.disable_estimated_out_max"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Fine mobilità (LA)"/>
            <el-checkbox v-model="flags.disable_estimated_out_max" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        </el-form-item>
        <el-form-item label="Inizio mobilità (Transcript)">
            <el-checkbox v-model="flags.disable_acknowledged_in_min" border><i class="fa fa-fw fa-close"></i></el-checkbox>
            <el-date-picker
                    v-model="query.acknowledged_in_min"
                    type="date" :disabled="flags.disable_acknowledged_in_min"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Inizio mobilità (ToR)"/>
            <i class="fa fa-fw fa-arrows-h"></i>
            <el-date-picker
                    v-model="query.acknowledged_in_max"
                    type="date" :disabled="flags.disable_acknowledged_in_max"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Inizio mobilità (ToR)"/>
            <el-checkbox v-model="flags.disable_acknowledged_in_max" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        </el-form-item>
        <el-form-item label="Fine mobilità (Learning Agreement)">
            <el-checkbox v-model="flags.disable_acknowledged_out_min" border><i class="fa fa-fw fa-close"></i></el-checkbox>
            <el-date-picker
                    v-model="query.acknowledged_out_min"
                    type="date" :disabled="flags.disable_acknowledged_out_min"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Fine mobilità (ToR)"/>
            <i class="fa fa-fw fa-arrows-h"></i>
            <el-date-picker
                    v-model="query.acknowledged_out_max"
                    type="date" :disabled="flags.disable_acknowledged_out_max"
                    format="dd-MM-yyyy"
                    value-format="dd-MM-yyyy"
                    placeholder="Fine mobilità (ToR)"/>
            <el-checkbox v-model="flags.disable_acknowledged_out_max" border><i class="fa fa-fw fa-close"></i></el-checkbox>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="submitQuery"><i class="fa fa-fw fa-download"></i> Esporta</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    export default {
        name: 'query-mobilities',
        props: {
            inline: {type: Boolean, default: false},
            fileName: {type: String, default: 'export.xlsx'},
            action: {type: String, required: true},
            downloadAction: {type: String, required: true}
        },
        data: function () {
            return {
                query: {
                    incoming: false,
                    academic_year: '',
                    estimated_in_min: '',
                    estimated_in_max: '',
                    estimated_out_min: '',
                    estimated_out_max: '',
                    acknowledged_in_min: '',
                    acknowledged_in_max: '',
                    acknowledged_out_min: '',
                    acknowledged_out_max: ''
                },
                flags: {
                    disable_incoming: false,
                    disable_academic_year: false,
                    disable_estimated_in_min: true,
                    disable_estimated_in_max: true,
                    disable_estimated_out_min: true,
                    disable_estimated_out_max: true,
                    disable_acknowledged_in_min: true,
                    disable_acknowledged_in_max: true,
                    disable_acknowledged_out_min: true,
                    disable_acknowledged_out_max: true
                },
                rules: {
                    query: {
                        academic_year: [
                            {
                                validator: (rule, value, callback) => {
                                    if (!/^$|\d{4}\/\d{2}$/.test(value)) {
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
        methods: {
            submitQuery: function () {
                axios.post(this.action, {query: this.query, flags: this.flags})
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        window.open(this.downloadAction.replace('identifier', response.data.identifier));
                    })
                    .catch(error => {
                        this.$message.error(error.response.data);
                    });
            }
        }
    }
</script>

<style scoped>

</style>