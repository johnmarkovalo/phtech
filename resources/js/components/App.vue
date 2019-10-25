<template>
    <v-app>
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </v-app>
</template>
<script src="/js/app.js"></script>
<script>
    export default {
        data(){
            return {
                // isLoggedIn : null,
            }
        },
        mounted(){
            // this.isLoggedIn = sessionStorage.getItem('user-id')
            
        }
    }
</script>
