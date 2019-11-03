<template>
    <v-container fluid>
        <v-row>
            <v-col cols=12 md=12 lg=5>
                <v-img :src="community.photo">
                </v-img>
            </v-col>
            <v-col cols=12 md=12 lg=4 >
                <p class="display-1 teal--text text--lighten-2 font-weight-bold">{{community.name}}</p>
                <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-map-marker</v-icon>{{community.location}}</p>
                <p class="title teal--text text--lighten-2"><v-icon color="primary">fas fa-user</v-icon>Organizers</p>
                <p class="title ml-5" >{{community.organizer}} and <strong>7 others</strong></p>
                <p class="title teal--text text--lighten-2"><v-icon color="primary">fas fa-users</v-icon> Members</p>
                <v-row>
                    <v-avatar v-for="member in members" :key="member.name">
                        <cld-image :publicId="member.avatar" >
                            <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                            <cld-transformation width="200" crop="scale" />
                        </cld-image>
                    </v-avatar>
                </v-row>
            </v-col>
            <v-col cols=12 md=12 lg=3 >
                <p class="title teal--text text--lighten-2">About {{community.name}}</p>
                <p :class="{'title text-truncate': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">{{community.description}}</p>
                <a class="title teal--text text--lighten-2 float-right" v-if="$vuetify.breakpoint.smAndDown">See More</a>
            </v-col>
        </v-row>
        <p class="display-1 teal--text text--lighten-2">Upcomming Events:</p>
        <v-row dense>
            <v-col v-for="event in upcommingevents" :key="event.title"
                cols="12" lg="3" xl="3" md="3">
                <v-card @click="visit_event(community.name,event.code)">
                <v-img
                    :src="event.photo"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                    height="200px"
                >
                </v-img>
                <v-card-text> 
                    <p class="title teal--text text--lighten-2">{{event.start | eventDate}}</p>
                    <p class="headline white--text">{{event.title}}</p>
                    <p class="subtitle-1">{{event.location.formatted_address}}</p>
                    <v-chip v-for="item in event.community" v-bind:key="item.id" color="primary" outlined>
                        <v-icon left>
                        fas fa-users
                        </v-icon>
                        {{item['name']}}
                    </v-chip>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn icon>
                    <v-icon>mdi-heart</v-icon>
                    </v-btn>

                    <v-btn icon>
                    <v-icon>mdi-bookmark</v-icon>
                    </v-btn>

                    <v-btn icon>
                    <v-icon>mdi-share-variant</v-icon>
                    </v-btn>
                </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <p class="display-1 teal--text text--lighten-2">Past Events:</p>
        <v-row dense>
            <v-col v-for="event in pastevents" :key="event.title"
                cols="12" lg="3" xl="3" md="3">
                <v-card @click="visit_event(community.name,event.code)">
                <v-img
                    :src="event.photo"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                    height="200px"
                >
                </v-img>
                <v-card-text> 
                    <p class="title teal--text text--lighten-2">{{event.start | eventDate}}</p>
                    <p class="headline white--text">{{event.title}}</p>
                    <p class="subtitle-1">{{event.location.formatted_address}}</p>
                    <v-chip v-for="item in event.community" v-bind:key="item.id" color="primary" outlined>
                        <v-icon left>
                        fas fa-users
                        </v-icon>
                        {{item['name']}}
                    </v-chip>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn outlined rounded medium>
                        attend
                    </v-btn>
                </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
  export default {
    data: () => ({
      members: [],
      community: {id: '', name: '', photo: '', location: '', organizer: '', description: ''},
      upcommingevents: [],
      pastevents: [],

    }),
    mounted () {
        this.retrieveCommunity()
    },
    methods: {
        visit_event(community_name,event_code){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
        retrieveCommunity(){
            {
                axios.get("/api/community/"+this.$route.params.community_name.split('_').join(' '),
                {
                    params:{
                        name: this.$route.params.community_name.split('_').join(' ')
                    }
                })
                .then(response => {
                    this.community = {
                        id: response.data.community.id,
                        name: response.data.community.name,
                        photo: response.data.community.photo,
                        description: response.data.community.description,
                        organizer: response.data.community.organizer,
                        location: response.data.community.location.formatted_address,
                    }
                    this.members = response.data.members
                    this.upcommingevents = response.data.upevents
                    this.pastevents = response.data.pastevents
                    
                })
                .catch( error => { alert(error)})
            }
        },
        
    },
    created() {

    },
  }
</script>