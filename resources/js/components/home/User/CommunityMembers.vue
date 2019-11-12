<template>
    <div>
        <v-row justify=center>
            <v-col cols12 lg=10>
                <p class="display-1 teal--text text--lighten-2">Members</p>
            </v-col>
        </v-row>
        <v-row dense justify=center>
            <v-col cols=12 lg=10>
                <v-row>
                    <v-list two-line>
                        <v-list-item v-for="attendee in members" :key="attendee.name">
                            <v-list-item-avatar>
                                <cld-image :publicId="attendee.avatar" >
                                    <cld-transformation width="1000" height="1000" gravity="face" radius="max" crop="fill"/> 
                                    <cld-transformation width="200" crop="scale" />
                                </cld-image>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{attendee.name}}</v-list-item-title>
                                <v-list-item-subtitle>{{attendee.created_at | eventDate}}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-menu transition="slide-y-transition" offset-y nudge-width="100px" :close-on-content-click="false">
                                    <template v-slot:activator="{ on }" :close-on-click="false">
                                        <v-btn icon color="primary" v-on="on">
                                        <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list two-line>
                                        <v-list-item ripple="ripple" @click="ChangeRole(attendee.id)">
                                            <v-list-item-content>
                                                <v-list-item-title>Change Role</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item ripple="ripple" @click="removeMember(attendee.id)">
                                            <v-list-item-content>
                                                <v-list-item-title>Remove from Community</v-list-item-title>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-row>
            </v-col>
        </v-row>
    </div>
</template>
<script>
  export default {
    props: [
        'members',
    ],
    methods: {
        visit_event(community_name,event_code){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
    }
  }
</script>