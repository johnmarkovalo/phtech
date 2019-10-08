<template>
    <div class="container fluid">
        <v-layout row>
            <v-layout xs12 md10 lg10 justify-center>
                <v-card width="600px" :class="{'my-5 elevation-0': $vuetify.breakpoint.mdAndUp}">
                    <!-- <v-toolbar height="150px" class="justify-center align-center elevation-0">
                            <v-toolbar-title class="display-2">User Login</v-toolbar-title>
                            <v-icon x-large>assignment_ind</v-icon>
                    </v-toolbar> -->
                    <v-card-text>
                        <!-- Form -->
                        <v-form>
                            <!-- Username -->
                            <v-flex xs12 md12>
                                <v-text-field   outlined id="username" type="text" label="Username" v-model="username" required prepend-inner-icon="account_circle" autofocus/>
                            </v-flex>
                            <!-- Password -->
                            <v-flex xs12 md12>
                                <v-text-field   outlined id="password" :type="show1 ? 'text' : 'password'" @click:append="show1 = !show1" :append-icon="show1 ? 'visibility' : 'visibility_off'" label="Password" v-model="password"  required prepend-inner-icon="lock"/>
                            </v-flex>

                            <v-row justify="center">
                                <v-col xs="12" md="12" justify="center">
                                    <v-btn pa-1 block x-large rounded type="submit" color="amber darken-3" @click="handleSubmit">Login</v-btn>
                                </v-col>
                            </v-row>
                            <v-row justify="center">
                                <v-col xs="12" md="12" justify="center">
                                    <v-btn href="redirect" pa-1 block x-large rounded type="submit" color="amber darken-3">Google Sign-in</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-layout>
        </v-layout>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                username : "",
                password : "",
                show1: false,
            }
        },
    }
</script>