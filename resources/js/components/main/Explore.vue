<template>
  <v-layout row>
      <v-flex col-12 >
        <v-card class="mt-1 elevation-0">
          <v-toolbar color="primary">
            <v-toolbar-title class="display-1 white--text">Find events you're interested with</v-toolbar-title>
            <!-- <v-icon x-large>information</v-icon> -->
          </v-toolbar>
          <v-card-text>
            <v-card class="mt-5 elevation-0">
                <v-toolbar flat align="center">
                  <v-icon medium color="primary">fas fa-search</v-icon>
                </v-toolbar>
                <v-card-text>
                  <v-container fluid>
                      <v-row dense>
                        <v-col v-for="card in events" :key="card.title" cols="12" lg="3" xl="3" md="3">
                          <v-hover v-slot:default="{ hover }">
                            <v-card :elevation="hover ? 12 : 2" @click="visit_event(card.community['0'].name,card.code)">
                              <v-img :src="card.photo" class=" align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px">
                              </v-img>
                              <v-card-text> 
                                <p class="title teal--text text--darken-2">{{card.start | eventDate}}</p>
                                <p class="headline ">{{card.name}}</p>
                                <p class="subtitle-1 teal--text text--darken-2">{{card.community_organizer}}</p>
                                <p class="subtitle-2">{{card.location.formatted_address}}</p>
                                <v-chip v-for="item in card.tags" v-bind:key="item.id" color="primary" outlined>
                                    <v-icon left>
                                      mdi-pound
                                    </v-icon>
                                    {{item['name']}}
                                  </v-chip>
                              </v-card-text>

                              <v-card-actions>
                                <v-spacer></v-spacer>

                                <v-btn v-if="card.position == 'pending'" rounded outlined color="primary" width="5vw" >Attend</v-btn>
                                <v-btn v-else-if="card.position == 'going' || card.position == 'organizer'" rounded outlined color="success" width="5vw">Going</v-btn>
                                <v-btn v-else-if="card.position == 'notgoing'" rounded outlined color="error" width="5vw">Not Going</v-btn>
                              </v-card-actions>
                            </v-card>
                          </v-hover>
                        </v-col>
                      </v-row>
                  </v-container>
                </v-card-text>
              </v-card>
            </v-card-text>
        </v-card>
      </v-flex>
  </v-layout>
</template>
<script>
  export default {
    data: () => ({
      events: [],
      tags: [],
      selected: [],
      modal: false,
      focus: null,
      type: 'month',
      start: null,
      end: null,
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
    }),
    computed: {
      eventRecommended: function() {
          return this.events.filter(function(event) {
              event.tags.forEach(function(tag) {
                if(tag.name == 'going' || tag.name == 'organizer' || tag.name == 'went'){
                    return event
                }
              })
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
      
    },
    methods: {
      visit_event(community_name,event_code){
          this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
      },
      retrieveEvent(){
          axios.get('/api/event' ,
          {
            params: {
              id: sessionStorage.getItem('user-id'),
            }
          })
          .then( response => {
              this.events = response.data.event
          })
          .catch( error => { alert(error)})
      },
      retrieveTags() {
          axios.get('/api/technology')
          .then( response => {
              this.tags = response.data.tags
          })
          .catch( error => { alert(error)})
      },
      visit_community(community_name){
          this.$router.push('/community/'+community_name.split(' ').join('_'))
      },
      remove (item) {
          const index = this.selected.indexOf(item.name)
          if (index >= 0) this.selected.splice(index, 1)
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
    created() {
      this.getUserGeolocation()
      this.retrieveTags();
      this.retrieveEvent();
      // this.focus = new Date().toLocaleString();
    },
  }
</script>