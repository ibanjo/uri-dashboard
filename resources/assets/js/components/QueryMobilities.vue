<template>
    <el-form :inline="inline" label-width="300px">
        <el-form-item label="Aggiungi filtro">
            <el-select v-model="newFilterId" filterable>
                <el-option
                        v-for="(filter, index) in availableFilters"
                        :key="filter.name"
                        :label="filter.label"
                        :value="index"
                />
            </el-select>
            <el-button type="primary" plain @click="addFilter">
                <i class="fa fa-fw fa-plus"></i>
            </el-button>
        </el-form-item>

        <div v-for="(filter, index) in filters">
            <component :ref="'filter' + index" :is="filter.type"
                       v-bind="filter" :deletable="true" :name="filter.name"
                       @deleted="deleteFilter(index)"></component>
        </div>

        <el-form-item>
            <el-button type="primary" @click="testQuery"><i class="fa fa-fw fa-download"></i> Esporta</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import DateFilter from "./filters/DateFilter";
    import TextFilter from "./filters/TextFilter";
    import BooleanFilter from "./filters/BooleanFilter";

    export default {
        components: {DateFilter, TextFilter, BooleanFilter},
        name: 'query-mobilities',
        props: {
            inline: {type: Boolean, default: false},
            availableFilters: {type: Array, required: true},
            fileName: {type: String, default: 'export.xlsx'},
            action: {type: String, required: true},
            downloadAction: {type: String, required: true}
        },
        data: function () {
            return {
                newFilterId: 0,
                filters: []
            }
        },
        methods: {
            addFilter: function () {
                this.filters.push(this.availableFilters[this.newFilterId]);
            },
            deleteFilter: function (index) {
                this.filters.splice(index, 1);
            },
            submitQuery: function () {
                axios.post(this.action, {query: this.query, flags: this.flags})
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        window.open(
                            this.downloadAction
                                .replace('identifier', response.data.identifier)
                                .replace('filename', this.fileName));
                    })
                    .catch(error => {
                        this.$message.error(error.response.data);
                    });
            },
            testQuery: function () {
                // FIXME temporary. Now output is ok, just need to rewrite the backend to parse it
                let output = [];
                for (let prop in this.$refs) {
                    if (this.$refs.hasOwnProperty(prop)) {
                        output.push(Object.assign(
                            {}, this.$refs[prop][0].$data,
                            {name: this.$refs[prop][0].name}
                        ));
                    }
                }
                console.log(output);
            }
        }
    }
</script>

<style scoped>

</style>