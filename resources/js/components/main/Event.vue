<template>
  <v-layout row>
      <v-flex col-12 >
        <v-card class="mt-1 elevation-0">
          <v-toolbar color="primary">
            <v-toolbar-title class="display-1">Find events you're interested with</v-toolbar-title>
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
                  <v-toolbar-title class="hidden-sm-and-down display-1">Search Using Tags:</v-toolbar-title>
                  <v-flex xs="12" md="5">
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
                            <!-- <v-avatar left>
                                <v-img :src="data.item.avatar"></v-img>
                            </v-avatar> -->
                            {{ data.item.name }}
                            </v-chip>
                        </template>
                        <template v-slot:item="data">
                            
                            <template v-if="typeof data.item !== 'object'">
                            <v-list-item-content v-text="data.item"></v-list-item-content>
                            </template>
                            <template v-else>
                            <!-- <v-list-item-avatar>
                                <img :src="data.item.avatar">
                            </v-list-item-avatar> -->
                            <v-list-item-content>
                                <v-list-item-title v-html="data.item.name"></v-list-item-title>
                                <!-- <v-list-item-subtitle v-html="data.item.group"></v-list-item-subtitle> -->
                            </v-list-item-content>
                            </template>
                        </template>
                      </v-autocomplete>
                  </v-flex>
                </v-toolbar>
                <v-card-text>
                  <v-container fluid>
                      <v-row dense>
                        <v-col
                          v-for="card in cards"
                          :key="card.title"
                          cols="12" lg="3" xl="3" md="3"
                        >
                          <v-card>
                            <v-img
                              :src="card.src"
                              class="white--text align-end"
                              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                              height="200px"
                            >
                            </v-img>
                            <v-card-text> 
                              <p class="title teal--text text--lighten-2">Monday Tuesday</p>
                              <p class="headline white--text">Top western road trips</p>
                              <p class="subtitle-1">Don Alfaro St, Tetuan Zamboanga City</p>
                            </v-card-text>

                            <v-card-actions>
                              <v-spacer></v-spacer>

                              <v-btn icon>
                                <v-icon>mdi-heart</v-icon>
                              </v-btn>

                              <v-btn icon>
                                <v-icon>mdi-bookmark</v-icon>
                              </v-btn>

                              <v-btn icon>
                                <v-icon>mdi-share-variant</v-icon>
                              </v-btn>
                            </v-card-actions>
                          </v-card>
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
                        <v-icon small>keyboard_arrow_left</v-icon>
                      </v-btn>
                      <v-btn fab text small @click="next">
                        <v-icon small>keyboard_arrow_right</v-icon>
                      </v-btn>
                      <v-toolbar-title>{{ title }}</v-toolbar-title>
                      <div class="flex-grow-1"></div>
                      <v-btn outlined @click="modal = true">
                        <span>{{ title }}</span>
                        <v-icon right>menu</v-icon>
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
                    <v-menu v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement" offset-x>
                      <v-card color="grey lighten-4" min-width="350px" flat>
                        <v-toolbar :color="selectedEvent.color" dark>
                          <v-btn icon>
                            <v-icon>edit</v-icon>
                          </v-btn>
                          <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                          <div class="flex-grow-1"></div>
                          <v-btn icon>
                            <v-icon>favorite</v-icon>
                          </v-btn>
                          <v-btn icon>
                            <v-icon>more_vert</v-icon>
                          </v-btn>
                        </v-toolbar>
                        <v-card-text>
                          <span v-html="selectedEvent.details"></span>
                        </v-card-text>
                        <v-card-actions>
                          <v-btn text color="secondary"  @click="selectedOpen = false">
                            Cancel
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-menu>
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
      cards: [
        { title: 'Pre-fab homes', src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg'},
        { title: 'Favorite road trips', src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg'},
        { title: 'Best airlines', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg'},
        { title: 'Best airlines', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg'},
      ],
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
      events: [
        {
          name: 'Vacation',
          details: 'Going to the beach!',
          start: '2018-12-29',
          end: '2019-01-01',
          color: 'blue',
        },
        {
          name: 'Meeting',
          details: 'Spending time on how we do not have enough time',
          start: '2019-01-07 09:00',
          end: '2019-01-07 09:30',
          color: 'indigo',
        },
        {
          name: 'Large Event',
          details: 'This starts in the middle of an event and spans over multiple events',
          start: '2018-12-31',
          end: '2019-01-04',
          color: 'deep-purple',
        },
        {
          name: '3rd to 7th',
          details: 'Testing',
          start: '2019-01-03',
          end: '2019-01-07',
          color: 'cyan',
        },
        {
          name: 'Big Meeting',
          details: 'A very important meeting about nothing',
          start: '2019-01-07 08:00',
          end: '2019-01-07 11:30',
          color: 'red',
        },
        {
          name: 'Another Meeting',
          details: 'Another important meeting about nothing',
          start: '2019-01-07 10:00',
          end: '2019-01-07 13:30',
          color: 'brown',
        },
        {
          name: '7th to 8th',
          start: '2019-01-07',
          end: '2019-01-08',
          color: 'blue',
        },
        {
          name: 'Lunch',
          details: 'Time to feed',
          start: '2019-01-07 12:00',
          end: '2019-01-07 15:00',
          color: 'deep-orange',
        },
        {
          name: '30th Birthday',
          details: 'Celebrate responsibly',
          start: '2019-01-03',
          color: 'teal',
        },
        {
          name: 'New Year',
          details: 'Eat chocolate until you pass out',
          start: '2019-01-01',
          end: '2019-01-02',
          color: 'green',
        },
        {
          name: 'Conference',
          details: 'The best time of my life',
          start: '2019-01-21',
          end: '2019-01-28',
          color: 'grey darken-1',
        },
        {
          name: 'Hackathon',
          details: 'Code like there is no tommorrow',
          start: '2019-01-30 23:00',
          end: '2019-02-01 08:00',
          color: 'black',
        },
        {
          name: 'event 1',
          start: '2019-01-14 18:00',
          end: '2019-01-14 19:00',
          color: '#4285F4',
        },
        {
          name: 'event 2',
          start: '2019-01-14 18:00',
          end: '2019-01-14 19:00',
          color: '#4285F4',
        },
        {
          name: 'event 5',
          start: '2019-01-14 18:00',
          end: '2019-01-14 19:00',
          color: '#4285F4',
        },
        {
          name: 'event 3',
          start: '2019-01-14 18:30',
          end: '2019-01-14 20:30',
          color: '#4285F4',
        },
        {
          name: 'event 4',
          start: '2019-01-14 19:00',
          end: '2019-01-14 20:00',
          color: '#4285F4',
        },
        {
          name: 'event 6',
          start: '2019-01-14 21:00',
          end: '2019-01-14 23:00',
          color: '#4285F4',
        },
        {
          name: 'event 7',
          start: '2019-01-14 22:00',
          end: '2019-01-14 23:00',
          color: '#4285F4',
        },
      ],
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
      retrieveTags() {
        axios.get('api/technology')
        .then( response => {
            this.tags = response.data.tags
        })
        .catch( error => { alert(error)})
      },
      remove (item) {
          const index = this.selected.indexOf(item.name)
          if (index >= 0) this.selected.splice(index, 1)
      },
    },
    created() {
      this.retrieveTags();
      this.focus = new Date().toLocaleString();
    },
  }
</script>