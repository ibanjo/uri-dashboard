// Vue VM for entering mobilities
if ($('#vue-entry-mobility').length) {
    const VueEntryMobility = new Vue({
        el: '#vue-entry-mobility',
        data: {
            ready: true,
            activeTab: 'registry',
            user: DataFromBackend.user,
            countries: DataFromBackend.countries,
            semesters: DataFromBackend.semesters,
            university_branches: DataFromBackend.university_branches
        },
        computed: {
            // TODO implement automated expected days calculation
        }
    });
}