// Vue VM for entering countries and university branches
if ($('#vue-entry-universities').length) {
    const VueEntryUser = new Vue({
        el: '#vue-entry-universities',
        data: {
            countries: DataFromBackend.countries,
            university_branches: DataFromBackend.university_branches,
            degree_course_types: DataFromBackend.degree_course_types
        },
        methods: {
            addCountry: function (newCountry) {
                this.countries.push(newCountry);
            },
            addUniversity: function (newUniversity) {
                this.university_branches.push(newUniversity);
            }
        }
    });
}