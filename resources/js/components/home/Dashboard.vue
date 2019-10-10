<template>
  <v-layout row>
      <v-flex col-12 >
          <v-card>
            <!-- Header -->
              <v-toolbar color="amber darken-3">
                <v-icon color="white" medium>dashboard</v-icon>
                <v-toolbar-title>Dashboard</v-toolbar-title>
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
                              <v-card color="blue darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text">₱0.00</p>
                                  <p class="title  white--text text-center">Exit Earnings</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex xs12 lg6 xl4>
                              <v-card color="cyan darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text">₱0.00</p>
                                  <p class="title  white--text text-center">Referal Earnings</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex xs12 lg12 xl4>
                              <v-card color="teal darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text">₱0.00</p>
                                  <p class="title  white--text text-center">Total Earnings</p>
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
                                  <p class="display-2 white--text">₱0.00</p>
                                  <p class="title  white--text text-center">Total Encashed</p>
                                  </v-card-text>
                              </v-card>
                            </v-flex>
                            <v-flex xs12 md6>
                              <v-card color="green darken-1">
                                  <v-card-text>
                                  <p class="display-2 white--text">₱0.00</p>
                                  <p class="title  white--text text-center">Available Balance</p>
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
      }
    },
    methods:{
    },
    created() {

    }
}
</script>
