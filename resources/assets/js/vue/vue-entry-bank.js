// Vue VM for entering bank accounts
if ($('#vue-entry-bank').length) {
    const VueEntryBank = new Vue({
        el: '#vue-entry-bank',
        data: {
            ready: false,
            activeTab: 'registry',
            user: {},
            rules: {
                bank_name: [
                    {required: true, message: 'Inserisci il nome della banca', trigger: 'blur'}
                ],
                iban: [
                    {
                        validator: (rule, value, callback) => {
                            if (!IBAN.isValid(value)) {
                                callback(new Error('Il codice IBAN inserito non è valido'));
                            } else {
                                callback();
                            }
                        },
                        trigger: 'blur'
                    },
                    {required: true, message: 'Il codice IBAN è richiesto', trigger: 'blur'}
                ]
            },
            bank: {
                bank_name: '',
                iban: '',
                holder_name: '',
                holder_middle_name: '',
                holder_surname: '',
                user_is_holder: true,
                set_primary: true
            }
        },
        methods: {
            onSubmit: function () {
                axios.post('/entry/bank/account', Object.assign({}, this.bank, {user_id: this.user.id}))
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
        created: function () {
            this.user = window.user;
        },
        mounted: function () {
            this.ready = true;
        }
    });
}