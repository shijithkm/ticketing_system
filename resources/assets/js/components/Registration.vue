<template>
<div>
    <h2>Registrer Event</h2>
    <form @submit.prevent="registerEvent" class="mb-3">

        <div class="form-group">
            <label for="exampleFormControlSelect1">Select Event</label>
            <select class="form-control" @change="selectEvent()" v-model="register.event_id">
                <option v-for="event in events" :value="event.id">{{ event.title }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlSelect1">Select Ticket Type</label>
            <select class="form-control" @change="selectTicket()" v-model="register.ticket_id">
                <option v-for="ticket in tickets" :value="ticket.id">{{ "TYPE: " + ticket.ticket_type + "  |   CAPACITY: " + ticket.capacity + "  |  PRICE: " + ticket.price + "AED" }}</option>
            </select>

            <div v-if="register.available != null" :class="register.available > 0 ? 'alert-success' : 'alert-danger'" class="alert" role="alert">
                {{ register.available + ' Tickets Available'}}
            </div>

        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Name" v-model="register.name" />
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Email" v-model="register.email" />
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Mobile" v-model="register.mobile" />
        </div>
        <div class="row">
            <div class="col text-right">
                <button type="button" @click="clearForm()" class="btn btn-danger">CANCEL</button>
                <button type="submit" :disabled="(!register.name || !register.email ||  !register.mobile || !register.ticket_id || !register.event_id)?true:false" class="btn btn-primary">REGISTER</button>
            </div>
        </div>
    </form>

</div>
</template>

<script>
export default {
    data() {
        return {
            events: [],
            lineups: [],
            tickets: [],
            selectedEvent: null,
            register: {
                id: '',
                event_id: '',
                ticket_id: '',
                available: null,
                name: '',
                mobile: '',
                email: '',
            },

        };
    },

    created() {
        this.fetchEvents();
    },

    methods: {

        selectTicket(page_url) {

            page_url = '/api/event/ticket/' + this.register.ticket_id + '/capacity';
            fetch(page_url, {
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': localStorage.getItem("token")
                    }
                })
                .then(async res => {
                    if(res.status === 200)    {
                        const data = await res.json();
                        this.register.available = data.capacity - data.sold;
                        if (this.register.available <= 0) {
                            alert("No more ticket available under " + data.ticket_type)
                        }
                    }else {
                        alert(res.statusText)
                    }
                   
                })
                .catch(err => console.log(err));
        },
        fetchEvents(page_url) {
            let vm = this;
            page_url = page_url || '/api/events/all';
            fetch(page_url, {
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': localStorage.getItem("token")
                    }
                })
                .then(async res => {
                    if(res.status === 200)    {
                        this.events = await res.json();
                    }else {
                        alert(res.statusText)
                    }
                    
                })
                 .catch(err => alert("Internal Server Error"));
        },
        registerEvent() {

            fetch('api/register', {
                    method: 'post',
                    body: JSON.stringify(this.register),
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': localStorage.getItem("token")
                    }
                })
                .then(res => {

                    if(res.status === 200)    {
                        alert('Registration Success');
                        this.clearForm();
                    }else {
                        alert(res.statusText)
                    }
                   
                })
                .catch(err => alert("Internal Server Error"));

        },
        clearForm() {
            this.register.id = null;
            this.register.event_id = null;
            this.register.ticket_id = null;
            this.register.name = '';
            this.register.email = '';
            this.register.mobile = '';
            this.register.available = null;
            this.register.tickets = [];
            this.register.lineups = [];
            
        },
        selectEvent() {
            console.log(this.register);

            fetch('/api/event/' + this.register.event_id + '/tickets', {
                    method: 'get',
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': localStorage.getItem("token")
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.tickets = data;
                })
                .catch(err => console.log(err));

        },
    }
};
</script>
