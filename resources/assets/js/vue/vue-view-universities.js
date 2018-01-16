// Vue VM for entering countries and university branches
if ($('#vue-view-universities').length) {
    const VueEntryUser = new Vue({
        el: '#vue-view-universities',
        data: {
            ready: true,
            newUniversityBranchVisible: false,
            newCountryVisible: false,
            columns: [],
            countries: DataFromBackend.countries,
            university_branches: DataFromBackend.university_branches,
            degree_course_types: DataFromBackend.degree_course_types
        },
        methods: {
            addCountry: function (newCountry) {
                this.countries.push(newCountry);
                this.newCountryVisible = false;
            },
            addUniversity: function (newUniversity) {
                this.university_branches.push(newUniversity);
                this.newUniversityBranchVisible = false;
            }
        }
    });
}