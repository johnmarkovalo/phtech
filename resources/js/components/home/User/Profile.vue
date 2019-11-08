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
                       <v-avatar size='130'>
                        <v-expand-transition>
                          <div
                            v-if="hover"
                            :class="{'d-flex transition-fast-in-fast-out grey lighten-5 v-card--reveal headline orange--text': !$vuetify.theme.dark, 
                            'd-flex transition-fast-in-fast-out grey darken-4 v-card--reveal headline orange--text': $vuetify.theme.dark}"
                            style="height: 100%;"
                          >
                            Edit
                          </div>
                        </v-expand-transition>
                        <cld-image :publicId="photo" v-if="photo == avatar">
                          <cld-transformation width="1000" height="1000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="fill"/> 
                          <cld-transformation width="200" crop="scale" />
                        </cld-image>
                        <img :src="photo" alt="Profile" v-if="photo != avatar">
                      </v-avatar>
                    </v-row>
                    <v-row justify=center>
                        <p class="title teal--text text--lighten-2">{{name}}</p>
                    </v-row>
                    <v-row>
                        <p class="title teal--text text--lighten-2">{{bio}}</p>
                    </v-row>
                  </v-card-text>
                </v-card>
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
                          <p class="display-2 font-weight-black">250</p>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col>
                          <a href="asdasasd" class="teal--text text--lighten-2">See points log</a>
                        </v-col>
                      </v-row>
                    </v-card-text>
                  </v-card>
              </v-col>
          </v-row>
      </v-card-text>
    </v-card>
      <v-dialog>
        <v-row justify-center wrap>
          <v-hover v-slot:default="{ hover }">
              <v-card class="elevation-0 transparent" xs12 md4 height="200px">
                <v-flex>
                  <input type="file" id="imgupload" style="display:none" @change="UploadPicture"/>
                  <v-avatar @click.prevent="openFileDialog()" slot="offset" class="mx-auto d-block" size='130'>
                    <v-expand-transition>
                      <div
                        v-if="hover"
                        :class="{'d-flex transition-fast-in-fast-out grey lighten-5 v-card--reveal headline orange--text': !$vuetify.theme.dark, 
                        'd-flex transition-fast-in-fast-out grey darken-4 v-card--reveal headline orange--text': $vuetify.theme.dark}"
                        style="height: 100%;"
                      >
                        Edit
                      </div>
                    </v-expand-transition>
                    <cld-image :publicId="photo" v-if="photo == avatar">
                      <cld-transformation width="1000" height="1000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="fill"/> 
                      <cld-transformation width="200" crop="scale" />
                    </cld-image>
                    <img :src="photo" alt="Profile" v-if="photo != avatar">
                  </v-avatar>
                  <v-card-text class="text-center">
                    <h6 class="title teal--text text--lighten-2 font-weight-regular mb-3">{{name}}</h6>
                  </v-card-text>
                </v-flex>
              </v-card>
          </v-hover>
          <v-col xs12 md8>
            <v-form>
              <v-container py-0>
                  <v-row>
                    <v-col xs12 md6>
                        <v-text-field class="purple-input" id="lname" type="text" label="Last Name" v-model="lastname" required autofocus prepend-inner-icon="mdi-account-circle"/>
                    </v-col>
                    <v-col xs12 md6>
                        <v-text-field class="purple-input" id="fname" type="text" label="First Name" v-model="firstname" required />
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col xs12 md12>
                      <v-text-field label="Email Address" class="purple-input" v-model="email" prepend-inner-icon="mdi-at"/>
                    </v-col>
                  </v-row>
              </v-container>
              <v-container py-0>
                <v-row>
                  <v-col cols=12>
                    <v-row>
                      <v-col cols=12 lg=12>
                        <p class="display-1">Affiliate</p>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols=12 md=6>
                        <v-text-field class="purple-input" type="text" label="Affiliate" v-model="affiliate" required prepend-inner-icon="mdi-account-circle"/>
                      </v-col>
                      <v-col cols=12 md=6>
                        <v-text-field class="purple-input" type="text" label="Position" v-model="position" required />
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col cols=12 md=12>
                        <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.min]" :type="show1 ? 'text' : 'password'" label="Password" hint="At least 8 characters" counter @click:append="show1 = !show1" @keydown.space.prevent prepend-inner-icon="mdi-lock"></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row xs12 text-xs-right >
                      <v-col cols=12>
                        <v-btn class="mx-0 font-weight-light" rounded large color="success" @click="updateUser()">
                          Update Profile
                        </v-btn>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-col>
        </v-row>
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
        lastname: '',
        firstname: '',
        name: '',
        email: '',
        affiliate: '',
        position: '',
        bio: '',
        occupation: '',
        avatar: '',
        photo: sessionStorage.getItem('user-avatar'),
        password: '',
        show1: false,
        photo: '',
        rules: {
          min: v => v.length >= 8 || 'Min 8 characters'
        },
        overlay: false,
        tags: [],
      }
    },
    methods:{
      openFileDialog(){
        $('#imgupload').trigger('click');
      },
      UploadPicture(e){
        let file = e.target.files[0];
        let reader = new FileReader();
        reader.onloadend = (file) => {
          this.photo = reader.result;
        }
        reader.readAsDataURL(file);
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
              console.log(response.data.path)
              console.log(response.data.path)
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
          axios.put('/api/user/', {
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
              console.log(response.data.path)
              console.log(response.data.path)
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
      }
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
        axios.get('api/information', { 
          // params: { user_id: '1', }
        })   
        .then( response => {
          var information = response.data.information
          var tags = response.data.tags
          // Create a local storage item
          this.firstname = information.firstname
          this.lastname = information.lastname
          this.name = information.name
          this.email = information.email
          this.affiliate = information.affiliate
          this.position = information.position
          this.bio = information.bio
          this.occupation = information.occupation
          this.avatar = information.avatar
          this.photo = information.avatar
          console.log(this.tags);
          
        })
        .catch( error => { alert(error)})
        .finally( x => { this.loading = false})
        
        
    }
}
</script>