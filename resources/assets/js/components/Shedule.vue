<template>
    <div>
        <vue-timepicker v-model="timeValue" format="hh:mm A" @change="timeChangeHandler" hide-clear-button></vue-timepicker>

        <div>
            <table class = "table table-hover">
                <tr>
                   <th> Event</th>
                   <th> Day </th>
                   <th> Time </th>
                   <th> Duration </th>
                   <th> Location</th>
                   <th> Action</th>
               </tr>
               <tr v-for="event in events">
                   <td> {{event.title}} </td>
                   <td> {{event.day}} </td>
                   <td> {{event.time}} </td>
                   <td> {{event.duration}} </td>
                   <td> {{event.location}} </td>
                   <td> <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
                    <i class="glyphicon glyphicon-trash" ></i> Delete
                </button> </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                events: this.events,
                timeValue: {
                    HH: "10",
                    mm: "05",
                    ss: "00"
                  }
            }
        },
        components: { VueTimepicker },
        methods: {
          timeChangeHandler (eventData) {
            console.log(eventData);
          }
        },
        created() {
           this.$http.get('api/events')
                .then((response) => {
                    this.events = response.data;
                    console.log(response.data);
                })
                .catch((error) => {
                    if (error.response) {
                        console.log(error.response);
                    } else {
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
         });
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>