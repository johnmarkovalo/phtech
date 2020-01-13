<template>
    <div class="container fluid">
        <v-row justify="center" align="center">
            <v-col xs="12" md="10" lg="10" justify="center" align="center">
                <v-card width="90vw" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title class="display-1">Community Setup</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <!-- <v-icon x-large>information</v-icon> -->
                    </v-toolbar>
                    <v-card-text>
                      <v-stepper v-model="e1" class="transparent elevation-0">
                        <v-stepper-header class="elevation-0">
                          <v-stepper-step :complete="e1 > 1" step="1">Community Location</v-stepper-step>

                          <v-divider></v-divider>

                          <v-stepper-step :complete="e1 > 2" step="2">Technology Tags</v-stepper-step>

                          <v-divider></v-divider>

                          <v-stepper-step :complete="e1 > 3" step="3">Community Name</v-stepper-step>

                          <v-divider></v-divider>

                          <v-stepper-step :complete="e1 > 4" step="4">Community Description</v-stepper-step>

                          <v-divider></v-divider>

                          <v-stepper-step step="5">Community Guidlines</v-stepper-step>
                        </v-stepper-header>

                        <v-stepper-items>
                          <v-stepper-content step="1">
                            <v-container>
                                <p class="display-2 teal--text text--darken-2">First, set your community's location.</p>
                                <p class="title">Community groups meet locally and in person. We’ll connect you with people who live in and around your area.</p>
                                <v-layout row wrap>
                                    <!-- Company -->
                                    <v-flex xs12 md12>
                                        <!-- <v-text-field outlined type="text" label="Company" v-model="address" required autofocus prepend-inner-icon="location_on">
                                        </v-text-field> -->
                                        <h2>Search and add a pin</h2>
                                        <v-layout row justify-center align-center>
                                            <v-icon medium color="primary">mdi-map-marker</v-icon>
                                            <h2 class="teal--text text--darken-2">
                                                <gmap-autocomplete
                                                @place_changed="setPlace" :rules="Required">
                                                </gmap-autocomplete>
                                            </h2>
                                        </v-layout>
                                        <v-layout>
                                            <GmapMap style="width: 100%; height: 500px;" :zoom="25" :center="center" 
                                                     >
                                            <GmapMarker
                                                v-if="this.address"
                                                label="★"
                                                :draggable="true"
                                                :position="center"
                                                />
                                            </GmapMap>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-btn text>Cancel</v-btn>
                            <v-btn x-large rounded color="primary" @click="e1 = 2">
                                Continue
                            </v-btn>
                          </v-stepper-content>

                          <v-stepper-content step="2">
                            <v-container>
                                <p class="display-2 teal--text text--darken-2">Choose a few technology tags that describe your community's interests</p>
                                <p class="title">Be specific! This will help us promote your community to the right people.</p>
                                <v-layout row wrap>
                                    <form v-on:submit.prevent="">
                                        <v-autocomplete v-model="selected" :disabled="isUpdating" :items="tags"
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
                                </v-layout>
                            </v-container>
                            <v-btn text @click="e1 = 1">Cancel</v-btn>
                            <v-btn x-large rounded color="primary" @click="e1 = 3">
                                Continue
                            </v-btn>
                          </v-stepper-content>

                          <v-stepper-content step="3">
                            <v-container>
                                <p class="display-2 teal--text text--darken-2">What is the name of your Community?</p>
                                <p class="title">Be creative! Name your community that will stand out from the others.</p>
                                <v-form ref="form1" lazy-validation>
                                    <v-layout row wrap>
                                        <!-- Company -->
                                        <v-flex xs12 md12>
                                            <v-text-field outlined type="text" label="Community Name" v-model="name" :rules="Required" prepend-inner-icon="mdi-account-group"/>
                                        </v-flex>
                                    </v-layout>
                                </v-form>
                            </v-container>

                            <v-btn text @click="e1 = 2">Cancel</v-btn>
                            <v-btn x-large rounded color="primary" @click="Validate(1)">
                                Continue
                            </v-btn>
                          </v-stepper-content>

                          <v-stepper-content step="4">
                            <v-container>
                                <p class="display-2 teal--text text--darken-2">What is your community all about?</p>
                                <p class="title">This will help people to know what is your community. <br>
                                                    1.What's the purpose of the group?<br>
                                                    2.Who should join?<br>
                                                    3.What will you do at your events? <br>  
                                                    </p>
                                <v-form ref="form2" lazy-validation>
                                    <v-layout row wrap>
                                        <!-- Company -->
                                        <v-flex xs12 md12>
                                            <v-textarea outlined type="text" label="Community Name" v-model="description" :rules="Required"/>
                                        </v-flex>
                                    </v-layout>
                                </v-form>
                            </v-container>
                            <v-btn text @click="e1 = 3">Cancel</v-btn>

                            <v-btn x-large rounded color="primary" @click="Validate(2)">
                                Continue
                            </v-btn>

                          </v-stepper-content>

                          <v-stepper-content step="5">
                            <v-container>
                                <p class="display-2 teal--text text--darken-2">Please Read the Community Guidlines</p>
                                <a class="subtitile-2 teal--text text--darken-2">Guidlines</a>
                            </v-container>

                            <v-btn text @click="e1 = 4">Cancel</v-btn>
                            <v-btn x-large rounded :loading="loading" color="primary" @click="SaveCommunity()">
                                Save Community
                            </v-btn>
                          </v-stepper-content>
                        </v-stepper-items>
                      </v-stepper>  
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            e1: 0,
            loading: false,
            name: '',
            markers: [],
            address: null,
            currentPlace: null,
            description: '',
            center: { lat: 6.903975099999999 , lng: 122.07619890000001 },
            tags: [],
            rules: [v => !!v || "The input is required"],
            autoUpdate: true,
            selected: [],
            isUpdating: false,
            searchInput: null,
            newTags: [],
            Required: [
                (v) => !!v || 'Field is required',
                (v) => !!v && v.length <= 255 || 'Field must be more than 255 characters',
            ],
        }
    },
     mounted() {
        this.retrieveTags()
    },
    watch: {
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 3000)
        }
      },
    },
    
    methods: {
        remove (item) {
            const index = this.selected.indexOf(item.name)
            if (index >= 0) this.selected.splice(index, 1)
        },
        AddTag(item){

            let newItem = { name: this.searchInput };
            this.tags.push(newItem);
            this.selected.push(newItem);
            this.newTags.push(newItem);
            
        },
        setPlace(place) {
            this.address = place;
            this.center = {
                lat: this.address.geometry.location.lat(),
                lng: this.address.geometry.location.lng()
            };
            this.address = {
                lat: this.address.geometry.location.lat(),
                lng: this.address.geometry.location.lng(),
                name: this.address.name,
                formatted_address: this.address.formatted_address,
            }
            // console.log(this.address);
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
        SaveCommunity(){
            this.loading = true
            // Create Community
            axios.post('/api/community' , { 
                name: this.name, 
                description: this.description, 
                location: this.address, 
                organizer_id: sessionStorage.getItem('user-id')
            })
            .then( response => { 
                if(this.newTags != null){
                    this.SaveNewTechnology()
                }
                var id = response.data.community.id
                var community = response.data.community.name
                axios.put('/api/communitytech/' + id, { 
                    id: id,
                    tags: this.selected
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
                    this.$router.push('/'+community.split(' ').join('_')+'/about')
                })
            })
            .catch( error => { alert(error)})
        },
        SaveNewTechnology(){
            axios.put('/api/newtechnology', { 
                    newTags: this.newTags
                })   
                .then( response => { 
                })
                .catch( error => { alert(error)})
        },
        Validate(number){
            if(number == 1){
                 if (this.$refs.form1.validate()) {
                    this.e1 = 4;
                 }
            }
            else if(number == 2){
                if (this.$refs.form2.validate()) {
                    this.e1 = 5;
                }
            }
        },
    },
}
</script>
