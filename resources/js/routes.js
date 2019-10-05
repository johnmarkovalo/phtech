//Main
import Main from './components/main/Main.vue'
import Landing from './components/main/Landing.vue'

export const routes = [
    { path: '/', name: 'main', component: Main, 
        children: [
            { path: '/', name: 'landing', components: {main: Landing}},
        ]
    },
]