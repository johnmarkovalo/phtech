<template>
    <div class="container-fluid pa-0 pb-2">
        <v-app-bar hide-on-scroll app class="transparent elevation-0">
            <v-overlay absolute opacity="0.3" value="true" z-index="0"></v-overlay>
            <v-img v-show="!type == 'admin'" src="img/Phtech.png" max-width="200px" alt="avatar"/>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/">HOME</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/about">ABOUT</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/dashboard">COMMMUNITIES</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/event">EVENTS</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/signin">SIGN-IN</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/signup">SIGN-up</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='isnakalogin()' to="/newcommunity"><v-icon left dark>mdi-plus</v-icon> COMMMUNITIES</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='isnakalogin()' to="/newevent"><v-icon left dark>mdi-plus</v-icon> EVENTS</v-btn>
                <!-- <v-btn text class="font-weight-bold teal--text" v-show='isLoggedIn' @click="logout">LOGOUT</v-btn> -->
            </v-toolbar-items>
            <v-menu transition="slide-x-reverse-transition" offset-y :nudge-width="200">
                <template v-slot:activator="{ on }">
                <v-btn text class="font-weight-bold teal--text" v-on="on"  v-if='isnakalogin()'>
                    <v-avatar>
                        <cld-image :publicId="photo" >
                            <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                            <cld-transformation width="200" crop="scale" />
                        </cld-image>
                    </v-avatar>
                    <v-icon>keyboard_arrow_down</v-icon>
                </v-btn>
                </template>
                <v-list two-line>
                    <v-list-item ripple="ripple" to="/profile">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >account_circle</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>My Profile</v-list-item-title>
                            <v-list-item-subtitle>Edit Profile</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" >
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >event</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Event</v-list-item-title>
                            <v-list-item-subtitle>View Events</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" >
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >fas fa-users</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Community</v-list-item-title>
                            <v-list-item-subtitle>View your Communities</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" @click="logout">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >exit_to_app</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Logout</v-list-item-title>
                            <v-list-item-subtitle>Log-out the user</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
        <main >
           <router-view class="mt-12" name="main"></router-view>
        </main>
    </div>
</template>
<script>
    export default {
        data: () => ({
            isLoggedIn : null,
            type: null,
            photo: sessionStorage.getItem('user-avatar'),
        }),
        methods:{
            logout() {
                this.loading = true
                axios.post('api/logout')   
                .then( response => { 
                    sessionStorage.clear();
                    // Redirect user
                    window.location.reload()
                })
                .catch( error => { alert(error)})
                // .finally( x => { this.$router.push('/') })
            },
            isnakalogin() {
                return sessionStorage.getItem('user-id') ? true : false
            }
        },
        computed: {

        },
        mounted(){
            
        },
        created(){
            // sessionStorage.setItem('user-token', token)
            // sessionStorage.setItem('user-id', '1')
            // sessionStorage.setItem('user-type', 'admin')
            // sessionStorage.setItem('user-avatar', 'phtechpark/profiles/default')
        }
    }
</script>
