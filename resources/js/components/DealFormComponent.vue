<template>
    <div class="container">

        <h1>Create Deal</h1>
        <form @submit.prevent="submitForm">
            <div class="form-group" :class="{ error: v$.form.name.$errors.length }">
                <label for="">Deal Name</label>
                <input class="form-control" type="text" v-model="v$.form.name.$model">
                <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <div class="form-group" :class="{ error: v$.form.stage.$errors.length }">
                <label for="">Deal Stage</label>
                <select class="form-control" v-model="v$.form.stage.$model">
                    <option value="">select a stage</option>
                    <option>Qualification</option>
                    <option>Needs Analysis</option>
                    <option>Value Proposition</option>
                    <option>Identify Decision Makers</option>
                    <option>Proposal/Price Quote</option>
                    <option>Negotiation/Review</option>
                    <option>Closed Won</option>
                    <option>Closed Lost</option>
                    <option>Closed-Lost to Competition</option>
                </select>
                <div class="input-errors" v-for="(error, index) of v$.form.stage.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <div class="form-group" :class="{ error: v$.form.closingDate.$errors.length }">
                <label for="">Closing Date</label>
                <input class="form-control" type="date" v-model="v$.form.closingDate.$model">
                <div class="input-errors" v-for="(error, index) of v$.form.closingDate.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <div class="form-group" :class="{ error: v$.form.name.$errors.length }">
                <label for="">Account Name</label>
                <select class="form-control" v-model="v$.form.accountName.$model">
                    <option value="">select an account</option>
                    <option v-for="option of accounts" :value="option" :key="option.key">{{ option }}</option>
                </select>
                <div class="input-errors" v-for="(error, index) of v$.form.accountName.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="buttons-w">
                <button type="submit" :disabled="v$.form.$invalid" class="btn btn-primary">Send</button>
            </div>

        </form>
        <div>
            <a href="/account">Create Account</a>
        </div>

    </div>

    <div class="success" v-if="responseMessage">{{ responseMessage }}</div>
    <div class="alert" v-if="errorMessage">{{ errorMessage }}</div>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import axios from 'axios'

export default {
    props: {
        accounts: {
            type: Array,
            required: true
        }
    },

    setup() {
        return {v$: useVuelidate()}
    },

    data() {
        return {
            form: {
                name: '',
                stage: '',
                closingDate: '',
                accountName: ''
            },
            responseMessage: '',
            errorMessage: ''
        }
    },

    validations() {
        return {
            form: {
                name: {
                    required
                },
                stage: {
                    required
                },
                closingDate: {
                    required
                },
                accountName: {
                    required
                }
            },
        }
    },
    methods: {
        submitForm() {
            let headers = {
                'Content-Type': 'application/x-www-form-urlencoded'
            };

            axios.post('/submit-deal', this.form, {
                headers
            })
                .then(response => {
                    if (response.data.success) {
                        this.responseMessage = response.data.message;
                    } else {
                        throw new Error(response.data.message);
                    }


                })
                .catch(error => {
                    this.errorMessage = 'An error has occurred: ' + error.message;
                });
        }
    }

}
</script>

<style>
body {
    margin: 0;
    width: 100vw;
    height: 100vh;
    background: #ecf0f3;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    place-items: center;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

.container {
    position: relative;
    border-radius: 20px;
    padding: 30px;
    box-sizing: border-box;
    background: #ecf0f3;
    box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
}

.form-group {
    text-align: left;
    margin: 10px 0;
}

label, input, button, select {
    display: block;
    width: 100%;
    padding: 0;
    border: none;
    outline: none;
    box-sizing: border-box;
}

label {
    margin-bottom: 4px;
    font-size: 14px;
    font-style: italic;
}

form {
    text-align: center;
}

input, select {
    background: #ecf0f3;
    padding: 10px 10px 10px 20px;
    height: 50px;
    font-size: 14px;
    border-radius: 30px;
    box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px white;
}

button {
    color: white;
    margin-top: 20px;
    background: #1DA1F2;
    height: 40px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 900;
    box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px white;
    transition: 0.5s;
}

button:hover {
    box-shadow: none;
}

.input-errors {
    font-size: 12px;
    font-style: italic;
    color: red;
    padding: 4px;
}

.success {
    text-align: center;
    color: green;
    margin-top: 20px;
}

.alert {
    text-align: center;
    color: red;
    margin-top: 20px;
}

h1 {
    font-size: 15px;
}

</style>
