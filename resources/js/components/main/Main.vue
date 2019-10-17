<template>
    <div class="container-fluid pa-0 pb-2">
        <v-app-bar hide-on-scroll app>
            <v-img v-show="!type == 'admin'" src="img/Phtech.png" max-width="200px" alt="avatar"/>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text class="font-weight-bold blue--text" href="/">HOME</v-btn>
                <v-btn text class="font-weight-bold blue--text" href="/about">ABOUT</v-btn>
                <v-btn text class="font-weight-bold blue--text" href="/dashboard">COMMMUNITIES</v-btn>
                <v-btn text class="font-weight-bold blue--text" href="/news">NEWS</v-btn>
                <v-btn text class="font-weight-bold blue--text" href="/event">EVENTS</v-btn>
                <v-btn text class="font-weight-bold blue--text" v-show='!this.isLoggedIn' href="/signin">SIGN-IN</v-btn>
                <v-btn text class="font-weight-bold blue--text" v-show='!this.isLoggedIn' href="/signup">SIGN-up</v-btn>
                <!-- <v-btn text class="font-weight-bold blue--text" v-show='this.isLoggedIn' @click="logout">LOGOUT</v-btn> -->
            </v-toolbar-items>
            <v-menu transition="slide-x-reverse-transition" offset-y>
                <template v-slot:activator="{ on }">
                <v-btn text class="font-weight-bold blue--text" v-on="on">
                    <v-avatar>
                        <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
                    </v-avatar>
                    <v-icon>keyboard_arrow_down</v-icon>
                </v-btn>
                </template>
                <v-list>
                    <v-list-item ripple="ripple" href="/profile">
                        <v-icon color="primary" right>account_circle</v-icon>
                        <v-list-item-content>
                        <v-list-item-title>My Profile</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" @click="logout">
                        <v-icon color="primary" right>exit_to_app</v-icon>
                        <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <main class="pt-5 mt-5 pb-0">
           <router-view class="mt-5" name="main"></router-view>
        </main>
    </div>
</template>
<script>
    export default {
        data: () => ({
            isLoggedIn : null,
            type: null,
        }),
        methods:{
            logout() {
                this.loading = true
                axios.post('api/logout')   
                .then( response => { 
                    localStorage.clear();
                    // Redirect user
                    window.location.reload()
                })
                .catch( error => { alert(error)})
                // .finally( x => { this.$router.push('/') })
            }
        },
        computed: {

        },
        mounted(){
            this.isLoggedIn = localStorage.getItem('user-id')
            this.type = localStorage.getItem('user-type')
            
        },
        created(){
            // console.log(localStorage.getItem('user-id'));
        }
    }
</script>
