//Main
import Main from './components/main/Main.vue'
import Landing from './components/main/Landing.vue'
import About from './components/main/About.vue'
import Communities from './components/main/Communities.vue'
import News from './components/main/News.vue'
import Event from './components/main/Event.vue'
import Signin from './components/main/Signin.vue'
import Signup from './components/main/Signup.vue'
import Home from './components/main/Home.vue'
//User
import Information from './components/home/User/Information.vue'
import Profile from './components/home/User/Profile.vue'
//Admin
import Dashboard from './components/home/Admin/Dashboard.vue'
import UserList from './components/home/Admin/Users.vue'
import Events from './components/home/Admin/EventList.vue'
import Community from './components/home/Admin/CommunityList.vue'
import Tech from './components/home/Admin/Technology.vue'

export const routes = [
    { path: '/', name: 'main', component: Main, 
        children: [
            { path: '/', name: 'landing', components: {main: Landing}},
            { path: '/about', name: 'about', components: {main: About}},
            { path: '/communities', name: 'communities', components: {main: Communities}},
            { path: '/news', name: 'news', components: {main: News}},
            { path: '/event', name: 'event', components: {main: Event}},
            { path: '/signin', name: 'Signin', components: {main: Signin}},
            { path: '/signup', name: 'Signup', components: {main: Signup}},
            { path: '/home', name: 'home', components: {main: Home},
                children: [
                    //Admin
                    { path: '/dashboard', name: 'dashboard', components: {home: Dashboard}},
                    { path: '/technology', name: 'technology', components: {home: Tech}},
                    { path: '/community', name: 'community', components: {home: Community}},
                    { path: '/users', name: 'users', components: {home: UserList}},
                    { path: '/events', name: 'events', components: {home: Events}},
                    //User
                    { path: '/profile', name: 'profile', components: {home: Profile}},
                    { path: '/info', name: 'information', components: {home: Information}},
                ]
            },
        ]
    },
    
]