<template>
    <div class="container-fluid pa-0 pb-2">
        <v-app-bar hide-on-scroll app class="transparent elevation-0">
            <v-overlay absolute opacity="0.3" value="true" z-index="0"></v-overlay>
            <v-img v-show="!type == 'admin'" src="img/Phtech.png" max-width="200px" alt="avatar"/>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/">HOME</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/about">ABOUT</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/communities">COMMMUNITIES</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/event">EVENTS</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/signin">SIGN-IN</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='!isnakalogin()' to="/signup">SIGN-up</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='isnakalogin()' to="/explore">EXPLORE</v-btn>
                <!-- <v-menu open-on-hover transition="slide-y-transition" offset-y :close-on-content-click="false">
                    <template v-slot:activator="{ on }" :close-on-click="false">
                        <v-btn text class="font-weight-bold mr-10" color="primary" v-show='isnakalogin()' v-on="on">EXPLORE</v-btn>
                    </template>
                    <v-list two-line >
                        <v-list-item ripple="ripple" to="/communities">
                            <v-list-item-avatar>
                                <v-icon class="teal lighten-2 white--text"
                                >mdi-account-group</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Communities</v-list-item-title>
                                <v-list-item-subtitle>View All Communities</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item ripple="ripple" to="/event">
                            <v-list-item-avatar>
                                <v-icon class="teal lighten-2 white--text"
                                >mdi-calendar</v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>Events</v-list-item-title>
                                <v-list-item-subtitle>View All Events</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu> -->
                <v-btn text class="font-weight-bold mr-10" color="primary" v-show='isnakalogin()' to="/newcommunity"><v-icon left dark>mdi-plus</v-icon> COMMMUNITY</v-btn>
                <!-- <v-btn text class="font-weight-bold mr-10" color="primary" v-show='isnakalogin()' to="/newevent"><v-icon left dark>mdi-plus</v-icon> EVENTS</v-btn> -->
                <!-- <v-btn text class="font-weight-bold teal--text" v-show='isLoggedIn' @click="logout">LOGOUT</v-btn> -->
            </v-toolbar-items>
            <v-menu transition="slide-x-reverse-transition" offset-y>
                <template v-slot:activator="{ on }" :close-on-click="false">
                    <v-btn class="hidden-md-and-up" icon v-on="on" v-if='!isnakalogin()'>
                        <v-icon>mdi-menu</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item ripple="ripple" to="/">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-home</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>HOME</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" to="/about">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-information</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>ABOUT</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" to="/event">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-calendar</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>EVENTS</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" to="/communities">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-account-group</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>COMMUNITIES</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" to="/signin">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-clipboard-account</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>SIGN-IN</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" to="/signup">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-account-plus</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>SIGN-UP</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
            <v-menu transition="slide-x-reverse-transition" offset-y :nudge-width="200">
                <template v-slot:activator="{ on }" :close-on-click="false">
                    <v-btn text class="font-weight-bold teal--text" v-on="on"  v-if='isnakalogin()'>
                        <v-avatar>
                            <cld-image :publicId="photo" >
                                <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                <cld-transformation width="200" crop="scale" />
                            </cld-image>
                        </v-avatar>
                        <v-icon>mdi-chevron-down</v-icon>
                    </v-btn>
                </template>
                <v-list two-line>
                    <v-list-item ripple="ripple" to="/profile">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-account-circle</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>My Profile</v-list-item-title>
                            <v-list-item-subtitle>Edit Profile</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" to="/notification">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-bell</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Notifications</v-list-item-title>
                            <v-list-item-subtitle>See All Notifications</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="hidden-md-and-up" ripple="ripple" to="/explore">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-calendar</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Explore Events</v-list-item-title>
                            <v-list-item-subtitle>Explore All My Events</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="hidden-md-and-up" ripple="ripple" to="/newcommunity">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-plus</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>Create Community</v-list-item-title>
                            <v-list-item-subtitle>Create a new Community</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item ripple="ripple" @click="logout">
                        <v-list-item-avatar>
                            <v-icon class="teal lighten-2 white--text"
                            >mdi-logout-variant</v-icon>
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
            admins: [
                ['Management', 'mdi-account-group'],
                ['Settings', 'mdi-settings'],
            ],
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
