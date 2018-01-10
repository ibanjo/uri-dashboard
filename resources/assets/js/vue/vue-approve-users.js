// Vue VM for registering users
if ($('#vue-approve-users').length) {
    const VueEntryUser = new Vue({
        el: '#vue-approve-users',
        data: {
            activeTab: 'registry',
            users: window.users,
            nothingToBeDoneMessage: 'Tutti gli utenti sono stati approvati'
        },
        methods: {
            approveUser: function (id) {
                this.$refs.usersCarousel.next(); // Prevents unexpected blank item in the carousel
                axios.put('/admin/approve', {id: id})
                    .then(response => {
                        this.users = this.users.filter((us) => {return us.id !== id});
                        this.$messsage({
                            type: response.data.status,
                            message: response.data.message
                        });
                    })
                    .catch(error => {
                        this.$message({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
            }
        }
    });
}