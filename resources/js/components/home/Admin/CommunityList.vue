<template>
  <v-layout row>
      <v-flex col-12 >
        <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="tags" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat >
                    <v-icon color="primary" x-large>mdi-account-group</v-icon>
                    <v-toolbar-title class="display-1">Tech Community</v-toolbar-title>
                    <v-divider  class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on }">
                            <v-btn rounded outlined large color="success" v-on="on">
                                <v-icon left>fa-plus</v-icon> Technology Tags
                            </v-btn>
                        </template>

                        <v-card>
                            <v-overlay :value="loading">
                                <v-progress-circular :size="100" :width="5" color="light-green accent-4" indeterminate></v-progress-circular>
                            </v-overlay>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-text-field outlined required clearable autofocus v-model="editedTag.name" label="Name"></v-text-field>
                                    <v-textarea outlined required clearable v-model="editedTag.description" label="Descripton"></v-textarea>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <div class="flex-grow-1"></div>
                                <v-btn rounded outlined color="error" @click="cancel">Cancel</v-btn>
                                <v-btn rounded color="success" @click="saveTags">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editTags(item)">fa-edit</v-icon>
                <v-icon small class="mr-2" @click="deleteTags(item)">fa-trash-alt</v-icon>
            </template>
        </v-data-table>
      </v-flex>
  </v-layout>
</template>
<script>
import { log } from 'util'
export default {
    data() {
        return {
            dialog: false,
            loading: false,
            editedIndex: -1,
            defaultTag: { name: null, description: null,},
            editedTag: { name: null, description: null,},
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Name', value: 'name'},
                {text: 'Description', value: 'description'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            tags: [],
        }
    },

    mounted() {
        this.retrieveTags()
    },
    
    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Technology Tag' : 'Edit Technology Tag'
        },
    },

    watch: {
        dialog (val) {
            val || this.cancel()
        },
    },
    
    methods: {
        retrieveTags() {
            this.loading = true
            axios.get('/api/technology')
            .then( response => {
                this.tags = response.data.tags
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },

        editTags(item) {
            this.editedIndex = this.tags.indexOf(item)
            this.editedTag = Object.assign({}, item)
            this.dialog = true
        },

        deleteTags(item) {
            var itemDeletion = confirm('Are you sure you want to delete this tags?')
            if(itemDeletion == true) {
                axios.delete('/api/technology/' + item.id)
                .then( response => { 
                    const index = this.tags.indexOf(item)
                    this.tags.splice(index, 1)
                })
                .catch( error => { alert(error)})
            }
        },

        cancel() {
            this.dialog = false
            setTimeout(() => {
                this.editedTag = Object.assign({}, this.defaultTag)
                this.editedIndex = -1
            }, 500)
        },

        saveTags() {
            this.loading = true
            if (this.editedIndex > -1) {
                // Update customer
                axios.put('/api/technology/' + this.editedTag.id, { 
                    name: this.editedTag.name, description: this.editedTag.description,
                })
                .then( response => { 
                    Object.assign(this.tags[this.editedIndex], this.editedTag)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            } else {
                // Create New Technology Tag
                axios.post('/api/technology', { 
                    name: this.editedTag.name, description: this.editedTag.description,
                })   
                .then( response => { 
                    this.editedTag.id = response.data.tag.id
                    this.tags.push(this.editedTag)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            }
        }
    },
}
</script>