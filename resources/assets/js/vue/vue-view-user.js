// Vue VM for viewing a single user
if ($('#vue-view-user').length) {
    const VueViewUser = new Vue({
        el: '#vue-view-user',
        data: {
            ready: true,
            activeTab: 'registry',
            user: DataFromBackend.user,
            attachments: DataFromBackend.attachments,
            attachment_description: '',
            mobility_statuses: DataFromBackend.mobilityStatuses,
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
            pre_upload_icon: function () {
                return {
                    'fa fa-fw fa-file-pdf-o': true
                }
            },
            attachment_additions: function () {
                return {
                    data: {
                        mobility_id: this.user.mobilities[0].id,
                        description: this.attachment_description
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            },
            mobilityStatusActiveTab: function () {
                return this.has_mobilities ? this.user.mobilities[0].mobility_status_id - 1 : 0;
            },
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
            },
            uploadAttachment: function () {
                this.$refs.attachmentUploader.submit();
            },
            onAttachmentSelected: function (file, fileList) {
                console.log('changed');
            },
            onAttachmentUploaded: function (response, file, fileList) {
                this.$message({
                    type: response.status,
                    message: response.message
                });
                this.attachments.push(response.file);
            },
            onAttachmentClicked: function (file, column, cell, event) {
                switch(column.label) {
                    case "Download":
                        this.downloadAttachment(file);
                        break;
                    case "Elimina":
                        this.$confirm('Eliminare l\'allegato?', 'Info', {
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Annulla',
                            type: 'info'
                        }).then(() => {
                            this.removeAttachment(file);
                        }).catch(()=>{});
                        break;
                    default:
                        break;
                }
            },
            downloadAttachment: function (file) {
                axios.post('/file/retrieve/', {id: file.id})
                    .then(response => {
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                        window.open(response.data.url);
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },
            removeAttachment: function (file) {
                axios.delete('/file/delete/' + file.id)
                    .then(response => {
                        this.attachments = this.attachments.filter(att => {return att.id !== file.id});
                        this.$message({
                            type: response.data.status,
                            message: response.data.message
                        });
                    })
                    .catch(error => {
                        console.log(error);
                        this.$message({
                            type: error.response.data.status,
                            message: error.response.data.message
                        });
                    })
            },
            mobilityNextStep() {
                this.$confirm('Portare la mobilità al prossimo stato?', 'Info', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Annulla',
                    type: 'info'
                }).then(() => {
                    axios.put('/edit/mobility', {
                        id: this.user.mobilities[0].id,
                        new_status_id: this.user.mobilities[0].mobility_status_id + 1
                    })
                        .then((response) => {
                            this.user.mobilities[0].mobility_status_id++;
                            this.$message({
                                type: response.data.status,
                                message: response.data.message
                            });
                        })
                        .catch(error => {
                            console.log(error);
                            this.$message({
                                type: error.response.data.status,
                                message: error.response.data.message
                            });
                        });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Avanzamento annullato'
                    });
                });
            },
            navigateToTab(navigateFunction, index) {
                // TODO direct navigation between statuses not implemented
            }
        }
    });
}