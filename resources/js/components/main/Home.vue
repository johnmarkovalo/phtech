<template>
    <div>
      <v-navigation-drawer v-if="type == 'admin'" width="250" clipped fixed app>
        <v-list rounded>
          <!-- Start Navigation List -->
          <v-list-item-group color="primary" class="mt-12 pt-12">
             <v-list-item ripple="ripple" exact to="dashboard">
              <v-list-item-action>
                <v-icon>dashboard</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Dashboard
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="technologies">
              <v-list-item-action>
                <v-icon>fas fa-tags</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Technologies
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="events">
              <v-list-item-action>
                <v-icon>event</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Events</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="">
              <v-list-item-action>
                <v-icon>account_circle</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Users</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="">
              <v-list-item-action>
                <v-icon>group</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Communities</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="">
              <v-list-item-action>
                <v-icon>fas fa-award</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Top Members</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
        <!-- End Navigation List -->        
      </v-navigation-drawer>
      <v-content>
        <v-container class="fill-height" fluid>
          <!-- <v-layout> -->
            <!-- <v-flex> -->
              <router-view name="home"></router-view>
            <!-- </v-flex> -->
          <!-- </v-layout> -->
        </v-container>
      </v-content>
    </div>
</template>

<script src="/js/app.js"></script>
<script>
  export default {
    data(){
      return {
        type: null
      }
    },
    computed: {
    },
    methods:{
    },
    created() {
      this.type = (localStorage.getItem('user-type'));
    },
    beforeRouteEnter (to, from, next) { 
        if (!localStorage.getItem('user-id')) {
            return next('signin');
        }

        next();
    }
}
</script>
