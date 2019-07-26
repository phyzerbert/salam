
var app = new Vue({
    el: '#app',

    data: {
        order_items: [],
        products: [],
        selected_product: '',
        total: {
            quantity: 0,
            cost: 0
        },
        params: {
            type: $('#data').data('type'),
            id: $('#data').data('id')
        }
    },


    methods:{
        init() {
            axios.get('/get_products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.log(error);
                });            
        },
        get_product(i) {
            const data = new FormData();
            data.append('id', this.order_items[i].product_id);

            axios.post('/get_product', data)
                .then(response => {
                    this.order_items[i].cost = response.data.cost
                    this.order_items[i].tax_name = response.data.tax.name
                    this.order_items[i].tax_rate = response.data.tax.rate
                    this.order_items[i].quantity = 1
                    this.order_items[i].sub_total = response.data.cost + (response.data.cost*response.data.tax.rate)/100
                })
                .catch(error => {
                    console.log(error);
                });
        },
        add_item() {
            this.order_items.push({
                product_id: "",
                product_name_code: "",
                cost: 0,
                tax_name: "",
                tax_rate: 0,
                quantity: 0,
                expiry_date: "",
                sub_total: 0,
            })
        },
        calc_subtotal() {
            data = this.order_items
            let total_quantity = 0;
            let total_cost = 0;
            for(let i = 0; i < data.length; i++) {
                this.order_items[i].sub_total = (parseInt(data[i].cost) + (data[i].cost*data[i].tax_rate)/100) * data[i].quantity
                total_quantity += parseInt(data[i].quantity)
                total_cost += data[i].sub_total
            }

            this.total.quantity = total_quantity
            this.total.cost = total_cost
        },
        remove(i) {
            this.order_items.splice(i, 1)
        }
    },

    mounted:function() {
        this.init();
        console.log(this.params)
        axios.post('/get_orders', this.params)
            .then(response => {
                // console.log(response.data)
                for (let i = 0; i < response.data.length; i++) {
                    const element = response.data[i];
                    axios.post('/get_product', {id:element.product_id})
                    .then(response1 => {
                        this.order_items.push({
                            product_id: element.product_id,
                            product_name_code: response1.data.name + "(" + response1.data.code + ")",
                            cost: element.cost,
                            tax_name: response1.data.tax.name,
                            tax_rate: response1.data.tax.rate,
                            quantity: element.quantity,
                            expiry_date: element.expiry_date,
                            sub_total: element.subtotal,
                            order_id: element.id,
                        })
                    })
                    .catch(error => {
                        console.log(error);
                    });                    
                }
            })
            .catch(error => {
                console.log(error);
            });
            
    },
    updated: function() {
        this.calc_subtotal()
    }
});
