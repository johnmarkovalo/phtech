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
                      <v-stepper v-model="e1" class="transparent elevation-0">
                        <v-stepper-header class="elevation-0">
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
                                              <v-text-field :rules="rules" outlined type="text" label="Company" v-model="affiliation" required autofocus prepend-inner-icon="account_circle"/>
                                          </v-flex>
                                          <!-- Job -->
                                          <v-flex xs12 md12 v-if="!student">
                                              <v-text-field :rules="rules" outlined type="text" label="Job Title" v-model="position" required prepend-inner-icon="account_circle" />
                                          </v-flex>
                                         <!-- Company -->
                                          <v-flex xs12 md12 v-if="student">
                                              <v-text-field :rules="rules" outlined type="text" label="School" v-model="affiliation" required autofocus prepend-inner-icon="account_circle"/>
                                          </v-flex>
                                          <!-- Job -->
                                          <v-flex xs12 md12 v-if="student">
                                              <v-text-field :rules="rules" outlined type="text" label="Degree" v-model="position" required prepend-inner-icon="account_circle" />
                                          </v-flex>
                                      </v-layout>
                                  </v-container>
                                  <v-row justify="center">
                                      <v-col xs="12" md="12" justify="center">
                                          <v-btn v-if="!student" pa-1 class="teal--text font-weight-bold" block x-large text @click="student = !student">I'm a Student</v-btn>
                                          <v-btn v-if="student" pa-1 class="teal--text font-weight-bold" block x-large text @click="student = !student">I'm not a Student</v-btn>
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
                                            <v-autocomplete v-model="selected" :disabled="isUpdating" :items="tags"
                                                filled chips color="primary" label="Select Technology tags"
                                                item-text="name" item-value="name" multiple>
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
                                      </v-layout>
                                  </v-container>
                                  <v-btn x-large rounded color="primary" @click="e1 = 3">
                                      Continue
                                  </v-btn>
                                  <v-btn text>Cancel</v-btn>
                          </v-stepper-content>

                          <v-stepper-content step="3">
                              <p class="display-1">Congratulations! Please Save The information</p>

                              <v-btn x-large rounded color="success" @click="SaveInfoAndTech()">
                                Save Information
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
            affiliation: '',
            position: '',
            tags: [],
            rules: [v => !!v || "The input is required"],
            autoUpdate: true,
            selected: [],
            isUpdating: false,
        }
    },
     mounted() {
        this.retrieveTags()
    },
    watch: {
      isUpdating (val) {
        if (val) {
          setTimeout(() => (this.isUpdating = false), 3000)
        }
      },
    },

    methods: {
        remove (item) {
            const index = this.selected.indexOf(item.name)
            if (index >= 0) this.selected.splice(index, 1)
        },
        retrieveTags() {
            this.loading = true
            axios.get('api/technology')
            .then( response => {
                this.tags = response.data.tags
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },
        SaveInformation(){
            this.loading = true
            // Update customer
            axios.put('api/information/' + sessionStorage.getItem('user-id'), { 
                affiliation: this.affiliation, position: this.position, user_id: sessionStorage.getItem('user-id')
            })
            .then( response => { 
                
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        },
        SaveTechnology(){
            this.loading = true
            // Update customer
            axios.put('api/infotech/' + sessionStorage.getItem('user-id'), { 
                tags: this.selected, user_id: sessionStorage.getItem('user-id')
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
                this.$router.push('profile')
            })
        },
        SaveInfoAndTech(){
            this.SaveInformation()
            this.SaveTechnology()
        },
    },
}
</script>
