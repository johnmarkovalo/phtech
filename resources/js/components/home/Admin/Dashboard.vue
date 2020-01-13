<template>
  <v-layout row>
      <v-flex col-12 >
          <v-card class="elevation-0 transparent">
            <!-- Header -->
              <v-toolbar class="elevation-0 transparent">
                <v-icon color="primary" x-large>mdi-view-dashboard</v-icon>
                <v-toolbar-title class="display-1">Dashboard</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <!-- Favor me el condition na mga type -->
                <!-- For Diamond -->
                <v-layout>
                  <v-flex xs12>
                    <v-container grid-list-xl>
                        <v-layout row wrap align-start>
                            <v-flex xs12 lg6 xl4>
                              <v-card color="teal darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text text-center">{{users}}</p>
                                  <p class="title  white--text text-center">Users</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex xs12 lg6 xl4>
                              <v-card color="cyan darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text text-center">{{points}}</p>
                                  <p class="title  white--text text-center">Points Gathered</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex xs12 lg12 xl4>
                              <v-card color="teal darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text text-center">{{communities}}</p>
                                  <p class="title  white--text text-center">Communities</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <!-- Bottom -->
                    <v-container grid-list-xl>
                        <v-layout row wrap align-start>
                            <v-flex xs12 md6>
                              <v-card color="red darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text text-center">{{events.upcomming}}</p>
                                  <p class="title  white--text text-center">Past Events</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex xs12 md6>
                              <v-card color="green darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text text-center">{{events.past}}</p>
                                  <p class="title  white--text text-center">Upcomming Events</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                  </v-flex>
                </v-layout>
              </v-card-text>
          </v-card>
      </v-flex>
  </v-layout>
</template>

<script src="/js/app.js"></script>
<script>
  export default {
    data(){
      return {
        events: [],
        communities: '',
        points: '',
        users: '',
      }
    },
    methods:{
      getDashboard(){
        axios.get('/api/dashboard')
        .then( response => {
            this.events = response.data.events
            this.users = response.data.users
            this.communities = response.data.communities
            this.points = response.data.points
        })
        .catch( error => { alert(error)})
        .finally( x => {
          console.log(this.communities);
        })
      }
    },
    created() {
      this.getDashboard()
    }
}
</script>
