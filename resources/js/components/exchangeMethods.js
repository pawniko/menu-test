export default {
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
            .then(response => {
                this.results = response.data;
                this.tableCaption = 'Order calculation'
                this.tableData = [
                    {
                        label: 'Sell',
                        value: response.data.from_currency
                    },
                    {
                        label: 'Buy',
                        value: response.data.purchased_currency
                    },
                    {
                        label: 'Exchange Rate',
                        value: response.data.exchange_rate
                    },
                    {
                        label: 'Surcharge Amount',
                        value: response.data.surcharge_amount
                    },
                    {
                        label: 'Total Amount',
                        value: response.data.total_paid_amount
                    }
                ];

                if (response.data.discount_amount) {
                    this.tableData.push(
                        {
                            label: 'Discount Amount',
                            value: response.data.discount_amount
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
                this.tableCaption = 'Order placed successfully, check your email.';
                this.tableData = [
                    {
                        label: 'Sell',
                        value: data.data.from_currency
                    },
                    {
                        label: 'Buy',
                        value: data.data.purchased_currency
                    },
                    {
                        label: 'Exchange Rate',
                        value: data.data.exchange_rate
                    },
                    {
                        label: 'Surcharge Amount',
                        value: data.data.surcharge_amount
                    },
                    {
                        label: 'Total Amount',
                        value: data.data.total_paid_amount
                    }
                ];

                if (data.data.discount_amount) {
                    this.tableData.push(
                        {
                            label: 'Discount Amount',
                            value: data.data.discount_amount
                        }
                    );
                }
            })
            .catch(error => {
                console.error(error);
                this.results = 'Error placing order';
            });
    }
};
