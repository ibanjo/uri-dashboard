// Vue VM for entering mobilities
if ($('#vue-entry-mobility').length) {
    const VueEntryUser = new Vue({
        el: '#vue-entry-mobility',
        data: {
            ready: false,
            activeTab: 'registry',
            user: window.user,
            mobility: {
                university_branch_id: '',
                semester_id: 1,
                estimated_in: '',
                estimated_out: '',
                estimated_cfu_exams: 0,
                estimated_cfu_thesis: 0
            },
            countries: window.countries,
            semesters: window.semesters,
            university_branches: window.university_branches
        },
        computed: {
            // TODO implement automated expected days calculation
        },
        methods: {
            onSubmit: function () {
                axios.post('/entry/mobility', Object.assign({}, this.mobility, {user_id: this.user.id}))
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        setTimeout(function () {
                            window.location = response.data.redirect;
                        }, 1000);
                    })
                    .catch(error => {
                        this.$message({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
            },
            onCancel: function () {
                window.location = '/view/users/' + this.user.id;
            }
        },
        mounted: function () {
            this.ready = true;
        }
    });
}