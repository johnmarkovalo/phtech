<template>
    <v-container fluid>
        <v-card class="transparent elevation-0">
            <v-card-text>
                <!-- Header -->
                <v-row justify=center>
                    <v-col cols=12 md=12 lg=4>
                        <v-row>
                            <v-col cols="12">
                                <p class="subtitle-1 teal--text text--lighten-2 font-weight-bold">{{event.start | eventDate}}</p>
                                <p class="display-2 teal--text text--lighten-2 font-weight-bold">{{event.title}}</p>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols=3 lg=2>
                                <v-avatar size="5em">
                                    <cld-image :publicId="event.organizer.avatar" >
                                        <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                        <cld-transformation width="400" crop="scale" />
                                    </cld-image>
                                </v-avatar>
                            </v-col>
                            <v-col cols=9 lg=10>
                                <p :class="{'caption': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">Created by <strong class="teal--text text--lighten-2">{{event.organizer.name}}</strong></p>
                                <p :class="{'caption': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">Hosted by <strong class="teal--text text--lighten-2">{{communities[0].name}}</strong></p>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3 align=center>
                        <v-row  v-if="upcomming">
                            <p v-if="this.status == 'pending'" class="display-1 teal--text text--lighten-2 font-weight-bold">Want to go?</p>
                            <p v-if="this.status == 'going' || this.status == 'organizer'" class="display-1 teal--text text--lighten-2 font-weight-bold">You're Going</p>
                            <p v-if="this.status == 'notgoing'" class="display-1 teal--text text--lighten-2 font-weight-bold">You're not Going</p>
                        </v-row>
                        <v-row justify=center  v-if="upcomming">
                            <v-col cols=4>
                                <v-btn class="white--text" color="primary" :outlined="coutlined()" large rounded block @click="joinEvent(user_id,true)"><v-icon>mdi-check</v-icon></v-btn>
                            </v-col>
                            <v-col cols=4>
                                <v-btn class="white--text" color="primary" :outlined="xoutlined()" large rounded block @click="joinEvent(user_id,false)"><v-icon>mdi-close</v-icon></v-btn>
                            </v-col>
                        </v-row>
                        <v-row  v-if="!upcomming">
                            <p class="display-1 teal--text text--lighten-2 font-weight-bold">Event Rating</p>
                        </v-row>
                        <v-row justify=center  v-if="!upcomming">
                            <v-rating size="50" v-model="ratings" background-color="teal lighten-3"  color="teal"></v-rating>
                        </v-row>
                        <!-- Icons -->
                        <v-row justify=center  v-if="upcomming">
                            <v-btn icon>
                                    <v-icon color=white
                                    >mdi-facebook</v-icon>
                            </v-btn>
                            <v-btn icon>
                                    <v-icon color=white
                                    >mdi-twitter</v-icon>
                            </v-btn>
                            <v-btn icon>
                                    <v-icon color=white
                                    >mdi-instagram</v-icon>
                            </v-btn>
                            <v-btn icon>
                                    <v-icon color=white
                                    >mdi-linkedin</v-icon>
                            </v-btn>
                        </v-row>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <!-- Image and Google Map -->
                <v-row justify=center max-height="320px">
                    <v-col cols=12 md=12 lg=4>
                        <!-- Image -->
                        <v-row>
                            <v-img :src="event.photo" >
                            </v-img>
                        </v-row>
                        <!-- Details -->
                        <v-row>
                            <p class="display-1 teal--text text--lighten-2 font-weight-bold">Details</p>
                        </v-row>
                        <v-row>
                            <p class="title">{{event.description}}</p>
                        </v-row>
                        <!-- Attendees -->
                        <v-row>
                            <p class="display-1 teal--text text--lighten-2 font-weight-bold">Attendees</p>
                        </v-row>
                        <v-row>
                            <v-tooltip top v-for="attendee in GoingAttendee" :key="attendee.name">
                                <template v-slot:activator="{ on }">
                                    <v-avatar v-on="on" :class="{'': $vuetify.breakpoint.smAndDown, 'ml-2':$vuetify.breakpoint.mdAndUp}">
                                        <cld-image :publicId="attendee.avatar" >
                                            <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                            <cld-transformation width="200" crop="scale" />
                                        </cld-image>
                                    </v-avatar>
                                </template>
                                <span>{{attendee.name}}</span>
                            </v-tooltip>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3 :class="{'': $vuetify.breakpoint.smAndDown, 'ml-3':$vuetify.breakpoint.mdAndUp}">
                        <v-row>
                            <v-spacer></v-spacer>
                            <v-menu transition="slide-y-transition" offset-y nudge-width="200px" :close-on-content-click="false">
                                <template v-slot:activator="{ on }" :close-on-click="false">
                                    <v-btn rounded medium color="primary" v-on="on"  v-if='organizer()'>
                                    Organizer Settings<v-icon right>mdi-chevron-down</v-icon>
                                    </v-btn>
                                </template>
                                <v-list two-line>
                                    <v-list-item ripple="ripple" @click="dialog = true">
                                        <v-list-item-avatar>
                                            <v-icon class="teal lighten-2 white--text"
                                            >mdi-account-circle</v-icon>
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <v-list-item-title>Attendees</v-list-item-title>
                                            <v-list-item-subtitle>Manange Attendees</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-row>
                        <v-row>
                            <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-alarm</v-icon>{{event.start | eventDate}}</p>
                        </v-row>
                         <v-row>
                            <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-map-marker</v-icon>{{event.location}}</p>
                        </v-row>
                        <!-- Maps -->
                        <v-row>
                            <GmapMap style="width: 100%; height: 300px;" :zoom="25" :center="location" 
                                        map-type-id="terrain">
                                <GmapMarker 
                                    v-if="this.location"
                                    label="★"
                                    :draggable="true"
                                    :position="location"
                                    />
                            </GmapMap>
                        </v-row>
                        <!-- Tags -->
                        <v-row>
                            <v-col>
                                <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-tag-multiple</v-icon>Community Topics/Tags</p>
                                <v-chip-group column>
                                    <v-chip v-for="tag in tags"  :key="tag.name" large outlined color="primary">{{tag.name}}</v-chip>
                                </v-chip-group>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <v-toolbar-title color="primary">Attendee</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon color="primary" @click="dialog = false"><v-icon>mdi-close</v-icon></v-btn>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols=12 lg-10>
                            <v-tabs color="primary">
                                 <!-- Tab for Did -->
                                <v-tab  v-if="upcomming" href="#tab-1">
                                    Going
                                </v-tab>

                                <v-tab  v-else href="#tab-1">
                                    Went
                                </v-tab>
                                
                                <!-- Tab for Not/Didn't go -->
                                <v-tab v-if="upcomming" href="#tab-2">
                                    Not Going
                                </v-tab>
                                <v-tab v-else href="#tab-2">
                                    Not Going
                                </v-tab>
                                <v-tab-item :value="'tab-' + 1">
                                    <v-list two-line>
                                        <v-list-item v-for="attendee in GoingAttendee" :key="attendee.name">
                                            <v-list-item-avatar>
                                                <cld-image :publicId="attendee.avatar" >
                                                    <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                                    <cld-transformation width="200" crop="scale" />
                                                </cld-image>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>{{attendee.name}}</v-list-item-title>
                                                <v-list-item-subtitle>{{attendee.created_at | eventDate}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                                        <v-btn icon color="primary" v-on="on">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <v-list two-line>
                                                        <v-list-item v-if="upcomming" ripple="ripple" @click="joinEvent(attendee.id,false)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Not Going"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                        <v-list-item v-else ripple="ripple" @click="joinEvent(attendee.id,false)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Didn't Going"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-tab-item>

                                <v-tab-item :value="'tab-' + 2">
                                    <v-list two-line>
                                        <v-list-item v-for="attendee in NotGoingAttendee" :key="attendee.name">
                                            <v-list-item-avatar>
                                                <cld-image :publicId="attendee.avatar" >
                                                    <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                                    <cld-transformation width="200" crop="scale" />
                                                </cld-image>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>{{attendee.name}}</v-list-item-title>
                                                <v-list-item-subtitle>{{attendee.created_at | eventDate}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                                        <v-btn icon color="primary" v-on="on">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <v-list two-line>
                                                        <v-list-item v-if="upcomming" ripple="ripple" @click="joinEvent(attendee.id,true)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Going"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                        <v-list-item v-else ripple="ripple" @click="joinEvent(attendee.id,true)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Went"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-tab-item>
                            </v-tabs>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
  export default {
    data: () => ({
        user_id: sessionStorage.getItem('user-id'),
        center: { lat: 6.903975099999999 , lng: 122.07619890000001 },
        attendees: [],
        status: '',
        settings: null,
        event: {id: '', start: '', title: '', photo: '', location: '', organizer: '', description: ''},
        communities: [{name:''}],
        location: {},
        tags: [],
        dialog: false,
        upcomming: null,
        ratings: '4',
    }),
    computed: {
        GoingAttendee: function() {
            return this.attendees.filter(function(attendee) {
                if(attendee.position == 'going' || attendee.position == 'organizer' || attendee.position == 'went'){
                    return attendee
                }
            })
        },
        NotGoingAttendee: function() {
            return this.attendees.filter(function(attendee) {
                if(attendee.position == 'notgoing' || attendee.position == 'absent'){
                    return attendee
                }
            })
        },
    },
    mounted () {
        this.retrieveEvent()
    },
    methods: {
        retrieveEvent(){
            {
                axios.get("/api/event/"+this.$route.params.event_code ,
                {
                    params:{
                        code: this.$route.params.event_code
                    }
                })
                .then(response => {
                    this.event = {
                        id: response.data.event.id,
                        title: response.data.event.title,
                        photo: response.data.event.photo,
                        start: response.data.event.start,
                        description: response.data.event.description,
                        organizer: response.data.event.organizer,
                        location: response.data.event.location.formatted_address,
                    }
                    this.location = { lat: response.data.event.location.lat, lng: response.data.event.location.lng }
                    this.attendees = response.data.attendees
                    this.communities = response.data.communities
                    this.tags = response.data.tags
                    this.status = response.data.status
                    this.settings = response.data.event.settings
                    this.upcomming = response.data.event.upcomming
                })
                .catch( error => { alert(error)})
            }
        },
        coutlined(){
            if(this.status == 'pending') {
                return false
            }
            else if(this.status == 'going' || this.status == 'organizer'){
                return false
            }
            else{
                return true
            }
        },
        xoutlined(){
            if(this.status == 'pending') {
                return false
            }
            else if(this.status == 'going' || this.status == 'organizer'){
                return true
            }
            else{
                return false
            }
        },
        organizer(){
            if(this.settings == false) {
                return false
            }
            else{
                return true
            }
        },
        joinEvent(attendee,status){
            {
                axios.put("/api/joinevent" ,{
                    id: this.event.id,
                    attendee_id: attendee,
                    status: status,
                    upcomming: this.upcomming,
                })
                .then(response => {
                    if(!this.settings){
                        this.status = response.data.attendee.position
                    }
                    this.attendees = response.data.attendees
                })
                .catch( error => { alert(error)})
            }
        },
    },
    created() {

    },
  }
</script>