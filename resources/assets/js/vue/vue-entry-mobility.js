// Vue VM for entering mobilities
if ($('#vue-entry-mobility').length) {
    const VueEntryUser = new Vue({
        el: '#vue-entry-mobility',
        data: {
            ready: true,
            activeTab: 'registry',
            user: DataFromBackend.user,
            mobility: {
                university_branch_id: '',
                semester_id: 1,
                estimated_in: '',
                estimated_out: '',
                estimated_cfu_exams: 0,
                estimated_cfu_thesis: 0,
                academic_year: '',
                granted: false
            },
            rules: {
                mobility: {
                    academic_year: [
                        {required: true, message: 'L\'anno accademico è richiesto', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                if (!/\d{4}\/\d{2}$/.test(value)) {
                                    callback(new Error('Formato: AAAA/AA'))
                                } else
                                    callback();
                            },
                            trigger: 'blur'
                        }
                    ]
                }
            },
            countries: DataFromBackend.countries,
            semesters: DataFromBackend.semesters,
            university_branches: DataFromBackend.university_branches
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
        }
    });
}