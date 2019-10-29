<template>
  <v-layout row>
      <v-flex col-12 >
        <v-card class="mt-1 elevation-0">
            <v-toolbar color="primary">
            <v-toolbar-title class="display-1">Find community you're interested with</v-toolbar-title>
                <!-- <v-icon x-large>information</v-icon> -->
            </v-toolbar>
            <v-card class="mt-5 elevation-0">
                <v-toolbar flat align="center">
                    <v-icon medium color="primary">fas fa-search</v-icon>
                <v-toolbar-title class="hidden-sm-and-down display-1">Search Using Tags:</v-toolbar-title>
                <v-flex xs="12" md="5">
                    <v-autocomplete dense v-model="selected" :items="tags"
                        filled chips color="primary" class="transparent mt-6"
                        item-text="name" item-value="name" multiple rounded>
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
                </v-flex>
                </v-toolbar>
                <v-card-text>
                <v-container fluid>
                    <v-row dense>
                        <v-col
                        v-for="card in cards"
                        :key="card.name"
                        cols="12" lg="3" xl="3" md="3"
                        >
                        <v-card>
                            <v-img
                                :src="card.photo"
                                class="white--text align-end"
                                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                height="200px"
                            >
                                <!-- <cld-image :publicId="card.photo">
                                <cld-transformation crop="fill"/> 
                                <cld-transformation crop="scale" />
                                </cld-image> -->
                            </v-img>
                            <v-card-text> 
                            <p class="headline teal--text text--lighten-2">{{card.name}}</p>
                            <p class="title white--text text-truncate">{{card.description}}</p>
                            <p class="subtitle-1">{{card.location.formatted_address}}</p>
                            </v-card-text>

                            <v-card-actions>
                            <v-spacer></v-spacer>

                            <v-btn outlined rounded color="primary" @click="visit_community(card.name)">
                                <v-icon small>mdi-card-bulleted-settings</v-icon>
                                View
                            </v-btn>

                            <v-btn outlined rounded color="primary">
                                <v-icon small>mdi-login</v-icon>
                                Join
                            </v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-card>
      </v-flex>
  </v-layout>
</template>
<script>
  export default {
    data: () => ({
      cards: [],
      tags: [],
      selected: [],
      community: [
        { title: 'Pre-fab homes', src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg'},
        { title: 'Favorite road trips', src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg'},
        { title: 'Best airlines', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg'},
        { title: 'Best Gwapo', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg'},
      ],

    }),
    computed: {
    },
    mounted () {
        this.retrieveCommunity()
        this.retrieveTags()
    },
    methods: {
        retrieveCommunity(){
            axios.get('api/community')
            .then( response => {
                this.cards = response.data.community
                // console.log(this.community);
                
            })
            .catch( error => { alert(error)})
        },
        retrieveTags() {
            axios.get('api/technology')
            .then( response => {
                this.tags = response.data.tags
            })
            .catch( error => { alert(error)})
        },
        visit_community(community_name)
        {
            this.$router.push('/community/'+community_name.split(' ').join('_'))
        },
    },
    created() {
    },
  }
</script>