// Vue VM for viewing a single user
if ($('#vue-view-user').length) {
    const VueViewUser = new Vue({
        el: '#vue-view-user',
        data: {
            ready: true,
            editMobility: false,
            user: DataFromBackend.user,
            attachments: DataFromBackend.attachments,
            mobility_statuses: DataFromBackend.mobility_statuses,
            semesters: DataFromBackend.semesters,
            university_branches: DataFromBackend.university_branches,
            bankTableColumns: ['is_main', 'bank_name', 'iban', 'holder_name', 'holder_surname'],
            bankTableOptions: {
                filterable: false,
                headings: {
                    is_main: 'Principale',
                    bank_name: 'Banca',
                    iban: 'IBAN',
                    holder_name: 'Nome',
                    holder_surname: 'Cognome'
                },
                templates: {
                    is_main: function (h, row, index) {
                        return h('input', {
                            attrs: {
                                checked: row.id === this.user.active_bank_account_id,
                                type: 'checkbox',
                                disabled: true
                            }
                        });
                    }
                }
            },
        },
        computed: {
            full_name: function () {
                return !this.ready ? '...' : this.user.name + ' ' + this.user.middle_name + ' ' + this.user.surname;
            },
            has_mobilities: function () {
                return !this.ready ? false : this.user.mobilities.length > 0;
            },
            has_bank_account: function () {
                return !this.ready ? false : this.user.bank_accounts.length > 0;
            }
        },
        methods: {
            changeActiveBankAccount: function (e) {
                axios.put('/edit/user/activebank', {user_id: this.user.id, active_bank_account_id: e.row.id})
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                    })
                    .catch((response) => {
                        console.log(response);
                    });
                this.user.active_bank_account_id = e.row.id;
            }
        }
    });
}