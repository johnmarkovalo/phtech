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
import Admin from './components/main/Admin.vue'
//User
import Dashboard from './components/home/Dashboard.vue'
import Information from './components/home/Information.vue'
import Events from './components/home/Event.vue'
//Admin
import AdminDashboard from './components/admin/AdminDashboard.vue'

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
                    { path: '/dashboard', name: 'dashboard', components: {home: Dashboard}},
                    { path: '/info', name: 'information', components: {home: Information}},
                    { path: '/events', name: 'event', components: {home: Events}},
                ]
            },
            { path: '/admin', name: 'admin', components: {main: Admin},
                children: [
                    { path: '/admin/dashboard', name: 'admindashboard', components: {admin: AdminDashboard}},
                ]
            },
        ]
    },
    
]