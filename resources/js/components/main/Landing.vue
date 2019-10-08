<template>
    <div>
        <!-- Banner -->
        <section>
            <v-container fluid cols="12" md="12" lg="12" ma-0 pa-0>
                <v-carousel height="100%" width="100%" cycle interval="3500" :show-arrows="false" hide-delimiters  reverse-transition="fade" transition="fade">
                    <v-carousel-item><img src="/img/carousel/1.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/carousel/2.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/carousel/3.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/carousel/4.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/carousel/5.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/carousel/6.png" alt="img"></v-carousel-item>
                </v-carousel>
            </v-container>
        </section>
         <!-- Sayings With Icon -->
        <section>
            <v-row>
                <v-col xs12>
                    <v-container grid-list-xl>
                        <v-row align-start>
                            <v-col xs12 md4>
                            <v-card class="elevation-0 transparent">
                                <v-card-text class="text-center">
                                <v-icon size="60px" class="blue--text text--darken-3">event_note</v-icon>
                                </v-card-text>
                                <v-card-title primary-title class="layout justify-center">
                                <div class="headline text-center">Visit Events page for all the <br>Tech Community activities for the year.</div>
                                </v-card-title>
                            </v-card>
                            </v-col>
                            <v-col xs12 md4>
                            <v-card class="elevation-0 transparent">
                                <v-card-text class="text-center">
                                <v-icon size="60px" class="blue--text text--darken-3">group</v-icon>
                                </v-card-text>
                                <v-card-title primary-title class="layout justify-center">
                                <div class="headline text-center">Meet and Search for Communities</div>
                                </v-card-title>
                            </v-card>
                            </v-col>
                            <v-col xs12 md4>
                            <v-card class="elevation-0 transparent">
                                <v-card-text class="text-center">
                                <v-icon size="60px" class="blue--text text--darken-3">accessibility_new</v-icon>
                                </v-card-text>
                                <v-card-title primary-title class="layout justify-center">
                                <div class="headline text-center">Accessible for all</div>
                                </v-card-title>
                            </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-col>
            </v-row>
        </section>


        <!-- Footer -->
        <div id="footer" height="350px" padless absolute color="black">
            <v-col cols="12">
                <v-row  justify-center>
                    <v-col cols="12" md="12">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="text-center">
                                <v-btn class="mx-2" href="https://www.facebook.com/securelifeintlcorp" icon>
                                    <v-icon size="22px">fab fa-facebook</v-icon>
                                </v-btn>
                                <v-btn class="mx-2" icon>
                                    <v-icon size="22px">fab fa-twitter</v-icon>
                                </v-btn>
                                <v-btn class="mx-2" icon>
                                    <v-icon size="22px">fab fa-instagram</v-icon>
                                </v-btn>
                                <v-btn class="mx-2" icon>
                                    <v-icon size="22px">fab fa-youtube</v-icon>
                                </v-btn>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row justify-center>
                        <v-col cols="12" md="12">
                            <v-card class="elevation-0 transparent">
                            <v-card-text class="text-center">
                                <span>&copy; phtechpark 2019</span><br>
                                <p>Made With <v-icon class="red--text">favorite</v-icon> by <a href="https://www.dreamersinfo.com" target="_blank">Dreame.rs</a></p>
                            </v-card-text>
                        </v-card>
                        </v-col>
                </v-row>
            </v-col>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                email : "",
            }
        },
        methods : {
            handleSubmit(){
                
            }
        }
    }
</script>
