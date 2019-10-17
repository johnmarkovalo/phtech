<template>
    <v-app id="inspire" :dark="dark">
      <!-- Drawer Start -->
      <v-navigation-drawer width="250" clipped fixed v-model="drawer" app >
        <div class="d-flex flex-column justify-content-center align-items-center mt-3">
          <v-avatar size="150px" @click.stop="PicDialog = true">
            <cld-image :publicId="photo" >
              <cld-transformation width="1000" height="1000" border="5px_solid_rgb:ff8f00" gravity="face" radius="max" crop="fill"/> 
              <cld-transformation width="200" crop="scale" />
            </cld-image>
          </v-avatar>
          <p class="subheading font-weight-regular mt-1">{{name}} </p>
          <p class="subheading font-weight-regular" v-if='code != ""'>{{code}}</p>
          <div class="d-flex flex-row justify-content-center align-items-center">
            <v-icon color="amber darken-3" v-if="type == 'diamond'  || type == 'diabronze'">fas fa-gem</v-icon>
            <v-icon color="amber darken-3" v-if="type == 'bronze' || type == 'diabronze'">device_hub</v-icon>
          </div>
        </div>
        <!-- Profile Picture Dialog -->
        <v-dialog v-model="PicDialog">
          <div class="d-flex justify-content-center align-items-center">
            <cld-image :publicId="photo" >
              <cld-transformation width="1000" height="1000" border="5px_solid_rgb:ff8f00" gravity="face" radius="max" crop="fill"/> 
              <cld-transformation width="200" crop="scale" />
            </cld-image>
          </div>
        </v-dialog>
        <v-list rounded>
          <!-- Start Navigation List -->
          <v-list-item-group color="primary">
            <v-list-item ripple="ripple" exact to="/profile">
              <v-list-item-action>
                <v-icon>account_circle</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">My Profile</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/dashboard" v-if="!admin && !owner">
                <v-list-item-action>
                    <v-icon>dashboard</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Dashboard</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/staffs" v-if="owner">
                <v-list-item-action>
                    <v-icon>people</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Staffs</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/users" v-if="admin">
                <v-list-item-action>
                    <v-icon>people</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">User List</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/number" v-if="!admin && !owner">
              <v-list-item-action>
                <v-icon>filter_1</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">My Number</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/genealogy" v-if="!owner">
              <v-list-item-action>
                <v-icon>device_hub</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Genealogy</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/bracket" v-if="!owner">
              <v-list-item-action>
                <v-icon class="fa-rotate-180">fas fa-menorah</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title class="subheading font-weight-regular">Bracket</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/numbers" v-if="admin">
                <v-list-item-action>
                    <v-icon>filter_1</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">User Number List</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/inventory" v-if="owner || admin">
                <v-list-item-action>
                    <v-icon>view_quilt</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Inventory</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/sales" v-if="owner || admin">
                <v-list-item-action>
                    <v-icon>fas fa-file-invoice-dollar</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Sales</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/branches" v-if="admin">
                <v-list-item-action>
                    <v-icon>store</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Branches</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/keys" v-if="admin">
                <v-list-item-action>
                    <v-icon>vpn_key</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Keys</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/requests" v-if="admin">
                <v-list-item-action>
                    <v-icon>move_to_inbox</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Requests</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/wallet" v-if="!admin && !owner">
                <v-list-item-action>
                    <v-icon>account_balance_wallet</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Wallet</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item ripple="ripple" exact to="/points" v-if="!admin && type == 'bronze' || type == 'diabronze'">
                <v-list-item-action>
                    <v-icon>fas fa-coins</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Points</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item>
                <v-list-item-content>
                    <v-switch v-model="$vuetify.theme.dark" color="amber darken-3" label="Dark Mode"></v-switch>
                </v-list-item-content>
            </v-list-item>
            <v-list-item  ripple="ripple" @click="logout" rel="noopener">
                <v-list-item-action >
                    <v-icon>exit_to_app</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title class="subheading font-weight-regular">Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
        <!-- End Navigation List -->        
      </v-navigation-drawer>
        <!-- Drawer End -->        
        <!-- Navigation Bar -->        
       <v-app-bar app fixed clipped-left>
        <v-app-bar-nav-icon class="hidden-md-and-up" @click.stop="drawer = !drawer"><v-icon>menu</v-icon></v-app-bar-nav-icon>
        <v-toolbar-title class="hidden-sm-and-down">SecureLife International Corporation</v-toolbar-title>
        <v-spacer></v-spacer>
        {{time | myDate}}
         <v-menu transition="slide-x-transition" offset-y origin="center center" class="elelvation-1" :nudge-bottom="14" >
              <template v-slot:activator="{ on }">
              <v-btn icon text v-on="on" @click="markAsRead">
                  <v-badge color="red" overlap>
                      <span slot="badge">{{notifCount}}</span>
                      <v-icon medium>notifications</v-icon>
                  </v-badge>
              </v-btn>
              </template>
              <v-list two-line>
                <div v-for="notification in allNotifications" :key="notification.id">
                  <v-list-item ripple="ripple" exact to="/notification">
                    <v-list-item-avatar>
                        <v-icon size="40px" v-if="notification.type == 'UserRegistered'">person_add</v-icon>
                        <v-icon size="40px" v-else-if="notification.type == 'UserRegisterednoCode'">person_add</v-icon>
                        <v-icon size="40px" v-else-if="notification.type == 'UserActivated'">person_add</v-icon>
                        <v-icon size="40px" v-else-if="notification.type == 'KeyRequest'">vpn_key</v-icon>
                        <v-icon size="40px" color="success" v-else-if="notification.type == 'KeyApproved'">vpn_key</v-icon>
                        <v-icon size="40px" color="error" v-else-if="notification.type == 'KeyDisapproved'">vpn_key</v-icon>
                        <v-icon size="40px" v-else-if="notification.type == 'EncashRequest'">money</v-icon>
                        <v-icon size="40px" color="success" v-else-if="notification.type == 'EncashApproved'">money</v-icon>
                        <v-icon size="40px" color="error" v-else-if="notification.type == 'EncashDisapproved'">money</v-icon>
                        <v-icon size="40px" color="error " v-else-if="notification.type == 'UserExit'">exit_to_app</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title v-if="notification.type == 'UserRegistered'">User Registered</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'UserRegisterednoCode'">Proof of Payment</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'UserActivated'">User Activated</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'KeyRequest'">Key Request</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'KeyDisapproved'">Key Request Disapproved</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'KeyApproved'">Key Request Approved</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'EncashRequest'">Encashment Request</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'EncashDisapproved'">Encashment Request Disapproved</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'EncashApproved'">Encashment Request Approved</v-list-item-title>
                        <v-list-item-title v-else-if="notification.type == 'UserExit'">User Exit</v-list-item-title>
                        <v-list-item-sub-title v-if="notification.type == 'UserRegistered'">{{ notification.data.UserCreatedName }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'UserRegisterednoCode'">{{ notification.data.UserCreatedName }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'UserActivated'">{{ notification.data.UserActivatedName }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'KeyRequest'">{{ notification.data.message }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'KeyDisapproved'">{{ notification.data.message }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'KeyApproved'">{{ notification.data.message }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'UserExit' && admin == true">{{ notification.data.admin_message }}</v-list-item-sub-title>
                        <v-list-item-sub-title v-else-if="notification.type == 'UserExit' && admin == false">{{ notification.data.user_message }}</v-list-item-sub-title>
                    </v-list-item-content>
                    <v-spacer></v-spacer>
                    <v-list-item-action>
                        <v-list-item-action-text>{{ notification.created_at | myDate }}</v-list-item-action-text>
                    </v-list-item-action>
                  </v-list-item>
                  <v-divider inset></v-divider>
                </div>
                <v-btn small  text :ripple="false" :hover="false" exact to="/notification">Show All Notification</v-btn>
              </v-list>
          </v-menu>
      </v-app-bar>
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
      <v-footer app fixed>
        <span>&copy; SecureLife International Corporation 2019</span>
      </v-footer>
    </v-app>
</template>

<script src="/js/app.js"></script>
<script>
import { isNull } from 'util'
  export default {
    data(){
      return {
      time:'',
      type: '',
      name: localStorage.getItem('name'),
      photo: localStorage.getItem('photo'),
      userId: localStorage.getItem('id'),
      PicDialog: false,
      drawer: null,
      dark: true,
      allNotifications:[],
      admin: false,
      owner: false,
      code: '',
      pic: '',
      notifCount: 0
      }
    },
    props:['user'],

    computed: {
      profile_size () {
        switch (this.$vuetify.breakpoint.name) {
          case 'xs': return '400px'
          case 'sm': return '400px'
          case 'md': return '400px'
          case 'lg': return '600px'
          case 'xl': return '700px'
        }
      },
    },
    methods:{
      logout() {
        localStorage.clear();
        window.location.replace('/')
      },
      markAsRead(){
        axios.put('/api/notification/read/',
        {
          id: this.userId
        });
        this.notifCount=0
      },
      refresh(){
        if (localStorage.getItem('id'))
        {
          setTimeout(function()
          {
              localStorage.clear();
              window.location.replace('/')
          },100000)
        }
      }
    },
    created() {
      if (localStorage.getItem('role') == "admin" || localStorage.getItem('role') == "developer"){
        this.admin = true
      }
      else if (localStorage.getItem('role') == "owner")
      {
        this.owner = true
      }
      else{
        this.type = localStorage.getItem('type')
        this.admin =  false
        if (localStorage.getItem('code') == 'null')
        {
            this.code = ''
        }
        else
        {
          this.code = localStorage.getItem('code')
        }
      }
      axios.get('/api/notification/get_unread_notifs', {
        params: {
          id: this.userId
        }
      }).then(response=>{
        this.allNotifications=response.data.dta;
        this.notifCount = response.data.count
      })

      setInterval(() => {
          setInterval(() => {
              this.time = new Date().toLocaleString()
          }, 1000);
      }, 1000);
      
      // this.refresh()
      // document.addEventListener('click', this.refresh)
      // document.addEventListener('mousemove', this.refresh)
      // document.addEventListener('keypress', this.refresh)
    },
    beforeRouteEnter (to, from, next) {
      if (!localStorage.getItem('id')) {
          return next('login');
      }

      if (localStorage.getItem('status') == 'Inactive'){
        return next('/activate')
      }
      next();
    }
}
</script>
