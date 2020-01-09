<template>
    <v-container fluid>
        <v-card class="transparent elevation-0">
            <v-card-text>
                <!-- Header -->
                <v-row justify=center>
                    <v-col cols=12 md=12 lg=4>
                        <v-row>
                            <v-col cols="12">
                                <p class="subtitle-1 teal--text text--darken-2 font-weight-bold">{{event.start | eventDate}}</p>
                                <p class="display-2 teal--text text--darken-2 font-weight-bold">{{event.title}}</p>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols=3 lg=2>
                                <cld-image :publicId="event.organizer.avatar" width="100" class="mr-2">
                                    <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                </cld-image>
                            </v-col>
                            <v-col cols=9 lg=10>
                                <p :class="{'caption': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">Created by <strong class="teal--text text--darken-2">{{event.organizer.name}}</strong></p>
                                <p :class="{'caption': $vuetify.breakpoint.smAndDown, 'title': $vuetify.breakpoint.mdAndUp}">Hosted by <strong class="teal--text text--darken-2"><a @click="visit_community(communities[0].name)">{{communities[0].name}}</a></strong></p>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3 align=center>
                        <v-row  v-if="upcomming">
                            <p v-if="this.status == 'pending'" class="display-1 teal--text text--darken-2 font-weight-bold">Want to go?</p>
                            <p v-if="this.status == 'going'" class="display-1 teal--text text--darken-2 font-weight-bold">You're Going</p>
                            <p v-if="this.status == 'notgoing'" class="display-1 teal--text text--darken-2 font-weight-bold">You're not Going</p>
                            <p v-if="this.status == 'speaker'" class="display-1 teal--text text--darken-2 font-weight-bold">You're a Guest Speaker</p>
                            <p v-if="this.status == 'organizer'" class="display-1 teal--text text--darken-2 font-weight-bold">You're a Organizer</p>
                        </v-row>
                        <v-row justify=center  v-if="upcomming">
                            <v-col v-if="event.allowed == true" cols=4>
                                <v-btn class="white--text" color="primary" :outlined="coutlined()" large rounded block @click="joinEvent(user_id,true)"><v-icon>mdi-check</v-icon></v-btn>
                            </v-col>
                            <v-col v-if="event.allowed == true" cols=4>
                                <v-btn class="white--text" color="primary" :outlined="xoutlined()" large rounded block @click="joinEvent(user_id,false)"><v-icon>mdi-close</v-icon></v-btn>
                            </v-col>
                            <v-col v-else cols=6>
                                <h1>Sorry This Event Is Exclusive</h1>
                            </v-col>
                        </v-row>
                        <v-row  v-if="!upcomming">
                            <p class="display-1 teal--text text--darken-2 font-weight-bold">Event Rating</p>
                        </v-row>
                        <v-row justify=center  v-if="!upcomming">
                            <v-rating size="50" v-model="ratings" background-color="teal lighten-3"  color="teal"></v-rating>
                        </v-row>
                        <!-- Icons -->
                        <v-row justify=center  v-if="upcomming">
                            <v-btn icon>
                                    <v-icon>mdi-facebook</v-icon>
                            </v-btn>
                            <v-btn icon>
                                    <v-icon>mdi-twitter</v-icon>
                            </v-btn>
                            <v-btn icon>
                                    <v-icon>mdi-instagram</v-icon>
                            </v-btn>
                            <v-btn icon>
                                    <v-icon>mdi-linkedin</v-icon>
                            </v-btn>
                        </v-row>
                        <!-- Qr Code -->
                        <v-row justify=center  v-if="status == 'organizer' || status == 'speaker' || status == 'going'">
                            <v-col justify=center cols=10>
                                <!-- <p>To view you QR Code Click</p> -->
                                <v-dialog v-model="QrCode_Dialog" width="500">
                                    <template v-slot:activator="{ on }">
                                        <v-btn outlined large rounded v-on="on">Click Me for QR
                                            <v-icon color="primary">fa-qrcode</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-card-text>
                                        <v-img v-bind:src="qrcode"></v-img>
                                    </v-card-text>
                                </v-dialog>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <!-- Image and Google Map -->
                <v-row justify=center max-height="320px">
                    <v-col cols=12 md=12 lg=4>
                        <!-- Image -->
                        <v-row>
                            <v-hover v-if="organizer()" v-slot:default="{ hover }">
                                <v-img v-if="event.photo == ''" src="https://res.cloudinary.com/mactimestwo/image/upload/v1576912557/phtechpark/community/Upload_Photo.png" max-width="100%">
                                    <v-expand-transition>
                                        <div v-if="hover"
                                        :class="hover ? 'd-flex transition-fast-in-fast-out grey lighten-2 v-card--reveal headline teal--text' : ''"
                                        style="height: 100%;" >
                                        <v-btn class="float-right" icon @click="Cover_Dialog = true"><v-icon color="primary">mdi-pen</v-icon></v-btn>
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                                <v-img v-else :src="event.photo" max-width="100%">
                                    <v-expand-transition>
                                        <div v-if="hover"
                                        :class="hover ? 'd-flex transition-fast-in-fast-out grey lighten-2 v-card--reveal headline teal--text' : ''"
                                        style="height: 100%;" >
                                        <v-btn class="float-right" icon @click="Cover_Dialog = true"><v-icon color="primary">mdi-pen</v-icon></v-btn>
                                        </div>
                                    </v-expand-transition>
                                </v-img>
                            </v-hover>
                            <v-img v-else :src="event.photo" max-width="100%">
                            </v-img>
                        </v-row>
                        <!-- Details -->
                        <v-row>
                            <p class="display-1 teal--text text--darken-2 font-weight-bold">Details</p>
                        </v-row>
                        <v-row>
                            <p class="title">{{event.description}}</p>
                        </v-row>
                        <!-- Speakers -->
                        <v-row v-if="Speakers != ''">
                            <p class="display-1 teal--text text--darken-2 font-weight-bold">Guest Speakers</p>
                        </v-row>
                        <v-row v-if="Speakers != ''">
                            <v-tooltip top v-for="attendee in Speakers" :key="attendee.name">
                                <template v-slot:activator="{ on }">
                                    <div v-on="on" :class="{'': $vuetify.breakpoint.smAndDown, 'ml-2':$vuetify.breakpoint.mdAndUp}">
                                        <cld-image :publicId="attendee.avatar" width="50">
                                            <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>  
                                        </cld-image>
                                    </div>
                                </template>
                                <span>{{attendee.name}}</span>
                            </v-tooltip>
                        </v-row>
                        <v-row v-if="Speakers == '' && upcomming == true">
                            <p class="display-1 teal--text text--darken-2 font-weight-bold">We Are Calling For Speaker</p>
                            <p class="title">If interested please contact the organizers</p>
                        </v-row>
                        <!-- Attendees -->
                        <v-row>
                            <p class="display-1 teal--text text--darken-2 font-weight-bold">Attendees</p>
                        </v-row>
                        <v-row>
                            <v-tooltip top v-for="attendee in GoingAttendee" :key="attendee.name">
                                <template v-slot:activator="{ on }">
                                    <div v-on="on" :class="{'': $vuetify.breakpoint.smAndDown, 'ml-2':$vuetify.breakpoint.mdAndUp}">
                                        <cld-image :publicId="attendee.avatar" width="50">
                                            <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>  
                                        </cld-image>
                                    </div>
                                </template>
                                <span>{{attendee.name}}</span>
                            </v-tooltip>
                        </v-row>
                        <!-- Sponsors -->
                        <v-row v-if="selectedSponsors != ''">
                            <p class="display-1 teal--text text--darken-2 font-weight-bold">Event Sponsors</p>
                        </v-row>
                        <v-row v-if="selectedSponsors != ''">
                            <div top v-for="sponsor in selectedSponsors" :key="sponsor.name">
                                <span class="title font-weight-bold">{{sponsor.name}} ,</span>
                            </div>
                        </v-row>
                    </v-col>
                    <v-col cols=12 md=12 lg=3 :class="{'': $vuetify.breakpoint.smAndDown, 'ml-3':$vuetify.breakpoint.mdAndUp}">
                        <v-row>
                            <v-spacer></v-spacer>
                            <v-menu transition="slide-y-transition" offset-y nudge-width="200px" :close-on-content-click="false">
                                <template v-slot:activator="{ on }" :close-on-click="false">
                                    <v-btn rounded medium color="primary" v-on="on"  v-if='organizer()'>
                                    Organizer Settings<v-icon right>mdi-chevron-down</v-icon>
                                    </v-btn>
                                </template>
                                <v-list two-line>
                                    <v-list-item ripple="ripple" @click="Settings_Dialog = true">
                                        <v-list-item-avatar>
                                            <v-icon class="teal lighten-2 white--text"
                                            >mdi-settings</v-icon>
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <v-list-item-title>Event Settings</v-list-item-title>
                                            <v-list-item-subtitle>Manange Event</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item ripple="ripple" @click="dialog = true">
                                        <v-list-item-avatar>
                                            <v-icon class="teal lighten-2 white--text"
                                            >mdi-account-circle</v-icon>
                                        </v-list-item-avatar>
                                        <v-list-item-content>
                                            <v-list-item-title>Attendees</v-list-item-title>
                                            <v-list-item-subtitle>Manange Attendees</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-row>
                        <v-row>
                            <p class="title teal--text text--darken-2"><v-icon color="primary">mdi-alarm</v-icon>{{event.start.full | eventDate}}</p>
                        </v-row>
                         <v-row>
                            <p class="title teal--text text--darken-2"><v-icon color="primary">mdi-map-marker</v-icon>{{event.location.formatted_address}}</p>
                        </v-row>
                        <!-- Maps -->
                        <v-row>
                            <GmapMap style="width: 100%; height: 300px;" :zoom="25" :center="center" 
                                        >
                                <GmapMarker 
                                    v-if="this.center"
                                    label="★"
                                    :draggable="true"
                                    :position="center"
                                    />
                            </GmapMap>
                        </v-row>
                        <!-- Tags -->
                        <v-row>
                            <v-col>
                                <p class="title teal--text text--darken-2"><v-icon color="primary">mdi-tag-multiple</v-icon>Event Topics/Tags</p>
                                <v-chip-group column>
                                    <v-chip v-for="tag in selectedTags"  :key="tag.name" large outlined color="primary">{{tag.name}}</v-chip>
                                </v-chip-group>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-dialog v-model="dialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <v-toolbar-title color="primary">Attendee</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon color="primary" @click="dialog = false"><v-icon>mdi-close</v-icon></v-btn>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols=12 lg-10>
                            <v-tabs color="primary">
                                 <!-- Tab for Did -->
                                <v-tab  v-if="upcomming" href="#tab-1">
                                    Going
                                </v-tab>

                                <v-tab  v-else href="#tab-1">
                                    Went
                                </v-tab>
                                
                                <!-- Tab for Not/Didn't go -->
                                <v-tab v-if="upcomming" href="#tab-2">
                                    Not Going
                                </v-tab>
                                <v-tab v-else href="#tab-2">
                                    Not Going
                                </v-tab>
                                <v-tab-item :value="'tab-' + 1">
                                    <v-list two-line>
                                        <v-list-item v-for="attendee in GoingAttendee" :key="attendee.name">
                                             <cld-image :publicId="attendee.avatar" width="50" class="mr-2">
                                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                            </cld-image>
                                            <v-list-item-content>
                                                <v-list-item-title>{{attendee.name}}</v-list-item-title>
                                                <v-list-item-subtitle>{{attendee.created_at | eventDate}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                                        <v-btn icon color="primary" v-on="on">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <v-list two-line>
                                                        <v-list-item v-if="upcomming" ripple="ripple" @click="joinEvent(attendee.id,false)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Not Going"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                        <v-list-item v-else ripple="ripple" @click="joinEvent(attendee.id,false)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Didn't Going"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-tab-item>

                                <v-tab-item :value="'tab-' + 2">
                                    <v-list two-line>
                                        <v-list-item v-for="attendee in NotGoingAttendee" :key="attendee.name">
                                             <cld-image :publicId="attendee.avatar" width="50" class="mr-2">
                                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                                            </cld-image>
                                            <v-list-item-content>
                                                <v-list-item-title>{{attendee.name}}</v-list-item-title>
                                                <v-list-item-subtitle>{{attendee.created_at | eventDate}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                            <v-list-item-action>
                                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                                        <v-btn icon color="primary" v-on="on">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <v-list two-line>
                                                        <v-list-item v-if="upcomming" ripple="ripple" @click="joinEvent(attendee.id,true)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Going"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                        <v-list-item v-else ripple="ripple" @click="joinEvent(attendee.id,true)">
                                                            <v-list-item-content>
                                                                <v-list-item-title>Move to "Went"</v-list-item-title>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                </v-tab-item>
                            </v-tabs>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
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
        <v-dialog v-model="Upload_Dialog" max-width="400px">
            <v-card>
                <v-card-title >
                Upload Proof of Payment
                </v-card-title>
                <v-card-text>
                <v-container>
                    <v-row wrap justify=center align=center>
                        <v-file-input v-model="photo_name" accept="image/*" placeholder="Proof..." outlined dense prepend-icon="fa-photo" @change="file_upload"/>
                    </v-row>
                </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn rounded color="primary" @click="upload_Payment()">Upload Proof of Payment</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="Settings_Dialog" width="90vw" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-toolbar-title class="display-1">Event Settings</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <!-- <v-icon x-large>information</v-icon> -->
                </v-toolbar>
                <v-card-text>
                    <v-container grid-list-xl v-if="true">
                        <p class="title teal--text text--darken-2">Event Title</p>                            
                        <v-row>
                            <v-col cols=12 md=12 lg=12 xl=12>
                                <v-text-field outlined type="text" label="Event Title" v-model="event.title" required autofocus prepend-inner-icon="mdi-calendar"/>
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
                                    :return-value.sync="event.start.date"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on }">
                                    <v-text-field outlined
                                        v-model="event.start.date"
                                        label="Event Date"
                                        prepend-inner-icon="mdi-calendar"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-date-picker :allowedDates="allowedDatesStart" v-model="event.start.date" @change="startChange()" color="primary" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="modal = false">Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.dialog.save(event.start.date)">OK</v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>
                            <v-col cols=12 md=12 lg=6 xl=6>
                                <v-dialog
                                    ref="dialog2"
                                    v-model="modal2"
                                    :return-value.sync="event.start.time"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on }">
                                    <v-text-field outlined
                                        v-model="event.start.time"
                                        label="Event Time"
                                        prepend-inner-icon="mdi-alarm"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                    </template>
                                    <v-time-picker color="primary"
                                    v-if="modal2"
                                    v-model="event.start.time"
                                    full-width
                                    >
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="modal2 = false">Cancel</v-btn>
                                    <v-btn text color="primary" @click="$refs.dialog2.save(event.start.time)">OK</v-btn>
                                    </v-time-picker>
                                </v-dialog>
                            </v-col>
                        </v-row>
                        <p class="title teal--text text--darken-2">Event End</p>
                        <v-row>
                            <v-col cols=12 md=12 lg=6 xl=6>
                                <v-dialog ref="dialog3" v-model="modal3" :return-value.sync="event.end.date"
                                            persistent width="290px">
                                    <template v-slot:activator="{ on }">
                                        <v-text-field outlined v-model="event.end.date" label="Event Date" prepend-inner-icon="mdi-calendar" readonly v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker :allowedDates="allowedDatesEnd"  v-model="event.end.date" color="primary" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="modal3 = false">Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.dialog3.save(event.end.date)">OK</v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>
                            <v-col cols=12 md=12 lg=6 xl=6>
                                <v-dialog ref="dialog4" v-model="modal4" :return-value.sync="event.end.time"
                                    persistent width="290px">
                                    <template v-slot:activator="{ on }">
                                        <v-text-field outlined v-model="event.end.time" label="Event Time" prepend-inner-icon="mdi-alarm" readonly v-on="on"></v-text-field>
                                    </template>
                                    <v-time-picker color="primary" v-if="modal4" v-model="event.end.time" full-width>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="modal4 = false">Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.dialog4.save(event.end.time)">OK</v-btn>
                                    </v-time-picker>
                                </v-dialog>
                            </v-col>
                        </v-row>
                        <p class="title teal--text text--darken-2">Event Description</p>                            
                        <v-row>
                            <v-col cols=12 md=12 lg=12 xl=12>
                                <v-text-field outlined type="text" label="Event Description" v-model="event.description" required autofocus prepend-inner-icon="mdi-calendar"/>
                            </v-col>
                        </v-row>                   
                        <p class="title teal--text text--darken-2">Event Topic</p>
                        <v-row>
                            <v-col cols=12 md=12 lg=12 xl=12>
                                <form v-on:submit.prevent="">
                                    <v-autocomplete v-model="selectedTags" :disabled="isUpdating" :items="tags"
                                        filled chips color="primary" label="Select Technology tags"
                                        :search-input.sync="searchInput" rounded
                                        item-text="name" item-value="name" multiple dense>
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
                                    <GmapMarker v-if="this.event.location" label="★" :draggable="true" :position="center"/>
                                </GmapMap>
                            </v-col>
                        </v-row>
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
                                                <v-autocomplete v-model="selectedSpeakers" :disabled="isUpdating" :items="users"
                                                    filled chips color="primary" label="Select Speakers"
                                                    item-text="name" item-value="id" multiple outlined>
                                                    <template v-slot:selection="data">
                                                        <v-chip v-bind="data.attrs" :input-value="data.selectedSpeakers" close @click="data.select"
                                                            @click:close="removeTag(data.item)">
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
                                                <v-text-field outlined v-model="event.limit" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
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
                                                <v-switch v-model="event.exclusive" class="mx-2"></v-switch>
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
                                                <v-text-field outlined v-model="event.fee" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
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
                                                    <button v-show="false" type="submit" @click="AddSponsor()">Submit</button>
                                                </form>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-row>
                    </v-container>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" outlined rounded x-large @click="Settings_Dialog == false">Cancel</v-btn>
                    <v-btn color="primary" rounded x-large @click="updateEvent()">Update Event</v-btn>
                </v-card-text>
                <v-card-actions class="text-center">
                </v-card-actions>
            </v-card>
        </v-dialog>
        
    </v-container>
</template>
<script>
    import moment from 'moment';
  export default {
    data: () => ({
        user_id: sessionStorage.getItem('user-id'),
        center: { lat: '' , lng: '' },
        attendees: [],
        status: '',
        settings: null,
        event: {id: '', start: '', end: '', title: '', photo: '', location: '', organizer: '', description: '', exclusive: '', fee: '', limit: '', allowed: ''},
        communities: [{name:''}],
        location: {},
        tags: [],
        newTags: [],
        payment: '',
        isUpdating: false,
        qrcode: '',
        //Dialogs
        dialog: false,
        Cover_Dialog:false,
        Settings_Dialog: false,
        Upload_Dialog: false,
        QrCode_Dialog: false,
        // Photo
        photo_data: null,
        photo_name: null,
        upcomming: null,
        ratings: 4,
        //Update Event Settings
        modal: false,
        modal2: false,
        modal3: false,
        modal4: false,
        searchInput: '',
        users: [],
        sponsorsdiila: [],
        communityUnder: [],
        //Optionals
        selectedPartners: [],
        selectedTags: [],
        selectedSpeakers: [],
        selectedSponsors: [],
    }),
    computed: {
        GoingAttendee: function() {
            return this.attendees.filter(function(attendee) {
                if(attendee.position == 'going' || attendee.position == 'organizer' || attendee.position == 'went' || attendee.position == 'speaker'){
                    return attendee
                }
            })
        },
        Speakers: function() {
            return this.attendees.filter(function(attendee) {
                if(attendee.position == 'speaker'){
                    return attendee
                }
            })
        },
        NotGoingAttendee: function() {
            return this.attendees.filter(function(attendee) {
                if(attendee.position == 'notgoing' || attendee.position == 'absent'){
                    return attendee
                }
            })
        },
        allowedDatesStart () {
            return (another => val => val >= another)(new Date().toISOString().substr(0, 10))
        },
        allowedDatesEnd () {
            return (another => val => val >= another)(this.event.start.date)
        }
    },
    mounted () {
        this.retrieveEvent()
        this.retrieveTags()
        this.retrieveUsers()
    },
    methods: {
        retrieveEvent(){
            axios.get("/api/event/"+this.$route.params.event_code ,
            {
                params:{
                    code: this.$route.params.event_code
                }
            })
            .then(response => {
                this.event = {
                    id: response.data.event.id,
                    title: response.data.event.title,
                    photo: response.data.event.photo,
                    start: {
                        date: moment(response.data.event.start).format("YYYY-MM-DD"),
                        time: moment(response.data.event.start).format("kk:mm"),
                        full: response.data.event.start,
                    },
                    end: {
                        date: moment(response.data.event.end).format("YYYY-MM-DD"),
                        time: moment(response.data.event.end).format("kk:mm"),
                    },
                    description: response.data.event.description,
                    organizer: response.data.event.organizer,
                    exclusive: response.data.event.exclusive,
                    allowed: response.data.event.allowed,
                    limit: response.data.event.limit,
                    fee: response.data.event.fee,
                    location: response.data.event.location,
                }
                this.center = { lat: response.data.event.location.lat, lng: response.data.event.location.lng }
                this.attendees = response.data.attendees
                this.selectedSpeakers = response.data.speakers
                this.selectedSponsors = response.data.sponsors
                this.communities = response.data.communities
                this.selectedTags = response.data.tags
                this.status = response.data.status
                this.settings = response.data.event.settings
                this.qrcode = "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=" + response.data.event.qrcode
                this.upcomming = response.data.event.upcomming
                this.communities.forEach(community => {
                    if(community.position == 'partner'){
                        this.selectedPartners.push(community['name']);
                    }
                });
            })
            .catch( error => { alert(error)})
            .finally( x => { 
                this.loading = false
                this.retrieveCommunityUnder()
                this.retrieveCommunitySponsors()
            })
        },
        coutlined(){
            if(this.status == 'pending') {
                return false
            }
            else if(this.status == 'going' || this.status == 'organizer' || this.status == 'speaker'){
                return false
            }
            else{
                return true
            }
        },
        xoutlined(){
            if(this.status == 'pending') {
                return false
            }
            else if(this.status == 'going' || this.status == 'organizer' || this.status == 'speaker'){
                return true
            }
            else{
                return false
            }
        },
        organizer(){
            if(this.settings == false) {
                return false
            }
            else{
                return true
            }
        },
        joinEvent(attendee,status){
            let keychars = "1234567890" //allowed characters for key
            let code = ''
            for(let i=0; i < 8; i++ )
            {
                code += keychars.charAt(Math.floor(Math.random() * keychars.length))
            }
            if(this.event.fee == 0){
                axios.put("/api/joinevent" ,{
                    id: this.event.id,
                    attendee_id: attendee,
                    status: status,
                    upcomming: this.upcomming,
                    qrcode: code
                })
                .then(response => {
                    // if(!this.settings){
                        this.status = response.data.attendee.position
                    // }
                    this.attendees = response.data.attendees
                })
                .catch( error => { alert(error)})
            }else{
                this.Upload_Dialog = true
            }
        },
        visit_community(community_name){
          this.$router.push('/'+community_name.split(' ').join('_')+'/about')
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
            axios.put('/api/event/upload-profile/'+this.event.id,{ 
                photo: this.photo_data
            }).then(response => {
                if (response.data.success) {
                    this.$Progress.finish();
                    swal.fire(
                        'Success!',
                        'Successfully Changed Profile Photo',
                        'success'
                    )
                    this.event.photo = response.data.success.photo
                    this.Cover_Dialog = false
                }
                else{
                    this.$Progress.fail();
                }
            }).catch(error => {
                this.$Progress.fail();
            })
        },
        upload_Payment(){
            this.$Progress.start();
            axios.put('/api/event/upload-payment/'+this.event.id,{ 
                photo: this.photo_data
            }).then(response => {
                if (response.data.success) {
                    this.$Progress.finish();
                    swal.fire(
                        'Success!',
                        'Successfully Sent Proof, Please wait for organizer to approve',
                        'success'
                    )
                    this.Upload_Dialog = false
                }
                else{
                    this.$Progress.fail();
                }
            }).catch(error => {
                this.$Progress.fail();
            })
        },
        //Optional
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
        startChange(){
            this.event.end.date = this.event.start.date
        },
        setPlace(place) {
            this.event.location = place;
            this.center = {
                lat: this.event.location.geometry.location.lat(),
                lng: this.event.location.geometry.location.lng()
            };
            this.event.location = {
                lat: this.event.location.geometry.location.lat(),
                lng: this.event.location.geometry.location.lng(),
                name: this.event.location.name,
                formatted_address: this.event.location.formatted_address,
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
                    community: this.communities[0].name
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
                    community: this.communities[0].name
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
        updateEvent() {
            this.loading = true
            if(this.newTags != null){
                this.SaveNewTechnology()
            }
            // Update Event
            axios.put('/api/update_event/'+this.event.id , { 
                title: this.event.title, 
                description: this.event.description, 
                location: this.event.location, 
                start: this.event.start.date + ' '+this.event.start.time, 
                end: this.event.end.date + ' '+this.event.end.time,
                //Optional Settings
                limit: this.event.limit,
                exclusive: this.event.exclusive,
                fee: this.event.fee,

            })
            .then( response => { 
                axios.put('/api/eventtech/' + this.event.id, { 
                    id: this.event.id,
                    tags: this.selectedTags
                })
                .then( response => {
                    axios.put('/api/eventcommunity/' + this.event.id, { 
                        id: this.event.id,
                        status: 'Update',
                        community: this.communities[0].name,
                        partners: this.selectedPartners,
                        speakers: this.selectedSpeakers,
                        sponsors: this.selectedSponsors,
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
                        this.retrieveEvent()
                        this.retrieveTags()
                        this.retrieveUsers()
                    })
                    .catch( error => { alert(error)})
                })
                .catch( error => { alert(error)})
            })
            .catch( error => { alert(error)})
            .finally( x => { 
                this.loading = false
                this.Settings_Dialog = false
            })
        },
    },
    created() {

    },
  }
</script>