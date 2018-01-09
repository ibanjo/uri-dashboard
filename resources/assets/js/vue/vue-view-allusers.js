// Vue VM for viewing users
if ($('#vue-view-users').length) {
    const VueViewUsers = new Vue({
        el: '#vue-view-users',
        data: {
            ready: true,
            subview: DataFromBackend.subview,
            departmentQuery: '',
            registerQuery: '',
            roleQuery: '',
            columns: ['id', 'name', 'surname', 'department_name', 'register_number', 'uri'],
            users: DataFromBackend.users,
            options: {
                // TODO translate texts
                filterByColumn: true,
                highlightMatches: true,
                headings: {
                    id: 'ID',
                    name: 'Nome',
                    surname: 'Cognome',
                    department_name: 'Dipartimento',
                    register_number: 'Matricola',
                    uri: 'Dettagli'
                },
                sortable: ['name', 'surname'],
                filterable: ['name', 'surname'],
                templates: {
                    department_name: function (h, row, index) {
                        return row.department.name;
                    },
                    register_number: function (h, row, index) {
                        if(row.registers.length > 1)
                            return <i class="fa fa-fw fa-plus"/>;
                        else {
                            return row.registers[0].number;
                        }
                    },
                    uri: function (h, row, index) {
                        return <a href={'/view/users/' + row.id}><i class="fa fa-fw fa-edit"></i></a> ;
                    },
                    role: function (h, row, index) {
                        return row.role.description;
                    }
                },
                customFilters: [{
                    name: 'register_number',
                    callback: function (row, query) {
                        return row.registers.findIndex((reg) => {
                            return reg.number.toLowerCase()
                                .indexOf(query.toLowerCase()) !== -1;
                        }) !== -1;
                    }
                }, {
                    name: 'department_name',
                    callback: function (row, query) {
                        return row.department.name.toLowerCase()
                            .indexOf(query.toLowerCase()) !== -1;
                    }
                }, {
                    name: 'role',
                    callback: function (row, query) {
                        return row.role.description.toLowerCase()
                            .indexOf(query.toLowerCase()) !== -1;
                    }
                }]
            }
        },
        methods: {
            // Fire custom filter events
            filterDepartment: function () {
                Event.$emit('vue-tables.filter::department_name', this.departmentQuery);
            },
            filterRegister: function () {
                Event.$emit('vue-tables.filter::register_number', this.registerQuery);
            },
            filterRole: function () {
                Event.$emit('vue-tables.filter::role', this.roleQuery);
            }
        },
        created: function () {
            if(this.subview.name === 'all')
                this.columns.splice(3, 0, 'role');
        }
    });
}