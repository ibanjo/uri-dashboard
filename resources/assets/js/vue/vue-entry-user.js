// Vue VM for registering users
if ($('#vue-entry-user').length) {
    const VueEntryUser = new Vue({
        el: '#vue-entry-user',
        data: {
            ready: true,
            roles: DataFromBackend.roles,
            departments: DataFromBackend.departments,
            degree_courses: DataFromBackend.degreeCourses,
            user: {
                registry: {
                    name: '',
                    middle_name: '',
                    surname: '',
                    fiscal_code: '',
                    email: '',
                    telephone: '',
                    password: '',
                    password_confirm: ''
                },
                academic: {
                    degree_course_id: '',
                    department_id: '',
                    number: '',
                    description: '',
                    candidate_role_id: 5
                },
                bank: {
                    iban: '',
                    bank_name: '',
                    holder_name: '',
                    holder_middle_name: '',
                    holder_surname: '',
                    user_is_holder: true,
                    has_bank_account: true
                }
            }
        },
        methods: {
            registerUser: function () {
                // TODO implement validation
                axios.post('/entry/user', Object.assign({}, this.user.registry, this.user.academic, this.user.bank))
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        setTimeout(function () {
                            window.location = response.data.redirect;
                        }, 1000);
                    })
                    .catch(function (error) {
                        this.$message({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
            }
        }
    });
}