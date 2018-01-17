// Vue VM for registering users
if ($('#vue-home').length) {
    const VueEntryUser = new Vue({
        el: '#vue-home',
        // TODO put all text in a locale file
        data: {
            toApprove: DataFromBackend.toApprove,
            toApproveMessage: 'Nuovi utenti in attesa di approvazione',
            nothingToBeDoneMessage: 'Buon lavoro!',
            attentionRequired: []
        },
        computed: {
            nothingToBeDone: function () {
                return !(this.toApprove.length > 0);
            }
        },
        methods: {
            showUnapproved: function () {
                window.location = '/admin/approve';
            }
        }
    });
}