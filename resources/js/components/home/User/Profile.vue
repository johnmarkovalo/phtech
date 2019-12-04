<template>
  <v-container fluid>
  
    <v-card class="transparent elevation-0">
      <v-card-text>
          <v-row justify=center>
              <v-col cols=12 md=12 lg=6>
                <v-card>
                  <v-card-title>
                    <v-spacer></v-spacer>
                    <v-btn icon><v-icon color="primary">mdi-pen</v-icon></v-btn>
                  </v-card-title>
                  <v-card-text>
                    <v-row justify=center>
                      <v-hover>
                        <template v-slot:default="{ hover }">
                            <v-card class="transparent elevation-0">
                              <cld-image :publicId="user.avatar" width="150">
                                  <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>  
                              </cld-image>
                              <v-fade-transition>
                                <v-overlay v-if="hover" color="grey lighten-5" absolute>
                                    <v-btn icon @click="Profile_Dialog = true"><v-icon color="primary">fa-edit</v-icon></v-btn>
                                </v-overlay>
                              </v-fade-transition>
                            </v-card>
                        </template>
                      </v-hover>
                    </v-row>
                    <v-row justify=center>
                        <p class="title teal--text text--darken-2">{{user.name}}</p>
                    </v-row>
                    <v-row>
                        <p class="title teal--text text--darken-2">{{user.bio}}</p>
                    </v-row>
                  </v-card-text>
                </v-card>
                <div class="hidden-sm-and-down">
                  <v-card class="mt-5">
                    <v-card-text>
                      <v-tabs color="primary" icons-and-text>
                        <!-- Tab for List -->
                        <v-tab href="#tab-1">
                            Community
                            <v-icon>mdi-account-group</v-icon>
                        </v-tab>
                        
                        <!-- Tab for Calendar -->
                        <v-tab href="#tab-2">
                            Event
                            <v-icon>mdi-calendar</v-icon>
                        </v-tab>
                        
                        <!-- Tab Value for List -->
                        <v-tab-item :value="'tab-' + 1">
                            <v-row>
                              <p class="display-1 teal--text text-ligthen-2">My Communities</p>
                            </v-row>
                            <v-row justify=start>
                              <v-col v-for="community in communities"  :key="community.name" cols=12 md=6>
                                <v-hover v-slot:default="{ hover }">
                                  <v-card :elevation="hover ? 12 : 2" @click="visit_community(community.name)">
                                    <v-card-text>
                                      <v-row align=center>
                                        <v-col cols="12" md=3>
                                          <v-img :src="community.photo"></v-img>
                                        </v-col>
                                        <v-col cols="12" md=9>
                                          <v-row class="teal--text text--darken-2">
                                            {{community.name}}
                                          </v-row>
                                          <v-row>
                                            {{community.position | upText}}
                                          </v-row>
                                        </v-col>
                                      </v-row>
                                    </v-card-text>
                                  </v-card>
                                </v-hover>
                              </v-col>
                            </v-row>
                        </v-tab-item>
                        <!-- Tab Value for Calendar -->
                        <v-tab-item :value="'tab-' + 2">
                            <v-row>
                              <p class="display-1 teal--text text-ligthen-2">My Events</p>
                            </v-row>
                            <v-row justify=start>
                              <v-col v-for="event in events"  :key="event.title" cols=12 md=6>
                                <v-hover v-slot:default="{ hover }">
                                  <v-card :elevation="hover ? 12 : 2" @click="visit_event(event.community_name,event.code)">
                                    <v-card-text>
                                      <v-row align=center>
                                        <v-col cols="12" md=3>
                                          <v-img :src="event.photo"></v-img>
                                        </v-col>
                                        <v-col cols="12" md=9>
                                          <v-row class="teal--text text--darken-2">
                                            {{event.title}}
                                          </v-row>
                                          <v-row>
                                            {{event.start | eventDate}}
                                          </v-row>
                                        </v-col>
                                      </v-row>
                                    </v-card-text>
                                  </v-card>
                                </v-hover>
                              </v-col>
                            </v-row>
                        </v-tab-item>
                      </v-tabs>
                    </v-card-text>
                  </v-card>
                </div>
              </v-col>
              <v-col cols=12 md=12 lg=2>
                  <v-card>
                    <v-card-text class="text-center">
                      <v-row>
                        <v-col>
                          <p class="display-2 teal--text text-lighten-2">Points</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col>
                          <p class="display-2 font-weight-black">{{user.points}}</p>
                        </v-col>
                      </v-row>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <a href="asdasasd" class="teal--text text--darken-2">See points log</a>
                    </v-card-actions>
                  </v-card>
                  <v-card  class="mt-5">
                    <v-card-text class="text-center">
                      <v-row>
                        <p class="title teal--text text-lighten-2">Technologies Interested</p>
                        <v-btn class="float-right" icon @click="Tags_Dialog = true"><v-icon color="primary">mdi-pen</v-icon></v-btn>
                      </v-row>
                      <v-row>
                        <v-col>
                          <v-chip v-for="tag in selected" :key="tag.index" small outlined color="primary">{{tag}}</v-chip>
                        </v-col>
                      </v-row>
                    </v-card-text>
                  </v-card>
              </v-col>
          </v-row>
          <v-row justify=center>
              <v-col cols=12 md=12 lg=6>
                <div class="hidden-md-and-up">
                  <v-card class="mt-5">
                    <v-card-text>
                      <v-tabs color="primary" icons-and-text>
                        <!-- Tab for List -->
                        <v-tab href="#tab-1">
                            Community
                            <v-icon>mdi-account-group</v-icon>
                        </v-tab>
                        
                        <!-- Tab for Calendar -->
                        <v-tab href="#tab-2">
                            Event
                            <v-icon>mdi-calendar</v-icon>
                        </v-tab>
                        
                        <!-- Tab Value for List -->
                        <v-tab-item :value="'tab-' + 1">
                            <v-row>
                              <p class="display-1 teal--text text-ligthen-2">My Communities</p>
                            </v-row>
                            <v-row justify=start>
                              <v-col v-for="community in communities"  :key="community.name" cols=12 md=6>
                                <v-hover v-slot:default="{ hover }">
                                  <v-card :elevation="hover ? 12 : 2" @click="visit_community(community.name)">
                                    <v-card-text>
                                      <v-row align=center>
                                        <v-col cols="12" md=3>
                                          <v-img :src="community.photo"></v-img>
                                        </v-col>
                                        <v-col cols="12" md=9>
                                          <v-row class="teal--text text--darken-2">
                                            {{community.name}}
                                          </v-row>
                                          <v-row>
                                            {{community.position | upText}}
                                          </v-row>
                                        </v-col>
                                      </v-row>
                                    </v-card-text>
                                  </v-card>
                                </v-hover>
                              </v-col>
                            </v-row>
                        </v-tab-item>
                        <!-- Tab Value for Calendar -->
                        <v-tab-item :value="'tab-' + 2">
                            <v-row>
                              <p class="display-1 teal--text text-ligthen-2">My Events</p>
                            </v-row>
                            <v-row justify=start>
                              <v-col v-for="event in events"  :key="event.title" cols=12 md=6>
                                <v-hover v-slot:default="{ hover }">
                                  <v-card :elevation="hover ? 12 : 2" @click="visit_event(event.community_name,event.code)">
                                    <v-card-text>
                                      <v-row align=center>
                                        <v-col cols="12" md=3>
                                          <v-img :src="event.photo"></v-img>
                                        </v-col>
                                        <v-col cols="12" md=9>
                                          <v-row class="teal--text text--darken-2">
                                            {{event.title}}
                                          </v-row>
                                          <v-row>
                                            {{event.start | eventDate}}
                                          </v-row>
                                        </v-col>
                                      </v-row>
                                    </v-card-text>
                                  </v-card>
                                </v-hover>
                              </v-col>
                            </v-row>
                        </v-tab-item>
                      </v-tabs>
                    </v-card-text>
                  </v-card>
                </div>
              </v-col>
              <v-col cols=12 md=12 lg=2>
              </v-col>
          </v-row>
      </v-card-text>
    </v-card>
    <v-dialog v-model="Profile_Dialog" max-width="400px">
        <v-card>
            <v-card-title >
              Edit Profile Picture
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row wrap justify=center align=center>
                    <v-file-input v-model="photo_name" accept="image/*" placeholder="Profile..." outlined dense prepend-icon="fa-photo" @change="file_upload"/>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn rounded color="primary" @click="Upload_Profile()">Upload Profile</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="Tags_Dialog" max-width="600px">
        <v-card>
            <v-card-title >
              Edit Tags
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row wrap justify=center align=center>
                    <form v-on:submit.prevent="">
                        <v-autocomplete v-model="selected" :items="tags"
                            filled chips color="primary" label="Select Technology tags"
                            :search-input.sync="searchInput" rounded
                            item-text="name" item-value="name" multiple dense>
                            <template v-slot:selection="data">
                                <v-chip
                                v-bind="data.attrs"
                                :input-value="data.selected"
                                close
                                @click="data.select"
                                @click:close="remove(data.item)"
                                >
                                <!-- <v-avatar left>
                                    <v-img :src="data.item.avatar"></v-img>
                                </v-avatar> -->
                                {{ data.item.name }}
                                </v-chip>
                            </template>
                            <template v-slot:item="data">
                                
                                <template v-if="typeof data.item !== 'object'">
                                <v-list-item-content v-text="data.item"></v-list-item-content>
                                </template>
                                <template v-else>
                                <!-- <v-list-item-avatar>
                                    <img :src="data.item.avatar">
                                </v-list-item-avatar> -->
                                <v-list-item-content>
                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                    <!-- <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle> -->
                                </v-list-item-content>
                                </template>
                            </template>
                        </v-autocomplete>
                        <button v-show="false" type="submit" @click="AddTag()">Submit</button>
                      </form>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn rounded color="primary" @click="SaveTechnology()">Update Tags</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
  </v-container>
</template>

<style>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: .5;
  position: absolute;
  width: 100%;
}
</style>

<script>
  export default {
    data(){
      return {
        id: sessionStorage.getItem('user-id'),
        user: {
          lastname: '',
          firstname: '',
          address:'',
          name: '',
          email: '',
          affiliate: '',
          position: '',
          bio: '',
          occupation: '',
          avatar: '',
        },
        // Photo
        photo_data: null,
        photo_name: null,
        Profile_Dialog: false,
        //Tags
        tags: [],
        newTags: [],
        selected: [],
        searchInput: '',
        Tags_Dialog: false,
        communities: [],
        events: [],
        photo: sessionStorage.getItem('user-avatar'),
        password: '',
        show1: false,
        photo: '',
        rules: {
          min: v => v.length >= 8 || 'Min 8 characters'
        },
        overlay: false,
      }
    },
    computed:{
    },
    methods:{
      remove (item) {
          const index = this.selected.indexOf(item)
          if (index >= 0) this.selected.splice(index, 1)
      },
      file_upload() {
          try {
              let reader = new FileReader()
              reader.onload = () => {
                  this.photo_data = reader.result
              }
              reader.readAsDataURL(this.photo_name)
          } catch (error) {
              this.photo_name = null
              this.photo_data = null
          }
      },
      AddTag(item){
        let newItem = { name: this.searchInput };
        this.tags.push(newItem);
        this.selected.push(this.searchInput);
        this.newTags.push(newItem);
          
      },
      Upload_Profile(){
        this.$Progress.start();
        axios.put('/api/information/upload-profile',
          { 
              photo: this.photo_data
          }).then(response => {
              if (response.data.success) {
                  this.$Progress.finish();
                  swal.fire(
                      'Success!',
                      'Successfully Changed Profile Photo',
                      'success'
                  )
                  sessionStorage.setItem('user-avatar',response.data.success.avatar),
                  window.location.reload();
              }
              else{
                this.$Progress.fail();
              }
          }).catch(error => {
              this.$Progress.fail();
          })
      },
      updateUser(){
        let nopic = true
        this.$Progress.start();
        if (this.photo != localStorage.getItem('photo')){
          nopic = false
        }
        if (this.password != ''){
          axios.put('/api/user/', {
            id: this.id,
            name: this.name,
            email: this.email,
            password: this.password,
            photo: this.photo,
            username: this.username,
            lastname: this.lastname,
            firstname: this.firstname,
            mi: this.mi,
            nopic: nopic
          })
          .then(response => {
            if (!nopic){
              localStorage.setItem('photo', response.data.path)
              localStorage.setItem('thisphoto', response.data.path)
            }
            swal.fire({
              allowOutsideClick: false,
              title: 'Updated!',
              text: 'Your user has been updated.',
              type: 'success',
              showCancelButton: false,
              confirmButtonText: 'Okay'
              
            }).then((result)=>{
              if(result.value){
                this.$Progress.finish();
                localStorage.setItem('name', this.name)
                window.location.reload();
              }
            })
          })
        }
        else{
          axios.put('//api/user/', {
            id: this.id,
            name: this.name,
            email: this.email,
            photo: this.photo,
            contact: this.contact,
            address: this.address,
            username: this.username,
            birthdate: this.birthdate,
            lastname: this.lastname,
            firstname: this.firstname,
            mi: this.mi,
            nopic: nopic
          })
          .then(response => {
            if (!nopic){
              localStorage.setItem('photo', response.data.path)
              localStorage.setItem('thisphoto', response.data.path)
            }

            swal.fire({
              allowOutsideClick: false,
              title: 'Updated!',
              text: 'Your user has been updated.',
              type: 'success',
              showCancelButton: false,
              confirmButtonText: 'Okay'
            }).then((result)=>{
              if(result.value){
                this.$Progress.finish();
                localStorage.setItem('name', this.name)
                window.location.reload();
              }
            })
          })
        }
      },
      SaveNewTechnology(){
          axios.put('/api/newtechnology', { 
                  newTags: this.newTags
              })   
              .then( response => { 
              })
              .catch( error => { alert(error)})
      },
      SaveTechnology(){
          this.loading = true
          if(this.newTags != null){
              this.SaveNewTechnology()
          }
          // Update customer
          axios.put('/api/infotech/' + sessionStorage.getItem('user-id'), { 
              tags: this.selected, user_id: sessionStorage.getItem('user-id')
          })
          .then( response => { 
              swal.fire({
                  position: 'top-end',
                  toast: true,
                  type: 'success',
                  title: 'Successfully Registered',
                  showConfirmButton: false,
                  timer: 1500

              })
          })
          .catch( error => { alert(error)})
          .finally( x => { 
              this.loading = false
              this.Tags_Dialog = false
          })
      },
      getInformation(){
        axios.get('/api/information', { 
          // params: { user_id: '1', }
        })   
        .then( response => {
          this.selected = response.data.tags
          this.user = response.data.information
          this.photo = response.data.information.avatar
          this.communities = response.data.communities
          this.events = response.data.events
        })
        .catch( error => { alert(error)})
        .finally( x => { this.loading = false})
      },
      retrieveTags() {
          this.loading = true
          axios.get('/api/technology')
          .then( response => {
              this.tags = response.data.tags
          })
          .catch( error => { alert(error)})
          .finally( x => {this.loading = false})
      },
      visit_community(community_name){
          this.$router.push('/'+community_name.split(' ').join('_')+'/about')
      },
      visit_event(community_name,event_code){
          this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
      },
    },
    watch:
      {
        firstname: function (val)
        {
            this.name = this.firstname.toUpperCase() + ' ' + this.lastname.toUpperCase()
        },
        lastname: function (val)
        {
            this.name = this.firstname.toUpperCase() + ' ' + this.lastname.toUpperCase()
        },
    },
    created() {
      this.getInformation()
      this.retrieveTags()
    }
}
</script>