import AppForm from '../app-components/Form/AppForm';

Vue.component('discount-form', {
    mixins: [AppForm],
    props: ['customerGroups', 'categories'],
    data: function() {
        return {
            form: {
                name:  '' ,
                description:  '' ,
                percentage:  '' ,
                from_margin:  false ,
                customer_groups: '',
                categories: ''
                
            }
        }
    }

});