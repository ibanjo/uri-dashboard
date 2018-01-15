// Vue VM for registering users
if ($('#vue-entry-user').length) {
    const VueEntryUser = new Vue({
        el: '#vue-entry-user',
        data: {
            ready: true,
            recapTab: 'registry',
            roles: DataFromBackend.roles,
            departments: DataFromBackend.departments,
            degree_courses: DataFromBackend.degreeCourses,
            rules: {
                registry: {
                    name: [
                        {required: true, message: 'Il nome è richiesto', trigger: 'blur'}
                    ],
                    surname: [
                        {required: true, message: 'Il cognome è richiesto', trigger: 'blur'}
                    ],
                    fiscal_code: [
                        {required: true, message: 'Il codice fiscale è richiesto', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                if (!(/^(?:[B-DF-HJ-NP-TV-Z](?:[AEIOU]{2}|[AEIOU]X)|[AEIOU]{2}X|[B-DF-HJ-NP-TV-Z]{2}[A-Z]){2}[\dLMNP-V]{2}(?:[A-EHLMPR-T](?:[04LQ][1-9MNP-V]|[1256LMRS][\dLMNP-V])|[DHPS][37PT][0L]|[ACELMRT][37PT][01LM])(?:[A-MZ][1-9MNP-V][\dLMNP-V]{2}|[A-M][0L](?:[\dLMNP-V][1-9MNP-V]|[1-9MNP-V][0L]))[A-Z]$/i).test(value)) {
                                    callback(new Error('Il codice fiscale non è valido'))
                                } else
                                    callback();
                            },
                            trigger: 'blur'
                        }
                    ],
                    email: [
                        {required: true, message: 'Inserire un indirizzo email', trigger: 'blur'},
                        {type: 'email', message: 'Inserire un indirizzo email valido', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: 'Inserire una password', trigger: 'blur'}
                    ],
                    password_confirm: [
                        {required: true, message: 'Ripetere la password', trigger: 'blur'},
                        {
                            validator: (rule, value, callback) => {
                                // TODO actually match passwords
                                callback();
                            },
                            trigger: 'blur'
                        }
                    ]
                },
                academic: {
                    candidate_role_id: [
                        {required: true, message: 'Scegliere un ruolo', trigger: 'blur'}
                    ],
                    degree_course_id: [
                        {required: true, message: 'Scegliere il corso di laurea di afferenza', trigger: 'blur'}
                    ]
                }
            },
            user: {
                registry: {
                    name: '',
                    middle_name: '',
                    surname: '',
                    fiscal_code: '',
                    email: '',
                    telephone: '',
                    password: DataFromBackend.userLoggedIn ? 'password' : '',
                    password_confirm: DataFromBackend.userLoggedIn ? 'password' : ''
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
        computed: {
            recap: function () {
                return Object.assign({}, this.user.registry, this.user.academic, this.user.bank);
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