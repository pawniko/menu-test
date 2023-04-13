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
            .then(data => {
                this.results = data.data;

                const exchangeRate = data.data.exchange_rate;
                const surchargeAmount = data.data.surcharge_amount;
                const totalPaidAmount = data.data.total_paid_amount;
                const discountAmount = data.data.discount_amount;

                this.tableCaption = 'Order calculation'
                this.tableData = [
                    {
                        label: 'Exchange Rate',
                        value: exchangeRate
                    },
                    {
                        label: 'Surcharge Amount',
                        value: surchargeAmount
                    },
                    {
                        label: 'Total Amount',
                        value: totalPaidAmount
                    }
                ];

                if (discountAmount) {
                    this.tableData.push(
                        {
                            label: 'Discount Amount',
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

                const exchangeRate = data.data.exchange_rate;
                const surchargeAmount = data.data.surcharge_amount;
                const totalPaidAmount = data.data.total_paid_amount;
                const discountAmount = data.data.discount_amount;

                this.tableCaption = 'Order placed successfully, check your email.';
                this.tableData = [
                    {
                        label: 'Exchange Rate',
                        value: exchangeRate
                    },
                    {
                        label: 'Surcharge Amount',
                        value: surchargeAmount
                    },
                    {
                        label: 'Total Amount',
                        value: totalPaidAmount
                    }
                ];

                if (discountAmount) {
                    this.tableData.push(
                        {
                            label: 'Discount Amount',
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
};
