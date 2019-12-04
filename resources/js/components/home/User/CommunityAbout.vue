<template>
    <div>
        <v-row justify=center>
            <v-col cols=12 lg=10>
                <p class="display-1 teal--text text--darken-2">About </p>
                <v-textarea readonly class="teal-text text--darken-2" v-model="community.description"
                ></v-textarea>
                <!-- <p class="title teal--text text--darken-2">{{community.description}} </p> -->
            </v-col>
        </v-row>
    </div>
</template>
<script>
  export default {
    props: [ 
      'community',
    ],
    computed: {
    },
    created () {
        
    },
  }
</script>