<template>
  <v-layout row>
      <v-flex col-12 >
        <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="communities" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat >
                    <v-icon color="primary" x-large>mdi-account-group</v-icon>
                    <v-toolbar-title class="display-1">Communities</v-toolbar-title>
                    <v-divider  class="mx-4" inset vertical></v-divider>
                </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="BanCommunity(item)">mdi-cancel</v-icon>
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
                {text: 'Description', value: 'description'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            communities: [],
        }
    },

    mounted() {
        this.retrieveCommunities()
    },
    
    computed: {
    },
    methods: {
        retrieveCommunities() {
            this.loading = true
            axios.get('/api/community')
            .then( response => {
                this.communities = response.data.community
            })
            .catch( error => { alert(error)})
            .finally( x => {this.loading = false})
        },

        BanCommunity(item) {
            axios.put('/api/ban-community/' + item.id)
            .then( response => { 
                const index = this.communities.indexOf(item)
                this.communities.splice(index, 1)
            })
            .catch( error => { alert(error)})
        },
    },
}
</script>