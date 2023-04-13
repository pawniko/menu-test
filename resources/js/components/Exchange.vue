<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h3 class="mb-6 text-center">Currency Exchange</h3>
                <form>

                    <div class="form-group">
                        <label for="currency">Currency:</label>
                        <select id="currency" v-model="selectedCurrency" class="form-control">
                            <option v-for="currency in currencies" :value="currency.code">{{ currency.name }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input id="amount" v-model="amount" type="number" class="form-control">
                        <div v-if="validationError" class="text-danger">{{ validationError }}</div>
                    </div>

                    <button class="btn btn-primary mb-3" @click="calculate">Calculate</button>
                    <button v-on="on" v-if="results" class="btn btn-success mb-3 ml-2" @click="order">Purchase</button>

                    <table class="table table-striped" v-if="results">
                        <caption class="font-weight-bold text-success">{{ tableCaption }}</caption>
                        <tbody>
                            <tr v-for="item in tableData" :key="item.label">
                                <td>{{ item.label }}</td>
                                <td>{{ item.value }}</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                tableCaption: '',
                currencies: [],
                selectedCurrency: '',
                amount: '',
                results: null,
                validationError: '',
            };
        },
        created() {
            this.fetchCurrencies();
        },
        methods: {
            fetchCurrencies() {
                fetch('/api/currencies')
                    .then(response => response.json())
                    .then(response => {
                        this.currencies = response.data;
                        this.selectedCurrency = this.currencies[0].code;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            calculate(event) {
                event.preventDefault();

                if (!this.selectedCurrency || !this.amount) {
                    this.validationError = 'Please select a currency and enter an amount.';
                    return;
                }

                this.validationError = '';

                const url = `/api/orders/calculation?currency_code=${this.selectedCurrency}&amount=${this.amount}`;

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.results = data.data;

                    const exchangeRate = data.data.exchange_rate;
                    const surchargeAmount = data.data.surcharge_amount;
                    const totalPaidAmount = data.data.total_paid_amount;
                    const discountAmount = data.data.discount_amount;

                    this.tableCaption = 'Order calculation'
                    this.tableData = [
                        {
                            label: "Exchange Rate",
                            value: exchangeRate
                        },
                        {
                            label: "Surcharge Amount",
                            value: surchargeAmount
                        },
                        {
                            label: "Total Amount",
                            value: totalPaidAmount
                        }
                    ];

                    if (discountAmount) {
                        this.tableData.push(
                            {
                                label: "Discount Amount",
                                value: discountAmount
                            }
                        );
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.results = 'Error calculating amount';
                });
            },
            order(event) {
                event.preventDefault();
                fetch('/api/orders', {
                    method: 'POST',
                    body: JSON.stringify({
                        currency_code: this.selectedCurrency,
                        amount: this.amount
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.results = data.data;

                    const id = data.data.id;
                    const exchangeRate = data.data.exchange_rate;
                    const surchargeAmount = data.data.surcharge_amount;
                    const totalPaidAmount = data.data.total_paid_amount;
                    const discountAmount = data.data.discount_amount;

                    this.tableCaption = 'Order successful ID: #'+id;
                    this.tableData = [
                        {
                            label: "Exchange Rate",
                            value: exchangeRate
                        },
                        {
                            label: "Surcharge Amount",
                            value: surchargeAmount
                        },
                        {
                            label: "Total Amount",
                            value: totalPaidAmount
                        }
                    ];

                    if (discountAmount) {
                        this.tableData.push(
                            {
                                label: "Discount Amount",
                                value: discountAmount
                            }
                        );
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.results = 'Error placing order';
                });
            }
        }
    };
</script>
