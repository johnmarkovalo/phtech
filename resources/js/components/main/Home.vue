<template>
    <div>
     <!-- Container List -->        
      <v-content>
        <v-container class="fill-height" fluid>
          <!-- <v-layout> -->
            <!-- <v-flex> -->
              <router-view name="home"></router-view>
            <!-- </v-flex> -->
          <!-- </v-layout> -->
        </v-container>
      </v-content>
    </div>
</template>

<script src="/js/app.js"></script>
<script>
import { isNull } from 'util'
  export default {
    data(){
      return {
      }
    },
    computed: {
    },
    methods:{
    },
    created() {
    }
}
</script>
