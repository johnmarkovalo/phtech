<template>
    <div class="mt-n1">
        <section>
            <v-container id="landing" fluid pa-0 fill-heigh >
                <!-- <v-img src="img/carousel/1.png" max-height="100vw" max-width="100%" style="background:rgba(0, 0, 0, 0.8);"> -->
                    <v-layout align-center column fill-height justify-center :class="{'ml-3 pl-3 landing-container': $vuetify.breakpoint.smAndDown, 'ml-12 pl-12 landing-container': $vuetify.breakpoint.mdAndUp}" >
                    <p :class="{'teal--text text--lighten-2 title font-weight-thin mb-3': $vuetify.breakpoint.smAndDown, 
                                 'teal--text text--lighten-2 display-3 font-weight-thin mb-3': $vuetify.breakpoint.mdAndUp}">
                                Experience The Best <br>
                                Events and Meet <br>
                                with Awesome People <br>
                                in your Community <br>
                    </p>
                    <v-btn rounded :class="{'mb-2 white--text ml-3 pl-3': $vuetify.breakpoint.smAndDown, 'mb-4 white--text': $vuetify.breakpoint.mdAndUp}" 
                        color="primary" bottom center dark :x-large="$vuetify.breakpoint.mdAndUp" 
                        :small="$vuetify.breakpoint.smAndDown">
                        SIGN-UP
                    </v-btn>
                    </v-layout>
                <!-- </v-img> -->
            </v-container>
        </section>
        <section id="servicing" class="mt-5 pt-5 mb-5 pb-5">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" md="3">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="text-center">
                            <v-avatar size="100px">
                                <v-icon size="60px" class="teal darken-3 white--text"
                                >mdi-calendar-multiple-check</v-icon>
                            </v-avatar>
                            </v-card-text>
                            <v-card-title primary-title class="layout justify-center">
                            <div class="title text-center">Visit Events page for all the <br>Tech Community activities for the year.</div>
                            </v-card-title>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="text-center">
                            <v-avatar size="100px">
                                <v-icon size="60px" class="teal darken-3 white--text"
                                >mdi-account-group</v-icon>
                            </v-avatar>
                            </v-card-text>
                            <v-card-title primary-title class="layout justify-center">
                            <div class="title text-center">Meet and Search for Communities that <br>you're interested with</div>
                            </v-card-title>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="text-center">
                            <v-avatar size="100px">
                                <v-icon size="60px" class="teal darken-3 white--text"
                                >mdi-format-list-checks</v-icon>
                            </v-avatar>
                            </v-card-text>
                            <v-card-title primary-title class="layout justify-center">
                            <div class="title text-center">Check Attendance of attendee in every <br>events of the community</div>
                            </v-card-title>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="3">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="text-center">
                            <v-avatar size="100px">
                                <v-icon size="60px" class="teal darken-3 white--text"
                                >mdi-handshake</v-icon>
                            </v-avatar>
                            </v-card-text>
                            <v-card-title primary-title class="layout justify-center">
                            <div class="title text-center">Accessible for all technology enthusiast</div>
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </section>
        <section id="about">
            <v-containter>
                <v-row justify="center">
                    <v-col cols="12" md="4">
                        <v-card>
                            <v-card-title primary-title class="layout justify-start">
                                <div class="display-2 text-start font-weight-light teal--text text--darken-3">ABOUT THE <br>PHILIPPINE TECH <br>COMMUNITY</div>
                            </v-card-title>
                            <v-card-text class="text-center title">
                                The rise in the number of tech communities in the Philippines dates back in the early days of the WWW in the Philippines (circa 1995). From mailing lists to BBS, which later evolved into online forums, tech communities in the country began conducting mini-EBs (Eye Balls or what we know now as meetups) to give faces behind the (user)names online.
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-containter>
        </section>
        <section id="recentevent" class="mt-10 pt-10 mb-10 pb-10">
            <v-container>
                <v-row justify="center">
                    <p class="display-2 teal--text text--darken-3">Recent Events</p>
                </v-row>
                <v-row justify="center">
                    <v-col  v-for="card in events" :key="card.title" cols="12" md="3">
                        <v-card :elevation="hover ? 12 : 2">
                            <v-img :src="card.photo" class=" align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px">
                            </v-img>
                            <v-card-text> 
                            <p class="title teal--text text--darken-2">{{card.start | eventDate}}</p>
                            <p class="headline ">{{card.name}}</p>
                            <p class="subtitle-1 teal--text text--darken-2">{{card.community_organizer}}</p>
                            <p class="subtitle-2 text-truncate">{{card.location.formatted_address}}</p>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </section>
        <footer id="footer" height="350px" padless absolute>
            <v-row justify=center no-gutter>
                <v-col cols="12" class="text-center">
                    <span class="white--text">&copy; Copyright PhTechPark 2020</span><br>
                </v-col>
            </v-row>
        </footer>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                email : "",
                events: [],
            }
        },
        methods : {
            handleSubmit(){
                
            },
            retrieveEvent(){
                axios.get('/api/recentevent' ,
                {
                    params: {
                    id: sessionStorage.getItem('user-id'),
                    }
                })
                .then( response => {
                    this.events = response.data.events
                })
                .catch( error => { alert(error)})
            },
        },
        created(){
            this.retrieveEvent();
        }
    }
</script>
