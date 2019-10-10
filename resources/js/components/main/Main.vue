<template>
    <div class="container-fluid pa-0 pb-2">
        <v-app-bar hide-on-scroll app>
            <v-img src="img/Phtech.png" max-width="200px" alt="avatar"/>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn text href="/"><v-icon color="blue darken-3" left>home</v-icon>HOME</v-btn>
                <v-btn text href="/about"><v-icon color="blue darken-3" left>info</v-icon>ABOUT</v-btn>
                <v-btn text href="/communities"><v-icon color="blue darken-3" left>group</v-icon>COMMMUNITIES</v-btn>
                <v-btn text href="/news"><v-icon color="blue darken-3" left>fas fa-newspaper</v-icon>NEWS</v-btn>
                <v-btn text href="/event"><v-icon color="blue darken-3" left>event_note</v-icon>EVENTS</v-btn>
                <v-btn text href="/signin"><v-icon color="blue darken-3" left>person_add</v-icon>SIGN-IN</v-btn>
                <v-btn text href="/logout"><v-icon color="blue darken-3" left>exit_to_app</v-icon>LOGOUT</v-btn>
                <!-- <v-btn text href='dashboard' v-show='this.$parent.isLoggedIn'><v-icon color="amber darken-3" left>dashboard</v-icon>MY DASHBOARD</v-btn> -->
                <!-- <v-btn text @click="logout" v-show='this.$parent.isLoggedIn'><v-icon color="amber darken-3" left>exit_to_app</v-icon>LOGOUT</v-btn> -->
            </v-toolbar-items>
        </v-app-bar>
        <main class="pt-5 mt-5 pb-0">
           <router-view class="mt-5" name="main"></router-view>
        </main>
    </div>
</template>
<script>
    export default {
        data: () => ({
            // cashier: false,
            // branch_name: ''
        }),
        methods:{
            // logout(){
            //     localStorage.clear();
            //     window.location.replace('/')
            // },
            // refresh(){
            //     setTimeout(function()
            //     {
            //         localStorage.clear();
            //         window.location.replace('/')
            //     },30000)
            // }
        },
        created(){
            // axios.post('/api/roles');
            // if (localStorage.getItem('type') == 'cashier')
            // {
            //     this.cashier = true
            //     this.branch_name = 'cashier/'+localStorage.getItem('branch_name').replace(' ', '_')
            // }
            
            // this.refresh()
            // document.addEventListener('click', this.refresh)
            // document.addEventListener('mousemove', this.refresh)
        }
    }
</script>
