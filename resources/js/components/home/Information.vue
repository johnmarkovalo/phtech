<template>
    <div class="container fluid">
        <v-row justify="center" align="center">
            <v-col xs="12" md="10" lg="10" justify="center" align="center">
                <v-card width="600px" :class="{'my-5': $vuetify.breakpoint.mdAndUp}">
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title class="display-1">Personal Information</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <!-- <v-icon x-large>information</v-icon> -->
                    </v-toolbar>
                    <v-card-text>
                      <v-stepper v-model="e1">
                        <v-stepper-header>
                          <v-stepper-step complete-icon="check" :complete="e1 > 1" step="1">Affiliation</v-stepper-step>

                          <v-divider></v-divider>

                          <v-stepper-step complete-icon="check" :complete="e1 > 2" step="2">Specialty</v-stepper-step>

                          <v-divider></v-divider>

                          <v-stepper-step complete-icon="check" step="3">Verification</v-stepper-step>
                        </v-stepper-header>

                        <v-stepper-items>
                          <v-stepper-content step="1">
                                  <v-container grid-list-sm bt-0>
                                      <v-layout row wrap>
                                          <!-- Company -->
                                          <v-flex xs12 md12 v-if="!student">
                                              <v-text-field :rules="rules" outlined type="text" label="Company" v-model="company" required autofocus prepend-inner-icon="account_circle"/>
                                          </v-flex>
                                          <!-- Job -->
                                          <v-flex xs12 md12 v-if="!student">
                                              <v-text-field :rules="rules" outlined type="text" label="Job Title" v-model="title" required prepend-inner-icon="account_circle" />
                                          </v-flex>
                                         <!-- Company -->
                                          <v-flex xs12 md12 v-if="student">
                                              <v-text-field :rules="rules" outlined type="text" label="School" v-model="school" required autofocus prepend-inner-icon="account_circle"/>
                                          </v-flex>
                                          <!-- Job -->
                                          <v-flex xs12 md12 v-if="student">
                                              <v-text-field :rules="rules" outlined type="text" label="Degree" v-model="degree" required prepend-inner-icon="account_circle" />
                                          </v-flex>
                                      </v-layout>
                                  </v-container>
                                  <v-row justify="center">
                                      <v-col xs="12" md="12" justify="center">
                                          <v-btn v-if="!student" pa-1 class="blue--text font-weight-bold" block x-large text @click="student = !student">I'm a Student</v-btn>
                                          <v-btn v-if="student" pa-1 class="blue--text font-weight-bold" block x-large text @click="student = !student">I'm not a Student</v-btn>
                                      </v-col>
                                  </v-row>
                                  <v-btn x-large rounded color="primary" @click="e1 = 2">
                                      Continue
                                  </v-btn>
                                  <v-btn text>Cancel</v-btn>
                          </v-stepper-content>

                          <v-stepper-content step="2">
                                  <v-container grid-list-sm bt-0>
                                      <v-layout row wrap>
                                          <!-- Company -->
                                          <v-flex xs12 md12 v-if="!student">
                                              <v-text-field :rules="rules" outlined type="text" label="Interest" v-model="company" required autofocus prepend-inner-icon="account_circle"/>
                                          </v-flex>
                                          <!-- Job -->
                                          <v-flex xs12 md12 v-if="!student">
                                              <v-text-field :rules="rules" outlined type="text" label="Job Title" v-model="title" required prepend-inner-icon="account_circle" />
                                          </v-flex>
                                         <!-- Company -->
                                          <v-flex xs12 md12 v-if="student">
                                              <v-text-field :rules="rules" outlined type="text" label="School" v-model="school" required autofocus prepend-inner-icon="account_circle"/>
                                          </v-flex>
                                          <!-- Job -->
                                          <v-flex xs12 md12 v-if="student">
                                              <v-text-field :rules="rules" outlined type="text" label="Degree" v-model="degree" required prepend-inner-icon="account_circle" />
                                          </v-flex>
                                      </v-layout>
                                  </v-container>
                                  <v-row justify="center">
                                      <v-col xs="12" md="12" justify="center">
                                          <v-btn v-if="!student" pa-1 class="blue--text font-weight-bold" block x-large text @click="student = !student">I'm a Student</v-btn>
                                          <v-btn v-if="student" pa-1 class="blue--text font-weight-bold" block x-large text @click="student = !student">I'm not a Student</v-btn>
                                      </v-col>
                                  </v-row>
                                  <v-btn x-large rounded color="primary" @click="e1 = 2">
                                      Continue
                                  </v-btn>
                                  <v-btn text>Cancel</v-btn>
                          </v-stepper-content>

                          <v-stepper-content step="3">
                              <v-card
                              class="mb-12"
                              color="grey lighten-1"
                              height="200px"
                              ></v-card>

                              <v-btn
                              color="primary"
                              @click="e1 = 1"
                              >
                              Continue
                              </v-btn>

                              <v-btn text>Cancel</v-btn>
                          </v-stepper-content>
                        </v-stepper-items>
                      </v-stepper>  
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            e1: 0,
            loading: false,
            student:false,
            show1: false,
            school: '',
            degree: '',
            company: '',
            title: '',
            interest: [],
            rules: [v => !!v || "The input is required"],
        }
    },
    methods: {
        register() {
            this.loading = true
            axios.post('api/signup', { 
                password: this.user.password, 
                name: this.user.firstname + " " + this.user.lastname, email: this.user.email,
            })   
            .then( response => { 
                axios.post('api/signin', { 
                    email: this.user.email, password: this.user.password
                })
                .then( response => {
                    var token = response.data.token
                    var id = response.data.user
                    // Create a local storage item
                    localStorage.setItem('user-token', token)
                    localStorage.setItem('user-id', id)
                    // Redirect user
                    this.$router.push('dashboard')
                })
                .catch( error => { alert(error.errors)})
                .finally( x => {})
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        }
    },
    created(){
       console.log(localStorage.getItem('user-id'));
        
    }
}
</script>
