<template>
    <div>
        <!-- Banner -->
        <section>
            <v-container fluid cols="12" md="12" lg="12" ma-0 pa-0>
                <v-carousel height="100%" width="100%" cycle interval="3500" :show-arrows="false" hide-delimiters  reverse-transition="fade" transition="fade">
                    <v-carousel-item><img src="/img/Banner4.5.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/Banner4.6.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/Banner4.7.png" alt="img"></v-carousel-item>
                    <v-carousel-item><img src="/img/Banner4.8.png" alt="img"></v-carousel-item>
                </v-carousel>
            </v-container>
        </section>
        <!-- Sayings With Icon -->
        <section>
            <v-row class="my-5" align-center justify-center>
                <v-col cols="12" class="my-3">
                    <div class="text-center">
                        <h2 class="display-3 primary--text">SecureLife International Corporation</h2>
                        <span class="title">We rise by lifting others</span>
                    </div>
                </v-col>
            </v-row>
        </section>

        <!-- Our Package -->
        <section>
            <v-layout  column wrap class="my-5" align-center>
                <!-- Header -->
                <v-flex xs12 sm4 class="my-3">
                    <div class="text-center">
                        <h2 class="display-3 primary--text">Secure Packages</h2>
                    </div>
                </v-flex>
                    <v-container grid-list-xl>
                        <v-layout row wrap  justify-center>
                            <v-flex xs12 md3>
                                <v-card class="elevation-0" >
                                    <!-- <v-card-text class="text-xs-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569247464/SecureLife/packages/A.png"></v-img>
                                    <!-- </v-card-text> -->
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md3>
                                <v-card class="elevation-0" >
                                    <!-- <v-card-text class="text-xs-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569247464/SecureLife/packages/A.png"></v-img>
                                    <!-- </v-card-text> -->
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md3>
                                <v-card class="elevation-0" >
                                    <!-- <v-card-text class="text-xs-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569247464/SecureLife/packages/A.png"></v-img>
                                    <!-- </v-card-text> -->
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md3>
                                <v-card class="elevation-0" >
                                    <!-- <v-card-text class="text-xs-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569247464/SecureLife/packages/A.png"></v-img>                                        
                                    <!-- </v-card-text> -->
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
            </v-layout>
        </section>

        <!-- Our Products -->
        <section>
            <v-layout  column wrap class="my-5" align-center>
                <!-- Header -->
                <v-flex xs12 sm4 class="my-3">
                    <div class="text-center">
                        <h2 class="display-3 primary--text">Our Products</h2>
                    </div>
                </v-flex>
                    <v-container grid-list-xl>
                        <v-layout row wrap  justify-center>
                            <v-flex xs12 md3>
                                <v-card >
                                    <!-- <v-card-text class="text-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569159057/SecureLife/products/Coffee.png"></v-img>
                                    <!-- </v-card-text> -->
                                    <v-card-title primary-title class="layout justify-center">
                                        <p class="headline text-center">SURIMU LUXXE <br> COFFEE</p>
                                    </v-card-title>
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md3>
                                <v-card >
                                    <!-- <v-card-text class="text-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569159056/SecureLife/products/Gluta.png"></v-img>
                                    <!-- </v-card-text> -->
                                    <v-card-title primary-title class="layout justify-center">
                                        <p class="headline text-center">SURIMU LUXXE <br> GLUTATHIONE</p>
                                    </v-card-title>
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md3>
                                <v-card >
                                    <!-- <v-card-text class="text-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569159055/SecureLife/products/Juice.png"></v-img>                                        
                                    <!-- </v-card-text> -->
                                    <v-card-title primary-title class="layout justify-center">
                                        <p class="headline text-center">SURIMU LUXXE <br> LEMON JUICE</p>
                                    </v-card-title>
                                </v-card>
                            </v-flex>
                            <v-flex xs12 md3>
                                <v-card >
                                    <!-- <v-card-text class="text-center"> -->
                                        <v-img src="https://res.cloudinary.com/tim0923/image/upload/v1569159054/SecureLife/products/Soap.png"></v-img>
                                    <!-- </v-card-text> -->
                                    <v-card-title primary-title class="layout justify-center">
                                        <p class="headline text-center">INTENSE WHITE <br> BEAUTY BAR</p>
                                    </v-card-title>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
            </v-layout>
        </section>

        <!-- Footer -->
        <div id="footer" height="350px" padless absolute style="backgrounded: linear-gradient(#FF8F00, #FFC107);">
            <v-col cols="12">
                <v-container grid-list-xl fluid class="hidden-sm-and-down">
                    <v-row  align-start>
                        <v-col cols="12" md="4">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="subtitle-2">
                                Company Information<br>
                                Tel Nos. :<br>
                                +639 000 0000<br>
                                Email Address :<br>
                                ask@securelifeintlcorp.com<br>
                                Address :<br>
                                Nunez Ext, Zamboanga City, Philippines<br>
                            </v-card-text>
                        </v-card>
                        </v-col>
                        <v-col cols="12" md="4">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="subtitle-2">
                                Quick Links<br>
                                Home<br>
                                Terms & Conditions<br>
                                Privacy Policy<br>
                                Contact Us<br>
                                About Us<br>
                                Frequently Asked Questions<br>
                            </v-card-text>
                        </v-card>
                        </v-col>
                        <v-col cols="12" md="4">
                        <v-card class="elevation-0 transparent">
                            <v-card-text class="subtitle-2">
                                Send us an email<br>
                                <v-text-field small outlinedd id="email" type="email" label="Email Address" v-model="email" prepend-inner-icon="alternate_email"/>
                                <v-btn medium rounded color="primary" outlined type="submit" @click="handleSubmit">
                                    Send
                                    <v-icon small class="ml-2">send</v-icon>
                                </v-btn>
                            </v-card-text>
                        </v-card>
                        </v-col>
                    </v-row>
                </v-container>
                <v-divider></v-divider>
                <!-- Bottom Part -->
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
                                <span>&copy; SecureLife International Corporation 2019</span><br>
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
