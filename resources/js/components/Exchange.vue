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
                    <button v-if="results" class="btn btn-success mb-3 ml-2" @click="order">Purchase</button>

                    <table class="table table-striped" v-if="results">
                        <caption class="font-weight-bold text-success" style="caption-side: top;">{{ tableCaption }}</caption>
                        <thead>
                        <tr>
                            <th>Label</th>
                            <th>Value</th>
                        </tr>
                        </thead>
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
    import methods from './exchangeMethods';

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
        methods: methods
    };
</script>
