// Vue VM for entering countries and university branches
if ($('#vue-view-universities').length) {
    const VueEntryUser = new Vue({
        el: '#vue-view-universities',
        data: {
            ready: true,
            newUniversityBranchVisible: false,
            newCountryVisible: false,
            columns: ['name', 'name_eng', 'erasmus_code', 'country_name', 'edit', 'delete'],
            options: {
                // TODO translate texts
                filterByColumn: true,
                highlightMatches: true,
                pagination: {dropdown: true},
                headings: {
                    name: 'Nome',
                    name_eng: 'Nome internazionale',
                    erasmus_code: 'Codice Erasmus',
                    country: 'Paese',
                    edit: 'Dettagli',
                    delete: 'Elimina'
                },
                sortable: ['name', 'name_eng', 'erasmus_code'],
                filterable: ['name', 'name_eng', 'erasmus_code'],
                templates: {
                    country_name: function (h, row, index) {
                        return row.country.name_ita;
                    },
                    edit: function (h, row, index) {
                        return <i class="fa fa-fw fa-search-plus"></i>
                    },
                    delete: function (h, row, index) {
                        return <i class="fa fa-fw fa-trash"></i>
                    }
                },
                customFilters: [{
                    name: 'country_name',
                    callback: function (row, query) {
                        return row.country.name_ita.toLowerCase()
                            .indexOf(query.toLowerCase()) !== -1;
                    }
                }]
            },
            tableFilters: {
                countryFilter: ''
            },
            universityBranchBuffer: {},
            universityMode: 'create',
            countries: DataFromBackend.countries,
            university_branches: DataFromBackend.university_branches,
            degree_course_types: DataFromBackend.degree_course_types
        },
        computed: {},
        methods: {
            filterByCountry: function () {
                Event.$emit('vue-tables.filter::country_name', this.tableFilters.countryFilter);
            },
            addCountry: function (newCountry) {
                this.countries.push(newCountry);
                this.newCountryVisible = false;
            },
            openNewUniversityDialog: function () {
                this.universityMode = 'create';
                this.universityBranchBuffer = {};
                this.newUniversityBranchVisible = true;
            },
            addUniversity: function (newUniversity) {
                this.university_branches.push(newUniversity);
                this.newUniversityBranchVisible = false;
                this.universityMode = 'closed';
            },
            openEditUniversityDialog: function (data) {
                this.universityBranchBuffer = data.row;
                this.universityMode = 'edit';
                this.newUniversityBranchVisible = true;
            },
            editUniversity: function (data) {
                let idx = this.university_branches.findIndex(x => {return x.id === data.university_branch.id});
                data.modifiedKeys.forEach(k => {
                    this.university_branches[idx][k] = data.university_branch[k];
                });
                this.newUniversityBranchVisible = false;
                this.universityMode = 'closed';
            },
            closeBranchModal: function () {
                this.universityMode = 'closed';
            }
        },
        mounted: function () {
            this.universityBranchBuffer = {};
        }
    });
}