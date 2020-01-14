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
                        color="primary" bottom center dark round :x-large="$vuetify.breakpoint.mdAndUp" 
                        :small="$vuetify.breakpoint.smAndDown">
                        SIGN-UP
                    </v-btn>
                    </v-layout>
                <!-- </v-img> -->
            </v-container>
        </section>
        <!-- <section id="landing">
            <div class="landing-container">
                <div class="wow fadeIn">
                    <div class="landing-logo">
                    <img class="" src="img/logo.png" alt="SecureLife">
                    </div>

                    <h1>SecureLife International Corporation</h1>
                    <h2>We rise by lifting others</h2>
                    <div class="actions">
                    <a href="/sign-in" class="btn-get-started">SIGN-IN</a>
                    <a href="/sign-up" class="btn-services">SIGN-UP</a>
                    </div>
                </div>
            </div>
        </section> -->
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
