<template>
    <v-container fluid>
        <v-card class="transparent elevation-0">
            <v-card-text>
                <v-row justify=center>
                    <v-col cols=12 md=12 lg=5>
                        <v-row class="">
                            <v-img :src="community.photo" max-width="100%">
                            </v-img>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3>
                        <p class="display-1 teal--text text--lighten-2 font-weight-bold">{{community.name}}</p>
                        <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-map-marker</v-icon>{{community.location}}</p>
                        <p class="title teal--text text--lighten-2"><v-icon color="primary">fas fa-user</v-icon>Organizers</p>
                        <p class="title ml-5" >{{community.organizer}} and <strong>7 others</strong></p>
                        <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-account-group</v-icon> Members</p>
                        <v-row>
                            <v-tooltip top v-for="member in members" :key="member.name">
                                <template v-slot:activator="{ on }">
                                    <v-avatar v-on="on" :class="{'': $vuetify.breakpoint.smAndDown, 'ml-2':$vuetify.breakpoint.mdAndUp}">
                                        <cld-image :publicId="member.avatar" >
                                            <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                            <cld-transformation width="200" crop="scale" />
                                        </cld-image>
                                    </v-avatar>
                                </template>
                                <span>{{member.name}}</span>
                            </v-tooltip>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=2>
                        <v-row>
                            <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-tag-multiple</v-icon>Community Topics/Tags</p>
                            <v-chip-group column>
                                <v-chip v-for="tag in tags"  :key="tag.name" large outlined color="primary">{{tag.name}}</v-chip>
                            </v-chip-group>
                        </v-row>
                        <!-- <v-row class="mt-5">
                            <v-chip class="float-right" rounded outlined color="primary" @click="">Join This Group</v-chip>
                        </v-row> -->
                    </v-col>
                </v-row>
                <v-row justify=center>
                    <v-col cols=12 md=12 lg=5>
                        <v-row class="mt-5">
                             <v-chip-group mandatory active-class="teal--text text--lighten-1">
                                <v-chip color="primary" outlined class="" @click="visit_about(community.name)"><v-icon left>mdi-information</v-icon>About</v-chip>
                                <v-chip color="primary" outlined class="" @click="visit_events(community.name)"><v-icon left>mdi-calendar</v-icon>Events</v-chip>
                                <v-chip color="primary" outlined class="" @click="visit_members(community.name)"><v-icon left>mdi-account-group</v-icon>Members</v-chip>
                                <v-chip color="primary" outlined class="" @click="visit_news(community.name)"><v-icon left>mdi-newspaper</v-icon>News</v-chip>
                            </v-chip-group>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=5>
                        <v-row class="mt-5" justify=center>
                            <v-col cols=6 lg=5>
                                <v-btn v-if="!membership" class="float-right" block rounded large color="primary" @click="joinCommunity()">Join This Group</v-btn>
                                <v-menu v-else transition="slide-y-transition" offset-y :close-on-content-click="false">
                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                        <v-btn class="float-right" v-on="on" block rounded large color="primary">Membership<v-icon right>mdi-chevron-down</v-icon></v-btn>
                                    </template>
                                    <v-list two-line >
                                        <v-list-item v-if="settings" ripple="ripple" @click="">
                                            <v-list-item-avatar>
                                                <v-icon class="teal lighten-2 white--text"
                                                >mdi-setting</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>Manage Roles</v-list-item-title>
                                                <v-list-item-subtitle></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item else ripple="ripple" @click="">
                                            <v-list-item-avatar>
                                                <v-icon class="teal lighten-2 white--text"
                                                >mdi-logout-variant</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>Leave this Community</v-list-item-title>
                                                <v-list-item-subtitle></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <router-view v-bind:community="this.community" v-bind:members="this.members" v-bind:pastevents="this.pastevents"        v-bind:upcommingevents="this.upcommingevents" name="communitydetails"></router-view>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
  export default {
    data: () => ({
      members: [],
      community: {id: '', name: '', photo: '', location: '', organizer: '', description: ''},
      upcommingevents: [],
      pastevents: [],
      tags: [],
      membership: '',
    //   route: community.name.split(' ').join('_'),

    }),
    mounted () {
        this.retrieveCommunity()
    },
    methods: {
        visit_event(community_name,event_code){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
        visit_about(community_name){
            this.$router.push('/'+community_name.split(' ').join('_')+'/about')
        },
        visit_events(community_name){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events')
        },
        visit_members(community_name){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
        visit_news(community_name){
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
                    this.tags = response.data.community.tags
                    this.upcommingevents = response.data.upevents
                    this.pastevents = response.data.pastevents
                    this.membership = response.data.membership
                    
                })
                .catch( error => { alert(error)})
            }
        },
        joinCommunity(){
            axios.put('api/joincommunity', {
                id: this.community.id
            })
            .then( response => {
                this.membership = response.data.joiner.position
                this.members = response.data.members
            })
            .catch( error => { alert(error)})
        },
        
    },
    created() {

    },
  }
</script>