//Main
import Main from './components/main/Main.vue'
import Landing from './components/main/Landing.vue'
import Event from './components/main/Event.vue'
import Signin from './components/main/Signin.vue'

export const routes = [
    { path: '/', name: 'main', component: Main, 
        children: [
            { path: '/', name: 'landing', components: {main: Landing}},
            { path: '/event', name: 'Event', components: {main: Event}},
            { path: '/signin', name: 'Signin', components: {main: Signin}},
        ]
    },
]