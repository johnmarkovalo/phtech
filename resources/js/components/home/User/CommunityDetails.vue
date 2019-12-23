<template>
    <v-container fluid>
        <v-card class="transparent elevation-0">
            <v-card-text>
                <v-row justify=center>
                    <v-col cols=12 md=12 lg=5>
                        <v-row>
                            <v-hover v-if="membership == 'organizer'" v-slot:default="{ hover }">
                                <v-img :src="community.photo" max-width="100%">
                                    <v-expand-transition>
                                        <div v-if="hover"
                                        :class="hover ? 'd-flex transition-fast-in-fast-out grey lighten-2 v-card--reveal headline teal--text' : ''"
                                        style="height: 100%;" >
                                        <v-btn class="float-right" icon @click="Cover_Dialog = true"><v-icon color="primary">mdi-pen</v-icon></v-btn>
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                            </v-hover>
                            <v-img v-else :src="community.photo" max-width="100%">
                            </v-img>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3>
                        <p class="display-1 teal--text text--darken-2 font-weight-bold">{{community.name}}</p>
                        <p class="title teal--text text--darken-2"><v-icon color="primary">mdi-map-marker</v-icon>{{community.location.formatted_address}}</p>
                        <p class="title teal--text text--darken-2"><v-icon color="primary">fas fa-user</v-icon>Organizers</p>
                        <p class="title ml-5" >{{community.organizer}} and <strong>7 others</strong></p>
                        <p class="title teal--text text--darken-2"><v-icon color="primary">mdi-account-group</v-icon> Members</p>
                        <v-row>
                            <v-tooltip top v-for="member in members" :key="member.name">
                                <template v-slot:activator="{ on }">
                                    <div v-on="on" :class="{'': $vuetify.breakpoint.smAndDown, 'ml-2':$vuetify.breakpoint.mdAndUp}">
                                        <cld-image :publicId="member.avatar" width="50">
                                            <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>  
                                        </cld-image>
                                    </div>
                                </template>
                                <span>{{member.name}}</span>
                            </v-tooltip>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=2>
                        <v-row>
                            <p class="title teal--text text--darken-2"><v-icon color="primary">mdi-tag-multiple</v-icon>Community Topics/Tags</p>
                            <v-chip-group column>
                                <v-chip v-for="tag in selected"  :key="tag.index" large outlined color="primary">{{tag}}</v-chip>
                            </v-chip-group>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row justify=center>
                    <v-col cols=12 md=12 lg=5>
                        <v-row class="mt-5">
                             <v-chip-group mandatory active-class="teal--text text--lighten-1">
                                <v-chip color="primary" outlined class="" @click="visit(community.name,'/about')"><v-icon left>mdi-information</v-icon>About</v-chip>
                                <v-chip color="primary" outlined class="" @click="visit(community.name,'/events')"><v-icon left>mdi-calendar</v-icon>Events</v-chip>
                                <v-chip color="primary" outlined class="" @click="visit(community.name,'/members')"><v-icon left>mdi-account-group</v-icon>Members</v-chip>
                            </v-chip-group>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=5>
                        <v-row class="mt-5" justify=center>
                            <v-col cols=6 lg=5>
                                <v-menu v-if="membership == 'member' || membership == 'organizer' || membership == 'event-organizer'" transition="slide-y-transition" offset-y :close-on-content-click="false">
                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                        <v-btn class="float-right" v-if="membership == 'member' || membership == 'event-organizer'" v-on="on" block rounded large color="primary">Membership<v-icon right>mdi-chevron-down</v-icon></v-btn>
                                        <v-btn class="float-right" v-else-if="membership == 'organizer'" v-on="on" block rounded large color="primary">Manage Community<v-icon right>mdi-chevron-down</v-icon></v-btn>
                                    </template>
                                    <v-list two-line >
                                        <v-list-item v-if="membership == 'organizer'" ripple="ripple" @click="Roles_Dialog = true">
                                            <v-list-item-avatar>
                                                <v-icon class="teal lighten-2 white--text"
                                                >mdi-shield-account</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>Manage Roles</v-list-item-title>
                                                <v-list-item-subtitle></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-if="membership == 'organizer'" ripple="ripple" @click="Settings_Dialog = true">
                                            <v-list-item-avatar>
                                                <v-icon class="teal lighten-2 white--text"
                                                >mdi-settings</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>Community Settings</v-list-item-title>
                                                <v-list-item-subtitle></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item else ripple="ripple" @click="leave_Community()">
                                            <v-list-item-avatar>
                                                <v-icon class="teal lighten-2 white--text"
                                                >mdi-logout-variant</v-icon>
                                            </v-list-item-avatar>
                                            <v-list-item-content>
                                                <v-list-item-title>Leave this Community</v-list-item-title>
                                                <v-list-item-subtitle></v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                                <v-btn v-else class="float-right" block rounded large color="primary" @click="joinCommunity()">Join This Group</v-btn>
                            </v-col>
                            <v-col cols=6 lg=5>
                                <v-btn v-if="membership == 'organizer' || membership == 'event-organizer'" class="float-right" block rounded large color="primary" to="newevent"><v-icon class="white--text">mdi-calendar-plus</v-icon>Create EVent</v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <router-view v-bind:community="this.community" v-bind:members="this.members" v-bind:pastevents="this.pastevents"        v-bind:upcommingevents="this.upcommingevents" name="communitydetails" v-on="updateCommunity"></router-view>
            </v-card-text>
        </v-card>
        <v-dialog v-model="Cover_Dialog" max-width="400px">
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
                <v-btn rounded color="primary" @click="upload_Cover()">Upload Profile</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="Roles_Dialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <p class="teal--text text--darken-2">Edit Member Roles</p>
                </v-card-title>
                <v-card-text>
                <v-container>
                     <v-row justify="center">
                        <v-expansion-panels popout>
                            <v-expansion-panel>
                                <v-expansion-panel-header>
                                    <p class="teal--text text--darken-2">Co-Organizer</p>
                                </v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-list two-line>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <form v-on:submit.prevent="">
                                                    <v-autocomplete v-model="assigned_Member" :disabled="isUpdating" :items="members"
                                                        filled chips color="primary" label="Add New Organizer"
                                                        :search-input.sync="searchInput" rounded
                                                        item-text="name" item-value="id" dense>
                                                        <template v-slot:selection="data">
                                                            <v-chip
                                                            v-bind="data.attrs"
                                                            :input-value="data.selected"
                                                            @click="data.select"
                                                            >
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
                                                            <cld-image :publicId="data.item.avatar" width="30" class="mr-2">
                                                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                                            </cld-image>
                                                            <v-list-item-content>
                                                                <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                                <!-- <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle> -->
                                                            </v-list-item-content>
                                                            </template>
                                                        </template>
                                                    </v-autocomplete>
                                                    <button v-show="false" type="submit" @click="Assign_Role(assigned_Member,'organizer')">Submit</button>
                                                </form>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-for="member in organizers" :key="member.name">
                                            <cld-image :publicId="member.avatar" width="50" class="mr-2">
                                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                            </cld-image>
                                            <v-list-item-content>
                                                <v-list-item-title>{{member.name}}</v-list-item-title>
                                                <v-list-item-subtitle>{{member.created_at | eventDate}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                                        <v-btn icon color="primary" v-on="on">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <v-list two-line>
                                                        <v-list-item ripple="ripple" @click="RemoveRole(member.id)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Remove As Co-Organizer</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                            <v-expansion-panel>
                                <v-expansion-panel-header class="teal--text text--darken-2">Event Organizer</v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <v-list two-line>
                                        <v-list-item>
                                            <v-list-item-content>
                                                <form v-on:submit.prevent="">
                                                    <v-autocomplete v-model="assigned_Member" :disabled="isUpdating" :items="members"
                                                        filled chips color="primary" label="Add New Organizer"
                                                        :search-input.sync="searchInput" rounded
                                                        item-text="name" item-value="id" dense>
                                                        <template v-slot:selection="data">
                                                            <v-chip
                                                            v-bind="data.attrs"
                                                            :input-value="data.selected"
                                                            @click="data.select"
                                                            >
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
                                                            <cld-image :publicId="data.item.avatar" width="30" class="mr-2">
                                                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                                            </cld-image>
                                                            <v-list-item-content>
                                                                <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                                                <!-- <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle> -->
                                                            </v-list-item-content>
                                                            </template>
                                                        </template>
                                                    </v-autocomplete>
                                                    <button v-show="false" type="submit" @click="Assign_Role(assigned_Member,'event-organizer')">Submit</button>
                                                </form>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item v-for="member in event_ogranizers" :key="member.name">
                                            <cld-image :publicId="member.avatar" width="50" class="mr-2">
                                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                            </cld-image>
                                            <v-list-item-content>
                                                <v-list-item-title>{{member.name}}</v-list-item-title>
                                                <v-list-item-subtitle>{{member.created_at | eventDate}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                                        <v-btn icon color="primary" v-on="on">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <v-list two-line>
                                                        <v-list-item ripple="ripple" @click="RemoveRole(member.id)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Remove As Co-Organizer</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-row>
                </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn rounded color="primary" @click="Roles_Dialog = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="Settings_Dialog" width="90vw" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title class="display-1">Community Settings</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- <v-icon x-large>information</v-icon> -->
                </v-toolbar>
                <v-card-text>
                    <v-container grid-list-xl v-if="true" justify=center>
                        <p class="title teal--text text--darken-2">Community Name</p>                            
                        <v-row>
                            <v-col cols=12 md=12 lg=12 xl=12>
                                <v-text-field outlined type="text" label="Community Name" v-model="community.name" required autofocus prepend-inner-icon="mdi-account-group"/>
                            </v-col>
                            <!-- <v-col cols=12 md=12 lg=6 xl=6>
                                <v-text-field outlined name="name" label="label"/>
                            </v-col> -->
                        </v-row>
                        <p class="title teal--text text--darken-2">Community About</p>                            
                        <v-row>
                            <v-col cols=12 md=12 lg=12 xl=12>
                                <v-textarea outlined type="text" label="Community Description" v-model="community.description" required autofocus prepend-inner-icon="mdi-account-group"/>
                            </v-col>
                        </v-row>    
                        <p class="title teal--text text--darken-2">Community Tags</p>                            
                        <v-row>
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
                        </v-row>                
                        <p class="title teal--text text--darken-2">Community Location</p>
                        <v-row>
                            <!-- Company -->
                            <v-col xs=12 md=12>
                                <!-- <v-text-field outlined type="text" label="Company" v-model="address" required autofocus prepend-inner-icon="location_on">
                                </v-text-field> -->
                                <h2>Search and add a pin</h2>
                                <v-row row justify-center align-center>
                                    <v-icon medium color="primary">mdi-map-marker</v-icon>
                                    <h2 class="teal--text text--darken-2">
                                        <gmap-autocomplete
                                        @place_changed="setPlace">
                                        </gmap-autocomplete>
                                    </h2>
                                </v-row>
                                <v-row>
                                    <GmapMap style="width: 100%; height: 500px;" :zoom="25" :center="center" 
                                                >
                                    <GmapMarker
                                        v-if="community.location"
                                        label="★"
                                        :draggable="true"
                                        :position="center"
                                        />
                                    </GmapMap>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" rounded x-large @click="update_Community()">Save Community</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
  export default {
    data: () => ({
        members: [],
        community: {id: '', name: '', photo: '', location: '', organizer: '', description: '', membership: ''},
        upcommingevents: [],
        pastevents: [],
        membership: '',
        // Photo
        photo_data: null,
        photo_name: null,
        //Tags
        tags: [],
        selected: [],
        isUpdating: false,
        searchInput: null,
        newTags: [],
        //Dialogs
        Cover_Dialog: false,
        Settings_Dialog: false,
        Roles_Dialog: false,
        //Address
        address: null,
        currentPlace: null,
        center: { lat: 6.903975099999999 , lng: 122.07619890000001 },
        //Roles
        assigned_Member: '',

    //   route: community.name.split(' ').join('_'),

    }),
    mounted () {
        this.retrieveCommunity()
        this.retrieveTags()
    },
    computed: {
        organizers: function() {
            return this.members.filter(function(member) {
                if(member.position == 'organizer' || member.position == 'co-organizer'){
                    return member
                }
            })
        },
        event_ogranizers: function() {
            return this.members.filter(function(member) {
                if(member.position == 'event-organizer'){
                    return member
                }
            })
        },
    },
    methods: {
        visit_event(community_name,event_code){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
        visit(community_name,destination){
            this.$router.push('/'+community_name.split(' ').join('_')+destination)
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
                        description: response.data.community.description,
                        organizer: response.data.community.organizer,
                        location: response.data.community.location,
                    }
                    this.members = response.data.members
                    this.selected = response.data.community.tags
                    this.upcommingevents = response.data.upevents
                    this.pastevents = response.data.pastevents
                    this.membership = response.data.membership
                    
                })
                .catch( error => { alert(error)})
            }
        },
        joinCommunity(){
            axios.put('/api/joincommunity', {
                id: this.community.id
            })
            .then( response => {
                this.retrieveCommunity()
            })
            .catch( error => { alert(error)})
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
        upload_Cover(){
            this.$Progress.start();
            axios.put('/api/community/upload-profile/'+this.community.id,{ 
                photo: this.photo_data
            }).then(response => {
                if (response.data.success) {
                    this.$Progress.finish();
                    swal.fire(
                        'Success!',
                        'Successfully Changed Profile Photo',
                        'success'
                    )
                    this.community.photo = response.data.success.photo
                    this.Cover_Dialog = false
                }
                else{
                    this.$Progress.fail();
                }
            }).catch(error => {
                this.$Progress.fail();
            })
        },
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
            this.community.location = place;
            this.center = {
                lat: this.community.location.geometry.location.lat(),
                lng: this.community.location.geometry.location.lng()
            };
            this.community.location = {
                lat: this.community.location.geometry.location.lat(),
                lng: this.community.location.geometry.location.lng(),
                name: this.community.location.name,
                formatted_address: this.community.location.formatted_address,
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
        SaveNewTechnology(){
            axios.put('/api/newtechnology', { 
                    newTags: this.newTags
                })   
                .then( response => { 
                })
                .catch( error => { alert(error)})
        },
        update_Community(){
            this.loading = true
            // Update Community
            axios.put('/api/community/'+ this.community.id, { 
                name: this.community.name, 
                description: this.community.description, 
                location: this.community.location, 
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
                    this.Settings_Dialog = false
                    this.$router.push('/'+community.split(' ').join('_')+'/about')
                    console.log(this.selected);
                    
                })
            })
            .catch( error => { alert(error)})
        },
        Assign_Role(member,role){
            axios.put('/api/community/change-role/'+this.community.id, {
                member: member,
                role: role,
            })
            .then( response => {
                this.assigned_Member = null
                this.members = response.data.members
            })
            .catch( error => { alert(error)})
        },
        leave_Community(){
            axios.put('/api/community/remove-member/'+this.community.id, {
                member: 'leave',
            })
            .then( response => {
                this.retrieveCommunity()
            })
            .catch( error => { alert(error)})
        },
    },
    created() {

    },
  }
</script>