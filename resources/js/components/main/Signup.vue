<template>
    <div class="container fluid">
        <v-row justify="center" align="center">
            <v-col xs="12" md="10" lg="10" justify="center" align="center">
                <v-card width="600px" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
                    <v-toolbar color="primary" dark class="text-center">
                        <v-toolbar-title class="display-1">User Register</v-toolbar-title>
                        <v-icon x-large>mdi-account-plus</v-icon>
                    </v-toolbar>
                    <v-card-text>
                            <v-container grid-list-sm bt-0>
                                <v-layout row wrap>
                                    <!-- Name -->
                                    <v-flex xs12 md12>
                                        <v-text-field :rules="rules" outlined id="lastname" type="text" label="Last Name" v-model="user.lastname" required autofocus prepend-inner-icon="mdi-account-circle"/>
                                    </v-flex>
                                    <v-flex xs12 md12>
                                        <v-text-field :rules="rules" outlined id="firstname" type="text" label="First Name" v-model="user.firstname" required prepend-inner-icon="mdi-account-circle" />
                                    </v-flex>
                                    <!--Email Address -->
                                    <v-flex xs12 md12>
                                        <v-text-field outlined id="address" type="text" label="Email" v-model="user.email" required prepend-inner-icon="mdi-at"/>
                                    </v-flex>
                                    <!-- Password -->
                                    <v-flex xs12 md12>
                                        <v-text-field :rules="rules" outlined id="password" :type="show1 ? 'text' : 'password'" @click:append="show1 = !show1" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" label="Password" v-model="user.password" required prepend-inner-icon="mdi-lock"/>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-row justify="center">
                                <v-col xs="12" md="12" justify="center">
                                    <v-btn pa-1 :loading="loading" block x-large rounded color="primary" @click="register">Register</v-btn>
                                </v-col>
                            </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loading: false,
            show1: false,
            user: { password: null, lastname: null, firstname: null, email: null,},
            rules: [v => !!v || "The input is required"],
        }
    },
    methods: {
        register() {
            this.loading = true
            axios.post('api/register', { 
                password: this.user.password, 
                name: this.user.firstname + " " + this.user.lastname,
                lastname: this.user.lastname,
                firstname: this.user.firstname,
                email: this.user.email, 
                user_type: "user"
            })   
            .then( response => { 
                axios.post('api/login', { 
                    email: this.user.email, password: this.user.password
                })
                .then( response => {
                    var token = response.data.token
                    var id = response.data.user
                    var type = response.data.type
                    var avatar = response.data.avatar
                    // Create a local storage item
                    sessionStorage.setItem('user-token', token)
                    sessionStorage.setItem('user-id', id)
                    sessionStorage.setItem('user-type', type)
                    sessionStorage.setItem('user-avatar', avatar)

                    swal.fire({
                        position: 'top-end',
                        toast: true,
                        type: 'success',
                        title: 'Successfully Logined',
                        showConfirmButton: false,
                        timer: 1500
                        // onClose: () => {
                        //     window.location.reload()
                        // }

                    })
                    // Redirect user
                    this.$router.push('info')
                    window.location.reload()
                    
                })
                .catch( error => { alert(error.errors)})
                .finally( x => {})
            })
            .catch( error => { alert(error)})
            .finally( x => { 
                this.loading = false
            })
        }
    },
    created(){
        
    },
    beforeRouteEnter (to, from, next) { 
        if (sessionStorage.getItem('user-id')) {
            return next('dashboard');
        }

        next();
    }
}
</script>
