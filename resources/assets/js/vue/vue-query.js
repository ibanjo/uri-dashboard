if ($('#vue-query').length) {
    const VueQuery = new Vue({
        el: '#vue-query',
        data: {
            availableFilters: DataFromBackend.available_filters
        },
        methods: {

        }
    });
}