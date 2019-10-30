<template>
  <v-row>
      <v-col cols=12 md=12 lg=6>
          <v-img :src="community.photo">
          </v-img>
      </v-col>
      <v-col cols=12 md=12 lg=6 >
          <p class="display-1 teal--text text--lighten-2">{{community.name}}</p>
          <p class="title teal--text text--lighten-2"><v-icon color="primary">mdi-map-marker</v-icon>{{community.location}}</p>
          <p class="title teal--text text--lighten-2"><v-icon color="primary">fas fa-user</v-icon>Organizers</p>
          <p class="title teal--text text--lighten-2 ml-5" >{{community.organizer}} and <strong>7 others</strong></p>
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
  </v-row>
</template>
<script>
  export default {
    data: () => ({
      members: [],
      community: {id: '', name: '', photo: '', location: '', organizer: ''},

    }),
    computed: {
        isOrganizer: function () {
            return this.members.position == 'organizer'
        },
        
    },
    mounted () {
        this.retrieveCommunity()
    },
    methods: {
        retrieveMembers() {
           axios.get("/api/community/members",
                {
                    params:{
                        id: this.community.id
                    }
                })
                .then(response => {
                    // this.members = response.data.members
                    // console.log(this.members);
                    
                })
                .catch( error => { alert(error)})
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
                        organizer: response.data.community.organizer,
                        location: response.data.community.location.formatted_address,
                    }
                    this.members = response.data.members
                })
                .catch( error => { alert(error)})
            }
        },
        
    },
    created() {

    },
  }
</script>