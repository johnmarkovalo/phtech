<template>
    <div class="mt-n1">
        <section>
            <v-container fluid pa-0 fill-heigh>
                <v-img src="img/carousel/1.png" max-height="100vw" max-width="100%" gradient="to top right, rgba(23,22,22,.4), rgba(23,22,22,.4)">
                    <v-layout align-start column fill-height justify-center :class="{'ml-3 pl-3': $vuetify.breakpoint.smAndDown, 'ml-12 pl-12': $vuetify.breakpoint.mdAndUp}" >
                    <h1 :class="{'teal--text text--lighten-2 title font-weight-thin mb-3': $vuetify.breakpoint.smAndDown, 
                                 'teal--text text--lighten-2 display-3 font-weight-thin mb-3': $vuetify.breakpoint.mdAndUp}">
                                EXPERIENCE THE BEST <br>
                                EVENTS AND MEET <br>
                                WITH AWESOME PEOPLE <br>
                                IN YOUR COMMUNITY <br>
                    </h1>
                    <v-btn rounded :class="{'mb-2 black--text ml-3 pl-3': $vuetify.breakpoint.smAndDown, 'mb-4 black--text': $vuetify.breakpoint.mdAndUp}" 
                        color="primary" bottom center dark round :x-large="$vuetify.breakpoint.mdAndUp" 
                        :small="$vuetify.breakpoint.smAndDown">
                        SIGN-UP
                    </v-btn>
                    </v-layout>
                </v-img>
            </v-container>
        </section>
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
