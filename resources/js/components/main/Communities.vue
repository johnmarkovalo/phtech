<template>
  <v-layout row>
      <v-flex col-12 >
        <v-card class="mt-5">
            <v-toolbar flat align="center">
            <v-icon medium color="primary">fas fa-search</v-icon>
            <v-toolbar-title class="hidden-sm-and-down display-1">Search Using Tags:</v-toolbar-title>
            <v-flex xs="12" md="5">
                <v-autocomplete dense v-model="selected" :disabled="isUpdating" :items="tags"
                    filled chips color="primary" class="transparent"
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
                    :key="card.title"
                    cols="12" lg="3" xl="3" md="3"
                    >
                    <v-card>
                        <v-img
                        :src="card.src"
                        class="white--text align-end"
                        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                        height="200px"
                        >
                        </v-img>
                        <v-card-text> 
                        <p class="title teal--text text--lighten-2">Monday Tuesday</p>
                        <p class="headline white--text">Top western road trips</p>
                        <p class="subtitle-1">Don Alfaro St, Tetuan Zamboanga City</p>
                        </v-card-text>

                        <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn icon>
                            <v-icon>mdi-heart</v-icon>
                        </v-btn>

                        <v-btn icon>
                            <v-icon>mdi-bookmark</v-icon>
                        </v-btn>

                        <v-btn icon>
                            <v-icon>mdi-share-variant</v-icon>
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-col>
                </v-row>
                </v-container>
            </v-card-text>
        </v-card>
      </v-flex>
  </v-layout>
</template>
<script>
  export default {
    data: () => ({
      cards: [
        { title: 'Pre-fab homes', src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg'},
        { title: 'Favorite road trips', src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg'},
        { title: 'Best airlines', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg'},
        { title: 'Best airlines', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg'},
      ],
    }),
    computed: {
    },
    mounted () {
    },
    methods: {
    },
    created() {
    },
  }
</script>