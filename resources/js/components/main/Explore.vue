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
                <v-row justify="start" align="center">
                  <v-col cols="6">
                    <v-text-field outlined type="text" placeholder="Search Event..." v-model="search" prepend-inner-icon="fas fa-search"/>
                  </v-col>
                  <v-col cols="6">
                   <v-select dense color="primary" v-model="location" :items="select_options" label="Location" prepend-inner-icon="mdi-map-marker"/>
                  </v-col>
                </v-row>
                <v-card-text>
                  <v-container fluid>
                      <v-row dense>
                        <v-col v-for="card in filteredList" :key="card.title" cols="12" lg="3" xl="3" md="3">
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
      recommended_events: [],
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
      UserLocation: {
        lat:'',
        lng:''
      },
      search: '',
      select_options: ['Anywhere','Within 50km near your location'],
      location: 'Anywhere',
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
      filteredList() {
        if(this.search == '' && this.recommended_events == ''){
          if(this.location == 'Anywhere'){
            return this.events
          }
          else{
            var eventsforfilter = [];
            this.events.forEach(event => {
              var km = this.calculate_distance(this.UserLocation.lat,this.UserLocation.lng,event.location.lat,event.location.lng);
              if(km <= 50){
                eventsforfilter.push(event);
              }
            });
            return eventsforfilter;
          }
        }
        else if(this.search == '' && this.recommended_events != ''){
          if(this.location == 'Anywhere'){
            return this.recommended_events
          }
          else{
            var eventsforfilter = [];
            this.recommended_events.forEach(event => {
              var km = this.calculate_distance(this.UserLocation.lat,this.UserLocation.lng,event.location.lat,event.location.lng);
              if(km <= 50){
                eventsforfilter.push(event);
              }
            });
            return eventsforfilter;
          }
        }
        else{
          if(this.location == 'Anywhere'){
            var events=[];
            if(this.search.includes('#')){
              this.events.forEach(event => {
                var done = false;
                event.tags.forEach(tag => {
                  if(done == false){
                    if(tag['name'].toLowerCase().includes(this.search.substring(1).toLowerCase())){
                      events.push(event);
                      done = true;
                    }
                  }
                });
              })
              return events;
            }
            else{
              return this.events.filter(event => {
                return event.name.toLowerCase().includes(this.search.toLowerCase())
              })
            }
          }
          else{
            var events=[];
            if(this.search.includes('#')){
              this.events.forEach(event => {
                var done = false;
                event.tags.forEach(tag => {
                  if(done == false){
                    if(tag['name'].toLowerCase().includes(this.search.substring(1).toLowerCase())){
                      events.push(event);
                      done = true;
                    }
                  }
                });
              })
              var eventsforfilter = [];
              events.forEach(event => {
                var km = this.calculate_distance(this.UserLocation.lat,this.UserLocation.lng,event.location.lat,event.location.lng);
                if(km <= 50){
                  eventsforfilter.push(event);
                }
              });
              return eventsforfilter;
            }
            else{
              var events = this.events.filter(event => {
                return event.name.toLowerCase().includes(this.search.toLowerCase())
              });
              var eventsforfilter = [];
              events.forEach(event => {
                var km = this.calculate_distance(this.UserLocation.lat,this.UserLocation.lng,event.location.lat,event.location.lng);
                if(km <= 50){
                  eventsforfilter.push(event);
                }
              });
              return eventsforfilter;
            }
          }
        }
      }
    },
    mounted () {
      
    },
    methods: {
      retrieveEvent(){
          axios.get('/api/event' ,
          {
            params: {
              id: sessionStorage.getItem('user-id'),
            }
          })
          .then( response => {
              this.events = response.data.events
              this.recommended_events = response.data.recommended_events
          })
          .catch( error => { alert(error)})
      },
      visit_event(community_name,event_code){
          this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
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
          this.UserLocation = {
            lat: UserGeolocationLatitude,
            lng: UserGeolocationLongitude
          }
      },
      radians(degrees) {
        return degrees * Math.PI / 180;
      },
      calculate_distance(user_lat, user_lng, event_lat, event_lng){
        // A FUNCTION THAT COMPUTES THE DISTANCE BETWEEN THE user AND event

        var R = 6371000.0 //approximate radius of earth in meters

        // user Latitude and Longitude
        var lat_1 = this.radians(user_lat)
        var lon_1 = this.radians(user_lng)
        // event Latitude and Longitude
        var lat_2 = this.radians(event_lat)
        var lon_2 = this.radians(event_lng)

        // user and event difference
        var d_lon = lon_2 - lon_1
        var d_lat = lat_2 - lat_1

        // This is where the magic happens!
        var a = Math.sin(d_lat / 2)**2 + Math.cos(lat_1) * Math.cos(lat_2) * Math.sin(d_lon / 2)**2
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a))

        var distance = R * c // Distance between user and event

        var km = Math.round(distance/1000, 1)

        console.log(km);
        return km;
      },
      FilterByDistance(){
        if(this.location == 'Anywhere'){
          this.eventsforfilter = this.events
        }
        else{
          this.events.forEach(event => {
            var km = this.calculate_distance(this.UserLocation.lat,this.UserLocation.lng,event.location.lat,event.location.lng);
            if(km <= 50){
              this.eventsforfilter = [];
              this.eventsforfilter.push(event);
            }
          });
        }
      }

    },
    created() {
      this.getUserGeolocation()
      this.retrieveTags();
      this.retrieveEvent();
      // this.focus = new Date().toLocaleString();
    },
  }
</script>