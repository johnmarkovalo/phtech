<template>
    <div class="container fluid">
        <v-row justify="center" align="center">
            <v-col xs="12" md="10" lg="10" justify="center" align="center">
                <v-card width="90vw" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title class="display-1">Event Setup</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <!-- <v-icon x-large>information</v-icon> -->
                    </v-toolbar>
                    <v-card-text>
                        <v-container grid-list-xl v-if="true">
                            <v-form ref="form1" lazy-validation>
                                <p class="title teal--text text--darken-2">Event Title</p>                            
                                <v-row>
                                    <v-col cols=12 md=12 lg=12 xl=12>
                                        <v-text-field outlined type="text" label="Event Title" v-model="title" :rules="Required" prepend-inner-icon="mdi-calendar"/>
                                    </v-col>
                                    <!-- <v-col cols=12 md=12 lg=6 xl=6>
                                        <v-text-field outlined name="name" label="label"/>
                                    </v-col> -->
                                </v-row>
                                <p class="title teal--text text--darken-2">Event Start</p>
                                <v-row>
                                    <v-col cols=12 md=12 lg=6 xl=6>
                                        <v-dialog
                                            ref="dialog"
                                            v-model="modal"
                                            :return-value.sync="start.date"
                                            persistent
                                            width="290px"
                                        >
                                            <template v-slot:activator="{ on }">
                                            <v-text-field outlined
                                                v-model="start.date"
                                                label="Event Date"
                                                prepend-inner-icon="mdi-calendar"
                                                readonly
                                                v-on="on"
                                                :rules="Required"
                                            ></v-text-field>
                                            </template>
                                            <v-date-picker :allowedDates="allowedDatesStart" v-model="start.date" @change="startChange()" color="primary" scrollable>
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary" @click="modal = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.dialog.save(start.date)">OK</v-btn>
                                            </v-date-picker>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols=12 md=12 lg=6 xl=6>
                                        <v-dialog
                                            ref="dialog2"
                                            v-model="modal2"
                                            :return-value.sync="start.time"
                                            persistent
                                            width="290px"
                                        >
                                            <template v-slot:activator="{ on }">
                                            <v-text-field outlined
                                                v-model="start.time"
                                                label="Event Time"
                                                prepend-inner-icon="mdi-alarm"
                                                readonly
                                                v-on="on"
                                                :rules="Required"
                                            ></v-text-field>
                                            </template>
                                            <v-time-picker color="primary"
                                            v-if="modal2"
                                            v-model="start.time"
                                            full-width
                                            >
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="modal2 = false">Cancel</v-btn>
                                            <v-btn text color="primary" @click="$refs.dialog2.save(start.time)">OK</v-btn>
                                            </v-time-picker>
                                        </v-dialog>
                                    </v-col>
                                </v-row>
                                <p class="title teal--text text--darken-2">Event End</p>
                                <v-row>
                                    <v-col cols=12 md=12 lg=6 xl=6>
                                        <v-dialog ref="dialog3" v-model="modal3" :return-value.sync="end.date"
                                                    persistent width="290px">
                                            <template v-slot:activator="{ on }">
                                                <v-text-field outlined v-model="end.date" label="Event Date" prepend-inner-icon="mdi-calendar" readonly v-on="on" :rules="Required"></v-text-field>
                                            </template>
                                            <v-date-picker :allowedDates="allowedDatesEnd"  v-model="end.date" color="primary" scrollable>
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary" @click="modal3 = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.dialog3.save(end.date)">OK</v-btn>
                                            </v-date-picker>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols=12 md=12 lg=6 xl=6>
                                        <v-dialog ref="dialog4" v-model="modal4" :return-value.sync="end.time"
                                            persistent width="290px">
                                            <template v-slot:activator="{ on }">
                                                <v-text-field outlined v-model="end.time" label="Event Time" prepend-inner-icon="mdi-alarm" readonly v-on="on" :rules="Required"></v-text-field>
                                            </template>
                                            <v-time-picker color="primary" v-if="modal4" v-model="end.time" full-width>
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary" @click="modal4 = false">Cancel</v-btn>
                                                <v-btn text color="primary" @click="$refs.dialog4.save(end.time)">OK</v-btn>
                                            </v-time-picker>
                                        </v-dialog>
                                    </v-col>
                                </v-row>
                                <p class="title teal--text text--darken-2">Event Description</p>                            
                                <v-row>
                                    <v-col cols=12 md=12 lg=12 xl=12>
                                        <v-text-field outlined type="text" label="Event Description" v-model="description" :rules="Required" prepend-inner-icon="mdi-calendar"/>
                                    </v-col>
                                </v-row>                   
                                <p class="title teal--text text--darken-2">Event Topic</p>
                                <v-row>
                                    <v-col cols=12 md=12 lg=12 xl=12>
                                        <form v-on:submit.prevent="">
                                            <v-autocomplete v-model="selectedTags" :disabled="isUpdating" :items="tags"
                                                filled chips color="primary" label="Select Technology tags"
                                                :search-input.sync="searchInput" rounded
                                                item-text="name" item-value="name" multiple dense mandatory>
                                                <template v-slot:selection="data">
                                                    <v-chip
                                                    v-bind="data.attrs"
                                                    :input-value="data.selected"
                                                    close
                                                    @click="data.select"
                                                    @click:close="removeTag(data.item)"
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
                                    </v-col>
                                </v-row>
                                <p class="title teal--text text--darken-2">Event Location</p>
                                <v-row>
                                    <v-col cols=12 md=12 lg=12 xl=12>
                                        <v-row>
                                            <v-icon medium color="primary">mdi-map-marker</v-icon>
                                            <h2 class="teal--text text--darken-2">
                                                <gmap-autocomplete
                                                @place_changed="setPlace">
                                                </gmap-autocomplete>
                                            </h2>
                                        </v-row>
                                        <GmapMap style="width: 100%; height: 400px;" :zoom="25" :center="center" 
                                                    >
                                            <GmapMarker v-if="this.address" label="★" :draggable="true" :position="center"/>
                                        </GmapMap>
                                    </v-col>
                                </v-row>
                            </v-form>
                            <p class="headline font-weight-bold teal--text text--darken-2">Optional Settings</p>
                            <v-row>
                                <v-expansion-panels popout>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="teal--text text--darken-2">Partner Community</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="title teal--text text--darken-2">Partner Community</p>                            
                                            <v-row>
                                                <v-col cols=12 md=12 lg=12 xl=12>
                                                    <v-select multiple color="primary" v-model="selectedPartners" :items="communityUnder" outlined chips label="Community"  prepend-inner-icon="mdi-account-group"/>
                                                </v-col>
                                            </v-row>   
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="teal--text text--darken-2">Event Speaker</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="title teal--text text--darken-2">Event Speaker</p>
                                            <v-row>
                                                <v-col cols=12 md=12 lg=12 xl=12>
                                                    <form v-on:submit.prevent="">
                                                        <v-autocomplete v-model="selectedSpeakers" :disabled="isUpdating" :items="users"
                                                            filled chips color="primary" label="Select Speakers"
                                                            :search-input.sync="searchInput" rounded
                                                            item-text="name" item-value="id" multiple dense>
                                                            <template v-slot:selection="data">
                                                                <v-chip v-bind="data.attrs" :input-value="data.selectedSpeakers" close @click="data.select"
                                                                    @click:close="remove(data.item)">
                                                                    <cld-image :publicId="data.item.avatar" width="30" class="mr-2">
                                                                        <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                                                    </cld-image>
                                                                    {{ data.item.name }}
                                                                </v-chip>
                                                            </template>
                                                            <template v-slot:item="data">
                                                                <template v-if="typeof data.item !== 'object'">
                                                                    <v-list-item-content v-text="data.item"></v-list-item-content>
                                                                </template>
                                                                <template v-else>
                                                                <v-list-item-content>
                                                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                                </v-list-item-content>
                                                                </template>
                                                            </template>
                                                        </v-autocomplete>
                                                        <button v-show="false" type="submit" @click="AddSpeaker()">Submit</button>
                                                    </form>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="teal--text text--darken-2">Attendee Limit</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="title teal--text text--darken-2">Attendee Limit</p>
                                            <v-row>
                                                <v-col cols=12 md=6 lg=4 xl=4>
                                                    <v-text-field outlined v-model="attendeeLimit" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="teal--text text--darken-2">Exclusive For Community</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="title teal--text text--darken-2">Exclusive</p>
                                            <v-row>
                                                <v-col cols=12 md=6 lg=4 xl=4>
                                                    <v-switch v-model="exclusive" class="mx-2"></v-switch>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                     <v-expansion-panel>
                                        <v-expansion-panel-header class="teal--text text--darken-2">Event Fee</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="title teal--text text--darken-2">Event Fee</p>
                                            <v-row>
                                                <v-col cols=12 md=6 lg=4 xl=4>
                                                    <v-text-field outlined v-model="fee" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header class="teal--text text--darken-2">Event Sponsors</v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                            <p class="title teal--text text--darken-2">Event Sponsors</p>
                                            <v-row>
                                                <v-col cols=12 md=12 lg=12 xl=12>
                                                    <form v-on:submit.prevent="">
                                                        <v-autocomplete v-model="selectedSponsors" :disabled="isUpdating" :items="sponsorsdiila"
                                                            filled chips color="primary" label="Select Sponsors"
                                                            :search-input.sync="searchInput" rounded
                                                            item-text="name" item-value="name" multiple dense>
                                                            <template v-slot:selection="data">
                                                                <v-chip
                                                                v-bind="data.attrs"
                                                                :input-value="data.selected"
                                                                close
                                                                @click="data.select"
                                                                @click:close="removeSponsor(data.item)"
                                                                >
                                                                {{ data.item.name }}
                                                                </v-chip>
                                                            </template>
                                                            <template v-slot:item="data">
                                                                
                                                                <template v-if="typeof data.item !== 'object'">
                                                                <v-list-item-content v-text="data.item"></v-list-item-content>
                                                                </template>
                                                                <template v-else>
                                                                <v-list-item-content>
                                                                    <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                                </v-list-item-content>
                                                                </template>
                                                            </template>
                                                        </v-autocomplete>
                                                        <button v-show="false" type="submit" @click="AddSponsor()">Submit</button>
                                                    </form>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </v-row>
                        </v-container>
                        <v-btn color="primary" outlined rounded x-large >Cancel</v-btn>
                        <v-btn color="primary" rounded x-large @click="SaveEvent()">Save Event</v-btn>
                    </v-card-text>
                    <v-card-actions class="text-center">
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            start:{
                date: new Date().toISOString().substr(0, 10), time: null
            },
            end:{
                date: new Date().toISOString().substr(0, 10), time: null
            },
            modal: false,
            modal2: false,
            modal3: false,
            modal4: false,
            e1: 0,
            loading: false,
            title: '',
            markers: [],
            address: null,
            users: [],
            community: this.$route.params.community_name.split('_').join(' '),
            communityUnder: [],
            communities: [],
            currentPlace: null,
            description: '',
            center: { lat: 6.903975099999999 , lng: 122.07619890000001 },
            tags: [],
            newTags: [],
            rules: [v => !!v || "The input is required"],
            autoUpdate: true,
            selectedTags: [],
            isUpdating: false,
            searchInput: '',
            sponsorsdiila: [], 
            //Optional Settings
            selectedPartners: [],
            selectedSpeakers: [],
            selectedSponsors: [],
            attendeeLimit: 0,
            exclusive: false,
            fee: 0,
            Required: [
                (v) => !!v || 'Field is required',
                (v) => !!v && v.length <= 255 || 'Field must be more than 255 characters',
            ],
        }
    },
     mounted() {
        this.retrieveTags()
        this.retrieveUsers()
        this.retrieveCommunityUnder()
        this.retrieveCommunitySponsors()
    },
    watch: {
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 3000)
        }
      },
    },
    computed:{
        allowedDatesStart () {
            return (another => val => val >= another)(new Date().toISOString().substr(0, 10))
        },
        allowedDatesEnd () {
            return (another => val => val >= another)(this.start.date)
        }
    },
    methods: {
        removeTag (item) {
            const index = this.selectedTags.indexOf(item.name)
            if (index >= 0) this.selectedTags.splice(index, 1)
        },
        AddTag(item){

            let newItem = { name: this.searchInput };
            this.tags.push(newItem);
            this.selectedTags.push(newItem);
            this.newTags.push(newItem);
            
        },
        removeSponsor (item) {
            const index = this.selectedSponsors.indexOf(item.name)
            if (index >= 0) this.selectedSponsors.splice(index, 1)
        },
        AddSponsor(item){
            let newItem = { name: this.searchInput };
            this.sponsorsdiila.push(newItem);
            this.selectedSponsors.push(newItem);
        },
        removeSpeaker (item) {
            const index = this.selectedSpeakers.indexOf(item.name)
            if (index >= 0) this.selectedSpeakers.splice(index, 1)
        },
        AddSpeaker(item){
            let newItem = { name: this.searchInput };
            this.users.push(newItem);
            this.selectedSpeakers.push(newItem);
            
        },
        startChange(){
            this.end.date = this.start.date
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
        retrieveUsers() {
            this.loading = true
            axios.get('/api/users')
            .then( response => {
                this.users = response.data.users
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },
        retrieveCommunityUnder() {
            this.loading = true
            axios.get('/api/community-under',{
                params:{
                    community: this.community
                }
            })
            .then( response => {
                this.communityUnder = response.data.community
                
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },
        retrieveCommunitySponsors(){
            axios.get('/api/community-sponsor',{
                params:{
                    community: this.community
                }
            })
            .then( response => {
                this.sponsorsdiila = response.data.sponsors
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },
        SaveNewTechnology(){
            axios.put('/api/newtechnology', { 
                    newTags: this.newTags
                })   
                .then( response => { 
                })
                .catch( error => { alert(error)})
        },
        SaveEvent() {
            if(this.$refs.form1.validate() && this.address != null && this.selectedTags != ''){
                this.loading = true
                if(this.newTags != null){
                    this.SaveNewTechnology()
                }
                let keychars = "1234567890" //allowed characters for key
                let code = ''
                for(let i=0; i < 11; i++ )
                {
                    code += keychars.charAt(Math.floor(Math.random() * keychars.length))
                }
                // Create Event
                axios.post('/api/create_event' , { 
                    code: code, 
                    title: this.title, 
                    description: this.description, 
                    location: this.address, 
                    start: this.start.date + ' '+this.start.time, 
                    end: this.end.date + ' '+this.end.time,
                    organizer_id: sessionStorage.getItem('user-id'),
                    //Optional Settings
                    partners: this.selectedPartners,
                    // speakers: this.selectedSpeakers,
                    limit: this.attendeeLimit,
                    exclusive: this.exclusive,
                    fee: this.fee,
                    sponsors: this.sponsors,
    
                })
                .then( response => { 
                    var id = response.data.event.id
                    axios.put('/api/eventtech/' + id, { 
                        id: id,
                        tags: this.selectedTags
                    })
                    .then( response => {
                        axios.put('/api/eventcommunity/' + id, { 
                            id: id,
                            status: 'New',
                            community: this.community,
                            partners: this.selectedPartners,
                            speakers: this.selectedSpeakers,
                            sponsors: this.sponsorsdiila,
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
                            this.$router.push('/'+this.community.split(' ').join('_')+'/'+'events/'+code)
                        })
                        .catch( error => { alert(error)})
                    })
                    .catch( error => { alert(error)})
                })
                .catch( error => { alert(error)})
                .finally( x => { 
                    this.loading = false
                })
            }
            else{
                 swal.fire(
                    'Error!',
                    'Please Fill-up all the required field',
                    'error'
                )
            }
        },
    },
}
</script>
