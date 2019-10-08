//Main
import Main from './components/main/Main.vue'
import Landing from './components/main/Landing.vue'
import About from './components/main/About.vue'
import Communities from './components/main/Communities.vue'
import News from './components/main/News.vue'
import Event from './components/main/Event.vue'
import Signin from './components/main/Signin.vue'

export const routes = [
    { path: '/', name: 'main', component: Main, 
        children: [
            { path: '/', name: 'landing', components: {main: Landing}},
            { path: '/about', name: 'about', components: {main: About}},
            { path: '/communities', name: 'communities', components: {main: Communities}},
            { path: '/news', name: 'news', components: {main: News}},
            { path: '/event', name: 'event', components: {main: Event}},
            { path: '/signin', name: 'Signin', components: {main: Signin}},
        ]
    },
]