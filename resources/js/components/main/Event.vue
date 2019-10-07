<template>
    <div>
        


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
