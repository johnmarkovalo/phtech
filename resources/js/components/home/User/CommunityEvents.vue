<template>
    <div>
        <v-row justify=center>
            <v-col cols=12 lg=10>
                <p class="display-1 teal--text text--darken-2">Upcomming Events:</p>
            </v-col>
        </v-row>
        <v-row dense justify=center>
            <v-col cols="12" lg=10>
                <v-row>
                    <v-col v-for="event in upcommingevents" :key="event.title"
                        cols="12" lg="3" xl="3" md="3">
                        <v-hover v-slot:default="{ hover }">
                        <v-card :elevation="hover ? 12 : 2" @click="visit_event(community.name,event.code)">
                            <v-img :src="event.photo" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px">
                            </v-img>
                            <v-card-text> 
                                <p class="title teal--text text--darken-2">{{event.start | eventDate}}</p>
                                <p class="headline">{{event.title}}</p>
                                <p class="subtitle-1 teal--text text--darken-2">{{event.community_organizer}}</p>
                                <p class="subtitle-1 text-truncate">{{event.location.formatted_address}}</p>
                                <v-chip-group row>
                                    <v-chip small v-for="item in event.tags" v-bind:key="item.id" color="primary" outlined>
                                        <v-icon small left>
                                        mdi-pound
                                        </v-icon>
                                        {{item['name']}}
                                    </v-chip>
                                </v-chip-group>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-chip v-if="event.position == 'going' || event.position == 'organizer'" rounded outlined medium color="success" @click="visit_event(community.name,event.code)"><v-icon>mdi-check</v-icon>Going</v-chip>
                                <v-chip v-else-if="event.position == 'notgoing'" rounded outlined medium color="error" @click="visit_event(community.name,event.code)"><v-icon>mdi-ex</v-icon>NotGoing</v-chip>
                                <v-chip v-else rounded outlined medium color="primary" @click="visit_event(community.name,event.code)">Attend</v-chip>
                            </v-card-actions>
                        </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row justify=center>
            <v-col cols=12 lg=10>
                <p class="display-1 teal--text text--darken-2">Past Events:</p>
            </v-col>
        </v-row>
        <v-row dense justify=center>
            <v-col cols="12" lg=10>
                <v-row>
                    <v-col v-for="event in pastevents" :key="event.title"
                        cols="12" lg="3" xl="3" md="3">
                        <v-hover v-slot:default="{ hover }">
                        <v-card :elevation="hover ? 12 : 2" >
                            <v-img :src="event.photo" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px">
                            </v-img>
                            <v-card-text> 
                                <p class="title teal--text text--darken-2">{{event.start | eventDate}}</p>
                                <p class="headline">{{event.title}}</p>
                                <p class="subtitle-1 teal--text text--darken-2">{{event.community_organizer}}</p>
                                <p class="subtitle-1 text-truncate">{{event.location.formatted_address}}</p>
                                 <v-chip-group row>
                                    <v-chip small v-for="item in event.tags" v-bind:key="item.id" color="primary" outlined>
                                        <v-icon small left>
                                        mdi-pound
                                        </v-icon>
                                        {{item['name']}}
                                    </v-chip>
                                </v-chip-group>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-chip v-if="event.position == 'went'" rounded outlined medium color="success" @click="visit_event(community.name,event.code)"><v-icon>mdi-check</v-icon>Went</v-chip>
                                <v-chip v-else-if="event.position == 'absent'" rounded outlined medium color="warning" @click="visit_event(community.name,event.code)"><v-icon>mdi-check</v-icon>Didn't Go</v-chip>
                                <v-chip v-else rounded outlined medium color="primary" @click="visit_event(community.name,event.code)"><v-icon>mdi-eye</v-icon>See</v-chip>
                            </v-card-actions>
                        </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </div>
</template>
<script>
  export default {
    props: [
        'upcommingevents',
        'pastevents',
        'community'
    ],
    methods: {
        visit_event(community_name,event_code){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
    }
  }
</script>