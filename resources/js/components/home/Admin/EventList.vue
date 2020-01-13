<template>
  <v-layout row>
      <v-flex col-12 >
        <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="events" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat >
                    <v-icon color="primary" x-large>mdi-calendar</v-icon>
                    <v-toolbar-title class="display-1">Events</v-toolbar-title>
                    <v-divider  class="mx-4" inset vertical></v-divider>
                </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="BanEvent(item)">mdi-cancel</v-icon>
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
            loading: false,
            editedIndex: -1,
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Title', value: 'title'},
                {text: 'Description', value: 'description'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            events: [],
        }
    },

    mounted() {
        this.retrieveEvents()
    },
    
    computed: {
    },
    methods: {
        retrieveEvents() {
            this.loading = true
            axios.get('/api/event')
            .then( response => {
                this.events = response.data.allevents
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },

        BanEvent(item) {
            axios.put('/api/ban-event/' + item.id)
            .then( response => { 
                const index = this.events.indexOf(item)
                this.events.splice(index, 1)
            })
            .catch( error => { alert(error)})
        },
    },
}
</script>