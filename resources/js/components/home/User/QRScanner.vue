<template>
    <v-container fluid>
        <v-card class="transparent elevation-0">
            <v-card-text>
                <v-row>
                    <qrcode-stream @decode="onDecode" @init="onInit" /> 
                    <!-- <v-col>
                        <p class="error">{{ error }}</p>
                        <p class="decode-result">Last result: <b>{{ result }}</b></p>
                    </v-col> -->
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
    import moment from 'moment';
  export default {
    data: () => ({
        result: '',
        error: ''
    }),
    methods: {
        onDecode (result) {
            this.result = result
            this.check()
            // alert('fck')
        },

        async onInit (promise) {
            try {
                await promise
            } catch (error) {
                if (error.name === 'NotAllowedError') {
                this.error = "ERROR: you need to grant camera access permisson"
                } else if (error.name === 'NotFoundError') {
                this.error = "ERROR: no camera on this device"
                } else if (error.name === 'NotSupportedError') {
                this.error = "ERROR: secure context required (HTTPS, localhost)"
                } else if (error.name === 'NotReadableError') {
                this.error = "ERROR: is the camera already in use?"
                } else if (error.name === 'OverconstrainedError') {
                this.error = "ERROR: installed cameras are not suitable"
                } else if (error.name === 'StreamApiNotSupportedError') {
                this.error = "ERROR: Stream API is not supported in this browser"
                }
            }
        },
        check(){
            this.$Progress.start();
            axios.put('/api/event/check-attendance/'+this.$route.params.event_code, { 
                qrcode: this.result,
                code: this.$route.params.event_code
            })   
            .then( response => { 
                this.$Progress.finish();
                swal.fire(
                    'Success!',
                    'Successfully check attendance of ' + response.data.success.user.name,
                    'success'
                )
            })
            .catch(error => {
                this.$Progress.fail();
                swal.fire(
                    'Error!',
                    error.response.data.errors[0],
                    'error'
                )
            })
        }
    },
    created() {

    },
  }
</script>