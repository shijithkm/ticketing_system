<template>
<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Add Event</h3>
                <form @submit.prevent="addEvent" class="mb-3">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Title" v-model="event.title">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Description" v-model="event.description"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="datetime-local" placeholder="Start Date & Time" v-model="event.event_start_date"></input>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="datetime-local" placeholder="End Date & Time" v-model="event.event_end_date"></input>
                    </div>

                    <h3>Lineup Details</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input type="text" style="min-width: 200px;" class="form-control" placeholder="Topic" v-model="event.topic">
                                    </th>
                                    <th scope="col">
                                        <input type="text" style="min-width: 200px;" class="form-control" placeholder="Speaker" v-model="event.speaker">
                                    </th>
                                    <th scope="col">
                                        <input type="datetime-local" class="form-control" placeholder="Event Time" v-model="event.event_time">
                                    </th>
                                    <th scope="col"><button type="button" class="btn btn-light btn-block" :disabled="(!event.topic || !event.speaker || !event.event_time)?true:false" @click="addLineup()">Add</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lineup in event.lineups" v-bind:key="lineup.id">
                                    <td>{{ lineup.topic}}</td>
                                    <td>{{ lineup.speaker}}</td>
                                    <td>{{ lineup.event_time}}</td>
                                    <td><button type="button" @click="deleteLineup(index)" class="btn btn-light btn-block">Delete</button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <h3>Ticket Details</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">

                                        <label for="exampleFormControlSelect1">Ticket Type</label>
                                        <select style="min-width: 200px;" class="form-control" v-model="event.ticket_type">
                                            <option value="GOLD">GOLD</option>
                                            <option value="SILVER">SILVER</option>
                                            <option value="PLATTINUM">PLATINUM</option>
                                        </select>
                                    </th>
                                    <th scope="col">
                                        <input type="number" style="min-width: 200px;" class="form-control" placeholder="Capacity" v-model="event.capacity">
                                    </th>
                                    <th scope="col">
                                        <input type="number" style="min-width: 200px;" class="form-control" placeholder="Price" v-model="event.price">
                                    </th>
                                    <th scope="col"><button type="button" :disabled="(!event.ticket_type || !event.capacity || !event.price)?true:false" @click="addTicket()" class="btn btn-light btn-block">Add</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ticket,index) in event.tickets" v-bind:key="ticket.id">
                                    <td>{{ ticket.ticket_type}}</td>
                                    <td>{{ ticket.capacity}}</td>
                                    <td>{{ ticket.price}}</td>
                                    <td><button type="button" @click="deleteTicket(index)" v-bind:key="ticket.id" class="btn btn-light btn-block">Delete</button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col text-right">
                            <button type="button" :disabled="!event.title?true:false" @click="clearForm()" class="btn btn-danger">CANCEL</button>
                            <button type="submit" :disabled="!event.title?true:false" class="btn btn-primary">CREATE</button>
                        </div>
                    </div>
                </form>
            </div>
            <br />
            <div class="col">
                <h3>Event List</h3>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchEvents(pagination.prev_page_url)">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchEvents(pagination.next_page_url)">Next</a></li>
                    </ul>
                </nav>
                <div class="card card-body mb-2" v-for="event in events" v-bind:key="event.id">
                    <div class="col-12 text-left">
                        <h4>{{ event.title }}</h4>
                        <p>{{ event.description }}</p>
                        <div class="col-12 text-right">
                            <button @click="deleteEvent(event.id)" type="button" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
</div>
</template>

<script>
export default {
    data() {
        return {
            events: [],
            event: {
                id: '',
                title: '',
                description: '',
                event_start_date: '',
                event_end_date: '',
                ticket_type: '',
                capacity: '',
                price: '',
                topic: '',
                speaker: '',
                event_time: '',
                lineups: [],
                tickets: [],
            },
            event_id: '',
            pagination: {},
            edit: false
        };
    },

    created() {
        this.fetchEvents();
    },

    methods: {
        fetchEvents(page_url) {
            let vm = this;
            page_url = page_url || '/api/events';
            fetch(page_url, {
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': localStorage.getItem("token")
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'Token is Expired') {
                        alert("Token Expired Login Again!")
                        this.$router.push("/logout")
                    }
                    this.events = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };

            this.pagination = pagination;
        },
        deleteEvent(id) {
            if (confirm('Are You Sure?')) {
                fetch(`api/event/${id}`, {
                        method: 'delete',
                        headers: {
                            'content-type': 'application/json',
                            'Authorization': localStorage.getItem("token")
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Event Removed');
                        this.fetchEvents();
                    })
                    .catch(err => console.log(err));
            }
        },
        addEvent() {
            fetch('api/event', {
                    method: 'post',
                    body: JSON.stringify(this.event),
                    headers: {
                        'content-type': 'application/json',
                        'Authorization': localStorage.getItem("token")
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.clearForm();
                    alert('Event Added');
                    this.fetchEvents();
                })
                .catch(err => console.log(err));

        },
        editEvent(event) {
            this.edit = true;
            this.event.id = event.id;
            this.event.event_id = event.id;
            this.event.title = event.title;
            this.event.description = event.description;
            this.event.event_start_date = event.event_start_date;
            this.event.event_end_date = event.event_end_date;
        },
        clearForm() {
            this.edit = false;
            this.event.id = null;
            this.event.event_id = null;
            this.event.title = '';
            this.event.description = '';
            this.event.event_start_date = '';
            this.event.event_end_date = '';
            this.event.ticket_type = '';
            this.event.capacity = '';
            this.event.price = '';
            this.event.topic = '';
            this.event.speaker = '';
            this.event.event_time = '';
            this.event.tickets = [];
            this.event.lineups = [];
        },
        addTicket() {
            this.event.tickets = [...this.event.tickets, {
                'ticket_type': this.event.ticket_type,
                'capacity': this.event.capacity,
                'price': this.event.price
            }];
        },
        deleteTicket(index) {
            if (confirm('Are You Sure?')) {
                this.event.tickets = this.event.tickets.filter((ticket, i) => (index != i));
            }
        },
        addLineup() {
            if (this.event.topic && this.event.speaker && this.event.event_time) {
                this.event.lineups = [...this.event.lineups, {
                    'topic': this.event.topic,
                    'speaker': this.event.speaker,
                    'event_time': this.event.event_time
                }];
            } else {
                alert("Please fill topic,speaker and event time before add")
            }
        },
        deleteLineup(index) {
            if (confirm('Are You Sure?')) {
                this.event.lineups = this.event.lineups.filter((lineup, i) => (index != i));
            }
        }

    }
};
</script>
