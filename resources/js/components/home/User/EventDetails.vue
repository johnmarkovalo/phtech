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
                    <v-col cols=12 md=12 lg=3>
                        <v-row>
                            <p class="display-1 teal--text text--lighten-2 font-weight-bold">Want to go?</p>
                        </v-row>
                        <v-row justify=center>
                            <v-col cols=4>
                                <v-btn class="white--text" color="primary" large rounded block @click="joinEvent()"><v-icon>mdi-check</v-icon></v-btn>
                            </v-col>
                            <v-col cols=4>
                                <v-btn class="white--text" color="primary" large rounded block @click="CancelEvent()"><v-icon>mdi-close</v-icon></v-btn>
                            </v-col>
                        </v-row>
                        <!-- Icons -->
                        <v-row justify=center>
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
                            <v-col v-for="attendee in attendees" :key="attendee.name"
                                    cols=6 md=6 lg=3 xl=3>
                                <v-card>
                                    <v-card-text class="text-center">
                                        <v-avatar>
                                            <cld-image :publicId="attendee.avatar" >
                                                <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                                <cld-transformation width="400" crop="scale" />
                                            </cld-image>
                                        </v-avatar>
                                        <p class="caption">{{attendee.name}}</p>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3 :class="{'': $vuetify.breakpoint.smAndDown, 'ml-3':$vuetify.breakpoint.mdAndUp}">
                        <v-row>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" rounded medium>Organizer Settings<v-icon right>mdi-chevron-down</v-icon></v-btn>
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
                            <p class="title teal--text text--lighten-2"><v-icon color="primary">fas fa-tags</v-icon>Community Topics/Tags</p>
                            <v-chip-group column>
                                <v-chip v-for="tag in tags"  :key="tag.name" large outlined color="primary">{{tag.name}}</v-chip>
                            </v-chip-group>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <!-- <v-row class="evelevation-5">
            <v-col cols=12 md=12 lg=7>
                <v-row>
                    <v-col cols="12">
                        <p class="display-2 teal--text text--lighten-2 font-weight-bold">{{event.title}}</p>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="3" lg=1>
                        <v-avatar size="5em">
                            <cld-image :publicId="event.organizer.avatar" >
                                <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                <cld-transformation width="400" crop="scale" />
                            </cld-image>
                        </v-avatar>
                    </v-col>
                    <v-col cols="9" lg=11>
                        <p :class="{'caption': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">Created by <strong class="teal--text text--lighten-2">{{event.organizer.name}}</strong></p>
                        <p :class="{'caption': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">Hosted by <strong class="teal--text text--lighten-2">{{communities['0'].name}}</strong></p>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols=12 md=12 lg=5>
                <v-row>
                    <p class="title teal--text text--lighten-2 font-weight-bold">Want to go?</p>
                </v-row>
                <v-row>
                    <v-col cols=6 lg=2 justify-center>
                        <v-btn class="white--text" color="primary" medium rounded block><v-icon>mdi-check</v-icon></v-btn>
                    </v-col>
                    <v-col cols=6 lg=2 justify-center>
                        <v-btn class="white--text" color="primary" medium rounded block><v-icon>mdi-check</v-icon></v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row> -->
        <!-- <v-row>
            <v-col cols="12" lg="6" xl="6" md="6">
                <p class="display-1 teal--text text--lighten-2 font-weight-bold">Attendees</p>
                <v-col v-for="attendee in attendees" :key="attendee.name"
                        cols=6 md=6 lg=3 xl=3>
                    <v-card>
                        <v-card-text class="text-center">
                            <v-avatar>
                                <cld-image :publicId="attendee.avatar" >
                                    <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                    <cld-transformation width="400" crop="scale" />
                                </cld-image>
                            </v-avatar>
                            <p class="caption">{{attendee.name}}</p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-col>
            <v-col cols="12" lg="6" xl="6" md="6">
               <v-row>
               </v-row>
               <v-row>

               </v-row>
            </v-col>
        </v-row> -->
    </v-container>
</template>
<script>
  export default {
    data: () => ({
        center: { lat: 6.903975099999999 , lng: 122.07619890000001 },
        attendees: [],
        event: {id: '', start: '', title: '', photo: '', location: '', organizer: '', description: ''},
        communities: [{name:''}],
        location: {},
        tags: [],
    }),
    computed: {
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
                    console.log(this.location);
                    
                })
                .catch( error => { alert(error)})
            }
        },
        
    },
    created() {

    },
  }
</script>