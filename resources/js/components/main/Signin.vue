<template>
    <div class="container fluid">
        <v-layout row>
            <v-layout xs12 md10 lg10 justify-center>
                <v-card width="600px" :class="{'my-5 elevation-3': $vuetify.breakpoint.mdAndUp}">
                    <v-toolbar dark color="primary" class="text-center">
                            <v-toolbar-title class="display-1">User Login</v-toolbar-title>
                            <v-icon x-large>assignment_ind</v-icon>
                    </v-toolbar>
                    <v-card-text>
                        <v-row cols="12">
                            <v-col cols="12" md="12" lg="12" xl="12">
                                <!-- Form -->
                                <v-form>
                                    <!-- Email -->
                                    <v-flex xs12 md12>
                                        <v-text-field   outlined id="email" type="text" label="Email" v-model="email" required prepend-inner-icon="alternate_email" autofocus/>
                                    </v-flex>
                                    <!-- Password -->
                                    <v-flex xs12 md12>
                                        <v-text-field   outlined id="password" :type="show1 ? 'text' : 'password'" @click:append="show1 = !show1" :append-icon="show1 ? 'visibility' : 'visibility_off'" label="Password" v-model="password"  required prepend-inner-icon="lock"/>
                                    </v-flex>

                                    <v-row justify="center">
                                        <v-col xs="12" md="12" justify="center">
                                            <v-btn color="green" class="white--text" pa-1 block x-large rounded :loading="loading" @click="login">Login</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-col>
                            <!-- <v-col cols="1" class="hidden-xs-only">
                                    <v-divider vertical></v-divider>
                            </v-col>
                            <v-col cols="12" md="5" lg="5" xl="5">
                                <v-row justify="center">
                                    <p class="display-2">Or Sign-in Using</p>
                                    <v-col xs="12" md="12" justify="center">
                                        <v-btn color="green" class="white--text" href="login/google" pa-1 x-large rounded><v-icon left >fab fa-google</v-icon>oogle</v-btn>
                                    </v-col>
                                </v-row>
                            </v-col> -->
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
                email : "",
                password : "",
                show1: false,
                loading: false,
            }
        },
        methods: {
            login() {
                this.loading = true
                axios.post('api/login', { 
                    email: this.email, password: this.password
                })
                .then( response => {
                    var token = response.data.token
                    var id = response.data.user
                    var type = response.data.type
                    // Create a local storage item
                    localStorage.setItem('user-token', token)
                    localStorage.setItem('user-id', id)
                    localStorage.setItem('user-type', type)
                    // Redirect user
                    window.location.reload()
                    
                })
                .catch( error => { alert(error)})
                .finally( x => {
                    this.loading = false
                    if (type == 'admin'){
                        this.$router.push('dashboard')
                    }
                    else{
                        this.$router.push('profile')
                    }
                })
            }
        },
        beforeRouteEnter (to, from, next) { 
            if (localStorage.getItem('user-id')) {
                if (localStorage.getItem('user-type') == 'admin'){
                    return next('dashboard');
                }
                else{
                    return next('profile');
                }
            }
            else{
                next();
            }
        }
    }
</script>