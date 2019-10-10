<template>
    <div class="container fluid">
        <v-layout row>
            <v-layout xs12 md10 lg10 justify-center>
                <v-card width="900px" :class="{'my-5 elevation-0': $vuetify.breakpoint.mdAndUp}">
                    <v-toolbar color="blue darken-3" class="text-center">
                            <v-toolbar-title class="display-2">User Login</v-toolbar-title>
                            <v-icon x-large>assignment_ind</v-icon>
                    </v-toolbar>
                    <v-card-text>
                        <v-row cols="12">
                            <v-col cols="12" md="6" lg="6" xl="6">
                                <!-- Form -->
                                <v-form>
                                    <!-- Username -->
                                    <v-flex xs12 md12>
                                        <v-text-field   outlined id="username" type="text" label="Username" v-model="username" required prepend-inner-icon="account_circle" autofocus/>
                                    </v-flex>
                                    <!-- Password -->
                                    <v-flex xs12 md12>
                                        <v-text-field   outlined id="password" :type="show1 ? 'text' : 'password'" @click:append="show1 = !show1" :append-icon="show1 ? 'visibility' : 'visibility_off'" label="Password" v-model="password"  required prepend-inner-icon="lock"/>
                                    </v-flex>

                                    <v-row justify="center">
                                        <v-col xs="12" md="12" justify="center">
                                            <v-btn pa-1 block x-large rounded :loading="loading" @click="login">Login</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-col>
                            <v-col cols="1" class="hidden-xs-only">
                                    <v-divider vertical></v-divider>
                            </v-col>
                            <v-col cols="12" md="5" lg="5" xl="5">
                                <v-row justify="center">
                                    <p class="display-2">Or Sign-in Using</p>
                                    <v-col xs="12" md="12" justify="center">
                                        <v-btn href="login/google" pa-1 x-large rounded><v-icon left class="blue--text">fab fa-google</v-icon>oogle</v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-layout>
        </v-layout>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                username : "",
                password : "",
                show1: false,
                loading: false,
            }
        },
        methods: {
            login() {
                this.loading = true
                axios.post('api/login', { 
                    username: this.username, password: this.password
                })
                .then( response => {
                    var token = response.data.token
                    // Create a local storage item
                    localStorage.setItem('user-token', token)
                    // Redirect user
                    this.$router.push('requests')
                })
                .catch( error => { alert(error)})
                .finally( x => {this.loading = false})
            }
        }
    }
</script>