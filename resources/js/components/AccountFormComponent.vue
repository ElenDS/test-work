<template>
    <div class="container">
        <h1>Create Account</h1>
        <form @submit.prevent="submitForm">
            <div class="form-group" :class="{ error: v$.form.name.$errors.length }">
                <label for="">Account Name</label>
                <input class="form-control" type="text" v-model="v$.form.name.$model">
                <div class="input-errors" v-for="(error, index) of v$.form.name.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <div class="form-group" :class="{ error: v$.form.name.$errors.length }">
                <label for="">Website</label>
                <input class="form-control" type="text" v-model="v$.form.website.$model">
                <div class="input-errors" v-for="(error, index) of v$.form.website.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <div class="form-group" :class="{ error: v$.form.name.$errors.length }">
                <label for="">Phone</label>
                <input class="form-control" type="text" v-model="v$.form.phone.$model">
                <div class="input-errors" v-for="(error, index) of v$.form.phone.$errors" :key="index">
                    <div class="error-msg">{{ error.$message }}</div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="buttons-w">
                <button type="submit" :disabled="v$.form.$invalid" class="btn btn-primary">Send</button>
            </div>

        </form>
        <div>
            <a href="/deal">Create Deal</a>
        </div>

    </div>

    <div class="success" v-if="responseMessage">{{ responseMessage }}</div>
    <div class="alert" v-if="errorMessage">{{ errorMessage }}</div>
</template>

<script>
import useVuelidate from '@vuelidate/core'
import {required, url, numeric} from '@vuelidate/validators'
import axios from 'axios'

export default {

    setup() {
        return {v$: useVuelidate()}
    },

    data() {
        return {
            form: {
                name: '',
                website: '',
                phone: ''
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
                website: {
                    required,
                    url,
                },
                phone: {
                    required,
                    numeric
                }
            },
        }
    },
    methods: {
        validatePhone() {
            const validationRegex = /^\d{10}$/;
            this.phone = !!this.phone.match(validationRegex);
        },
        submitForm() {
            let headers = {
                'Content-Type': 'application/x-www-form-urlencoded'
            };

            axios.post('/submit-account', this.form, {
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
    margin: 15px 0;
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
</style>
