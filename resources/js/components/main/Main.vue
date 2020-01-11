<template>
    <div class="container-fluid pa-0 pb-2">
        <v-app-bar hide-on-scroll app class="transparent elevation-0">
            
            <v-img v-show="!type == 'admin'" src="img/Phtech.png" max-width="200px" alt="avatar"/>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='!isnakalogin()' to="/">HOME</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='!isnakalogin()' to="/communities">COMMMUNITIES</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='!isnakalogin()' to="/event">EVENTS</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='!isnakalogin()' to="/signin">SIGN-IN</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='!isnakalogin()' to="/signup">SIGN-up</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='isnakalogin()' to="/explore">EXPLORE</v-btn>
                <v-btn text class="font-weight-bold mr-10" color="teal lighten--2" v-show='isnakalogin()' to="/newcommunity"><v-icon left dark>mdi-plus</v-icon> COMMMUNITY</v-btn>
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
                        <v-badge color="red" overlap avatar bordered>
                            <span slot="badge">{{unreadnotification}}</span>
                            <cld-image :publicId="photo" width="50">
                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>  
                            </cld-image>
                        </v-badge>
                        <!-- <v-avatar> -->
                        <!-- </v-avatar> -->
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
                    <v-list-item ripple="ripple" @click="openNotif()">
                        <v-list-item-avatar>
                            <v-badge color="red" overlap avatar bordered>
                                <span slot="badge">{{unreadnotification}}</span>
                                 <v-avatar size="40">
                                    <v-icon class="teal lighten-2 white--text">mdi-bell</v-icon>
                                </v-avatar>
                            </v-badge>
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
        <v-dialog v-model="Notif_Dialog" width="90vw" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title class="display-1">Notifications</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- <v-icon x-large>information</v-icon> -->
                </v-toolbar>
                <v-card-text>
                    <v-list dense two-line>
                        <template v-for="(notification,index) in allNotifications" >
                        <v-list-item :key="index">
                            <!-- For Icon -->
                            <v-list-item-avatar size="50" v-if="notification.type == 'App\\Notifications\\NewEvent' || notification.type == 'App\\Notifications\\CallForSpeaker' || notification.type == 'App\\Notifications\\ProofOfPaymentReply'">
                                <!-- New Event -->
                                <!-- <v-icon size="40px" color="success" v-if="notification.type == 'App\\Notifications\\NewEvent'">mdi-calendar-plus</v-icon>
                                <v-icon size="40px" color="success" v-if="notification.type == 'App\\Notifications\\CallForSpeaker'">mdi-microphone-plus</v-icon> -->
                                <v-img :src="notification.data.community_photo"></v-img>
                            </v-list-item-avatar>
                            <cld-image v-else :publicId="notification.data.user_photo" width="50" class="mr-6">
                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                            </cld-image>
                            <!-- Message -->
                            <v-list-item-content>
                            <!-- Message Title -->
                                <!-- New Event -->
                                <v-list-item-title v-if="notification.type == 'App\\Notifications\\NewEvent'">New Event</v-list-item-title>
                                <v-list-item-title v-if="notification.type == 'App\\Notifications\\CallForSpeaker'">Request for Speaker</v-list-item-title>
                                <v-list-item-title v-if="notification.type == 'App\\Notifications\\NewMember'">New Member</v-list-item-title>
                                <v-list-item-title v-if="notification.type == 'App\\Notifications\\NewAttendee'">New Attendee</v-list-item-title>
                                <v-list-item-title v-if="notification.type == 'App\\Notifications\\ProofOfPayment'">Proof Of Payment</v-list-item-title>
                                <v-list-item-title v-if="notification.type == 'App\\Notifications\\ProofOfPaymentReply'">Proof Accepted</v-list-item-title>
                                <!-- Message Content -->
                            <!-- Subtitle -->
                                <!-- New Event -->
                                <v-list-item-subtitle>{{ notification.data.message }}</v-list-item-subtitle>

                            </v-list-item-content>
                            <v-spacer/>
                            <!-- Action/Button -->
                            <v-list-item-action>
                                <!-- Date -->
                                <v-list-item-action-text>{{ notification.created_at | eventDate}}</v-list-item-action-text>
                                <v-layout v-if="notification.type == 'App\\Notifications\\CallForSpeaker'">
                                    <v-chip v-if="notification.data.status == 'pending'" @click="openRequest(notification)" :class="{'mb-2': $vuetify.breakpoint.smAndDown, 'mb-4': $vuetify.breakpoint.mdAndUp}" 
                                        bottom center round 
                                        :small="$vuetify.breakpoint.smAndDown"
                                        outlined fab color="primary">
                                        <v-avatar>
                                            <v-icon>mdi-timer-sand</v-icon>
                                        </v-avatar>
                                        <span>Pending</span>
                                    </v-chip>
                                </v-layout>
                                <v-layout v-if="notification.type == 'App\\Notifications\\ProofOfPayment'">
                                    <v-chip v-if="notification.data.status == 'pending'" @click="openRequest(notification)" :class="{'mb-2': $vuetify.breakpoint.smAndDown, 'mb-4': $vuetify.breakpoint.mdAndUp}" 
                                        bottom center round 
                                        :small="$vuetify.breakpoint.smAndDown"
                                        outlined fab color="primary">
                                        <v-avatar>
                                            <v-icon>mdi-timer-sand</v-icon>
                                        </v-avatar>
                                        <span>Pending</span>
                                    </v-chip>
                                </v-layout>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider :key="notification.id" inset/>
                        </template>
                    </v-list>
                </v-card-text>
                <v-card-actions class="text-center">
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="Request_Dialog" width="400px" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title class="display-1">Request</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- <v-icon x-large>information</v-icon> -->
                </v-toolbar>
                <v-card-text>
                    <v-row>
                        <v-col justify=center cols="6">
                            <v-btn rounded outlined color="success" @click="Request(true)">Accept</v-btn>
                        </v-col>
                        <v-col justify=center cols="6">
                            <v-btn rounded outlined color="error" @click="Request(false)">Decline</v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="text-center">
                </v-card-actions>
            </v-card>
        </v-dialog>
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
            allNotifications: [],
            Notif_Dialog: false,
            Request_Dialog: false,
            notification: '',
        }),
        methods:{
            logout() {
                this.loading = true
                axios.post('/api/logout')   
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
            },
            markAsRead(){
                axios.post('/api/notifications/read')
                .then( response => {
                    this.allNotifications = response.data.success.notifications
                })
                .catch( error => {})
                .finally( x => {
                })
            },
            openNotif(){
                this.Notif_Dialog = true
                this.markAsRead()
            },
            openRequest(notif){
                this.Request_Dialog = true
                this.notification = notif
            },
            Request(status){
                let keychars = "1234567890" //allowed characters for key
                let code = ''
                for(let i=0; i < 8; i++ )
                {
                    code += keychars.charAt(Math.floor(Math.random() * keychars.length))
                }
                axios.post('/api/reply-request/',{
                    notification: this.notification,
                    status: status,
                    code: code
                })
                .then( response => {
                    this.allNotifications = response.data.success.notifications
                })
                .catch( error => {})
                .finally( x => {
                    this.Request_Dialog = false
                    this.Notif_Dialog = false
                })
            },
            getUserGeolocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.setUserGeolocation);
                } else {
                    window.clearInterval(window.locationInterval);
                    alert("Geolocation is not supported by this browser.");
                }
            },
            setUserGeolocation(position) {
                var UserGeolocationLatitude = position.coords.latitude
                var UserGeolocationLongitude = position.coords.longitude
                console.log(UserGeolocationLatitude, UserGeolocationLongitude)
                // axios.put('api/User/' + sessionStorage.getItem('user-id') + '/update-location', {
                //     latitude: UserGeolocationLatitude, longitude: UserGeolocationLongitude,
                // })
                .then( response => { /** console.log(response.data) **/}).catch( error => { toastr.error("An Error Occurred")})
            },
        },
        computed: {
            unreadnotification: function() {
                var count = 0;
                this.allNotifications.filter(function(notification) {
                    if(notification.read_at == null){
                        count++;
                    }
                })
                return count;
            },
            limitedNotifications: function() {
                var allnotif = [];
                this.allNotifications.forEach(notification => {
                if(this.allNotifications.indexOf(notification) <= 10){
                    allnotif.push(notification)
                }
                });
                return allnotif;
            },
        },
        mounted(){
            // this.getUserGeolocation()
            axios.get('/api/notifications')
            .then( response => {
                this.allNotifications = response.data.success.notifications
            })
            .catch( error => {})
        },
        created(){
            // sessionStorage.setItem('user-token', token)
            // sessionStorage.setItem('user-id', '1')
            // sessionStorage.setItem('user-type', 'admin')
            // sessionStorage.setItem('user-avatar', 'phtechpark/profiles/default')
        }
    }
</script>
