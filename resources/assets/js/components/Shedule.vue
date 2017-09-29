<template>
    <div>
        
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
                   <td> {{intToDay(event.weekday)}} </td>
                   <td> {{minToHrs(event.time)}} </td>
                   <td> {{minToHrs(event.duration)}} </td>
                   <td> {{event.location}} </td>
                   <td> <button class="btn btn-xs btn-danger" type="button" @click="deleteEvent(event.id)">
                    <i class="glyphicon glyphicon-trash" ></i> Delete
                </button> </td>
                </tr>
                <tr>
                    <td><input type="text" placeholder="Name" class="form-control" v-model="title"></td>
                <td>
                    <select  class="form-control" id="sel2" v-model="weekDay">
                    <option value="1" selected >Sun</option>
                    <option value="2"  >Mon</option>
                    <option value="4"  >Tue</option>
                    <option value="8"  >Wed</option>
                    <option value="16"  >Thu</option>
                    <option value="32"  >Fri</option>
                    <option value="64"  >Sat</option>
                  </select>
                </td>
                    <td><vue-timepicker v-model="timeValue" format="hh:mm" @change="timeChangeHandler" hide-clear-button></vue-timepicker></td>
                    <td><vue-timepicker v-model="durationValue" format="hh:mm" @change="durationChangeHandler" hide-clear-button></vue-timepicker></td>
                    <td><input type="text" placeholder="Location" class="form-control" v-model="location"></td>
                    <td><button @click="postDataHandeler">Add Event</button></td>
                </tr>                
            </table>
              <div class="alert"
                     v-bind:class="{ 'alert-success': isSuccess, 'alert-danger': hasError }">
                    {{errMsg}}
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                events: this.events,
                timeValue: {
                    hh: "09",
                    mm: "05",
                    ss: "00"
                },
                durationValue: {
                    hh: "01",
                    mm: "05",
                    ss: "00"
                },
                'weekDay':'2',
                'title':'',
                'duration':'30',
                'location':'',
                'time':'0',
                'errMsg':"",
                hasError: false,
                isSuccess:false
            }
        },
        components: {
            VueTimepicker
        },
        methods: {
            timeChangeHandler(eventData) {
                this.time=( parseInt(eventData.data.h *60) + parseInt(eventData.data.m));
            },
            durationChangeHandler(eventData) {
                this.duration=( parseInt(eventData.data.h *60) + parseInt(eventData.data.m));
            },
            minToHrs(iMinutes){
                if(iMinutes  <60)
                    return "0:"+iMinutes+" hrs";
                else 
                    return parseInt(iMinutes/60) + ":"+parseInt(iMinutes % 60)+" hrs";
            },
            intToDay(idx){
                var days = ["Sun", "Mon", "Tue","Wed","Thu", "Fri", "Sat"];
                return days[idx];
            },
            deleteEvent(eId){ 
                this.errMsg ="";
                this.isSuccess=false;
                this.hasError=false;
                var fdta = {
                    'id':eId,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
                 console.log(fdta);
                this.$http.post('/api/event', fdta)
                    .then((response) => {
                        this.events = response.data;
                        console.log(response.data);
                        this.errMsg ="Success! Deleted the entry !";
                        this.isSuccess=true;
                    })
                    .catch((error) => {
                        this.errMsg ="Failed! Cannot delete the entry !";
                        this.hasError=true;
                        if (error.response) {
                            console.log(error.response);
                        } else {
                            console.log('Error', error.message);
                        }
                    });
            },
            postDataHandeler() {
                var self =this;
                this.errMsg ="";
                this.isSuccess=false;
                this.hasError=false;
                if(this.location.length ===0 && this.title.length ===0 ){
                    this.errMsg ="Please enter event title and location";
                     this.hasError=true;
                   }
                   else if(this.location.length ===0){
                        this.errMsg ="Please enter location";
                        this.hasError=true;
                }
                  else if(this.title.length ===0){
                         this.hasError=true;
                         this.errMsg ="Please enter event title";
                } 
                else{
                    
                    var fdta = {
                        'title': this.title,
                        'location': this.location,
                        'time': this.time,
                        'duration': this.duration,
                        'day': this.weekDay,
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    };
                    console.log(fdta);
                    this.$http.post('/api/events', fdta)
                        .then((response) => {
                            this.events = response.data;
                            console.log(response.data);
                        this.errMsg ="Success ! Added event.";
                        this.isSuccess=true;
                        self.title='';
                        self.location='';
                        })
                        .catch((error) => {
                        this.errMsg ="Failed! Cannot add the entry !";
                        this.hasError=true;
                            if (error.response) {
                                console.log(error.response);
                            } else {
                                console.log('Error', error.message);
                            }
                        });
                }
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
