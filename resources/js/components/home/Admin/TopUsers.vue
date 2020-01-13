<template>
  <v-layout row>
      <v-flex col-12 >
        <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="users" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat >
                    <v-icon color="primary" x-large>fas fa-award</v-icon>
                    <v-toolbar-title class="display-1">Top Users</v-toolbar-title>
                    <v-divider  class="mx-4" inset vertical></v-divider>
                </v-toolbar>
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
                {text: 'Name', value: 'name'},
                {text: 'Points', value: 'point'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            users: [],
        }
    },

    mounted() {
        this.retrieveUsers()
    },
    
    computed: {
    },
    methods: {
        retrieveUsers() {
            this.loading = true
            axios.get('/api/top-users')
            .then( response => {
                this.users = response.data.users
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },

        BanUser(item) {
            axios.put('/api/ban-user/' + item.id)
            .then( response => { 
                const index = this.users.indexOf(item)
                this.users.splice(index, 1)
            })
            .catch( error => { alert(error)})
        },
    },
}
</script>