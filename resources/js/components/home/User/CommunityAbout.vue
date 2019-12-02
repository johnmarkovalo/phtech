<template>
    <div>
        <v-row justify=center>
            <v-col cols=12 lg=10>
                <p class="display-1 teal--text text--darken-2">About </p>
                <p class="title teal--text text--darken-2">{{community.description}} </p>
            </v-col>
        </v-row>
    </div>
</template>
<script>
  export default {
    props: [ 'community' ],
  }
</script>