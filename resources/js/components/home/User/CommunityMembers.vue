<template>
    <div>
        <v-row justify=center>
            <v-col cols12 lg=10>
                <p class="display-1 teal--text text--darken-2">Members</p>
            </v-col>
        </v-row>
        <v-row dense justify=center>
            <v-col cols=12 lg=10>
                <v-row>
                    <v-list two-line>
                        <v-list-item v-for="attendee in members" :key="attendee.name">
                            <cld-image :publicId="attendee.avatar" width="50" class="mr-2">
                                <cld-transformation width="2000" height="2000" border="5px_solid_rgb:4DB6AC" gravity="face" radius="max" crop="thumb" fetchFormat="png"/>
                            </cld-image>
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
                                        <v-list-item ripple="ripple" @click="remove_member(attendee.id)">
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
        'community'
    ],
    methods: {
        visit_event(community_name,event_code){
            this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
        },
        remove_member(member){
            axios.put('/api/community/remove-member/'+this.community.id, {
                member: member,
            })
            .then( response => {
                // this.members = response.data.members
                this.$emit('updateCommunity')
                // this.$emit('update:members', response.data.members)
            })
            .catch( error => { alert(error)})
        },
    }
  }
</script>