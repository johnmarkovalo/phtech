<template>
  <v-layout row>
      <v-flex col-12 >
          <v-card class="elevation-0 transparent">
            <!-- Header -->
              <v-toolbar class="elevation-0 transparent">
                <v-icon color="primary" x-large>event</v-icon>
                <v-toolbar-title class="display-2">events</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <!-- Favor me el condition na mga type -->
                <!-- For Diamond -->
                <v-layout>

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
      console.log(localStorage.getItem('user-id'));
      
    }
}
</script>
