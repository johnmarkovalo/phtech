<template>
  <v-layout row>
      <v-flex col-12 >
        <v-card class="mt-1 elevation-0">
          <v-toolbar color="primary">
            <v-toolbar-title class="display-1 white--text">Find events you're interested with</v-toolbar-title>
            <!-- <v-icon x-large>information</v-icon> -->
          </v-toolbar>
          <v-tabs color="primary" icons-and-text grow>
            <!-- Tab for List -->
            <v-tab href="#tab-1">
                List
                <v-icon>mdi-menu</v-icon>
            </v-tab>
            
            <!-- Tab for Calendar -->
            <v-tab href="#tab-2">
                Calendar
                <v-icon>mdi-calendar</v-icon>
            </v-tab>
            
            <!-- Tab Value for List -->
            <v-tab-item :value="'tab-' + 1">
              <v-card class="mt-5 elevation-0">
                <v-toolbar flat align="center">
                  <v-icon medium color="primary">fas fa-search</v-icon>
                  <v-toolbar-title class="hidden-sm-and-down display-1">Search Using Event:</v-toolbar-title>
                  <!-- <v-flex xs="12" md="5">
                      <v-autocomplete dense v-model="selected" :disabled="isUpdating" :items="tags"
                        filled chips color="primary" class="transparent mt-6"
                        item-text="name" item-value="name" multiple rounded>
                        <template v-slot:selection="data">
                            <v-chip
                            v-bind="data.attrs"
                            :input-value="data.selected"
                            close
                            @click="data.select"
                            @click:close="remove(data.item)"
                            >
                            <v-avatar left>
                                <v-img :src="data.item.avatar"></v-img>
                            </v-avatar>
                            {{ data.item.name }}
                            </v-chip>
                        </template>
                        <template v-slot:item="data">
                            
                            <template v-if="typeof data.item !== 'object'">
                            <v-list-item-content v-text="data.item"></v-list-item-content>
                            </template>
                            <template v-else>
                            <v-list-item-avatar>
                                <img :src="data.item.avatar">
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle>
                            </v-list-item-content>
                            </template>
                        </template>
                      </v-autocomplete>
                  </v-flex> -->
                </v-toolbar>
                <v-card-text>
                  <v-container fluid>
                      <v-row dense>
                        <v-col v-for="event in events" :key="event.title" cols="12" lg="3" xl="3" md="3">
                          <v-hover v-slot:default="{ hover }">
                            <v-card :elevation="hover ? 12 : 2" @click="visit_event(event.community['0'].name,event.code)">
                              <v-img :src="event.photo" class="white--text align-end" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px">
                              </v-img>
                              <v-card-text> 
                                <p class="title teal--text text--darken-2">{{event.start | eventDate}}</p>
                                <p class="headline white--text">{{event.name}}</p>
                                <p class="subtitle-1">{{event.location.formatted_address}}</p>
                                <v-chip v-for="item in card.community" v-bind:key="item.id" color="primary" outlined>
                                    <v-icon left>
                                      mdi-account-group
                                    </v-icon>
                                    {{item['name']}}
                                  </v-chip>
                              </v-card-text>

                              <v-card-actions>
                                <v-spacer></v-spacer>

                                <v-btn v-if="event.position == 'pending'" rounded outlined color="primary" width="5vw" >Attend</v-btn>
                                <v-btn v-else-if="event.position == 'going' || event.position == 'organizer'" rounded outlined color="success" width="5vw">Going</v-btn>
                                <v-btn v-else-if="event.position == 'notgoing'" rounded outlined color="error" width="5vw">Not Going</v-btn>
                              </v-card-actions>
                            </v-card>
                          </v-hover>
                        </v-col>
                      </v-row>
                  </v-container>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <!-- Tab Value for Calendar -->
            <v-tab-item :value="'tab-' + 2">
              <v-row class="fill-height">
                <v-col>
                  <v-sheet height="64">
                    <v-toolbar flat dark color="primary">
                      <v-btn fab text small @click="prev">
                        <v-icon small>mdi-chevron-left</v-icon>
                      </v-btn>
                      <v-btn fab text small @click="next">
                        <v-icon small>mdi-chevron-right</v-icon>
                      </v-btn>
                      <v-toolbar-title>{{ title }}</v-toolbar-title>
                      <div class="flex-grow-1"></div>
                      <v-btn outlined @click="modal = true">
                        <span>{{ title }}</span>
                        <v-icon right>mdi-menu</v-icon>
                      </v-btn>
                      <v-dialog ref="dialogfrom" v-model="modal" persistent width="290px">
                          <v-date-picker v-model="focus" type="month">
                              <v-spacer></v-spacer>
                              <v-btn text color="primary" @click="modal = false">OK</v-btn>
                          </v-date-picker>
                      </v-dialog>
                    </v-toolbar>
                  </v-sheet>
                  <v-sheet height="600">
                    <v-calendar ref="calendar" v-model="focus" color="primary" :events="events" :event-color="getEventColor"
                      :event-margin-bottom="3"  :type="type" @click:event="showEvent"
                      @change="updateRange"
                    ></v-calendar>
                  </v-sheet>
                </v-col>
              </v-row>
            </v-tab-item>
          </v-tabs>
        </v-card>
      </v-flex>
  </v-layout>
</template>
<script>
  export default {
    data: () => ({
      events: [],
      tags: [],
      selected: [],
      modal: false,
      focus: null,
      type: 'month',
      start: null,
      end: null,
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
    }),
    computed: {
      title () {
        const { start, end } = this
        if (!start || !end) {
          return ''
        }

        const startMonth = this.monthFormatter(start)

        const startYear = start.year

        const startDay = start.day + this.nth(start.day)

        switch (this.type) {
          case 'month':
            return `${startMonth} ${startYear}`
          case 'day':
            return `${startMonth} ${startDay} ${startYear}`
        }
        return ''
      },
      monthFormatter () {
        return this.$refs.calendar.getFormatter({
          timeZone: 'UTC', month: 'long',
        })
      },
    },
    mounted () {
      this.$refs.calendar.checkChange();
    },
    methods: {
      visit_event(community_name,event_code){
          this.$router.push('/'+community_name.split(' ').join('_')+'/events'+'/'+event_code)
      },
      retrieveEvent(){
          axios.get('/api/event' ,
          {
            params: {
              id: sessionStorage.getItem('user-id'),
            }
          })
          .then( response => {
              this.events = response.data.event
          })
          .catch( error => { alert(error)})
      },
      retrieveTags() {
          axios.get('/api/technology')
          .then( response => {
              this.tags = response.data.tags
          })
          .catch( error => { alert(error)})
      },
      visit_community(community_name)
      {
          this.$router.push('/community/'+community_name.split(' ').join('_'))
      },
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.focus = this.today
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => this.selectedOpen = true, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      updateRange ({ start, end }) {
        // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
        this.start = start
        this.end = end
      },
      nth (d) {
        return d > 3 && d < 21
          ? 'th'
          : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
      },
      remove (item) {
          const index = this.selected.indexOf(item.name)
          if (index >= 0) this.selected.splice(index, 1)
      },
    },
    created() {
      this.retrieveTags();
      this.retrieveEvent();
      this.focus = new Date().toLocaleString();
    },
  }
</script>