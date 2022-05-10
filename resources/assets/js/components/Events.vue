<template>
  <div>
    <h2>Events</h2>
    <form @submit.prevent="addEvent" class="mb-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="event.title">
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="Description" v-model="event.description"></textarea>
      </div>
       <div class="form-group">
        <input class="form-control" placeholder="Start Date & Time" v-model="event.event_start_date"></input>
      </div>
       <div class="form-group">
        <input class="form-control" placeholder="End Date & Time" v-model="event.event_end_date"></input>
      </div>


<table class="table">
  <thead>
    <tr>
      <th scope="col">
      <input type="text" class="form-control" placeholder="Topic">
      </th>
      <th scope="col">
      <input type="text" class="form-control" placeholder="Speaker">
      </th>
      <th scope="col">
      <input type="text" class="form-control" placeholder="Time">
      </th>
      <th scope="col"><button class="btn btn-light btn-block">Add</button></th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="lineup in event.lineups" v-bind:key="lineup.id">
      <td>{{ lineup.ticket_type}}</td>
      <td>{{ lineup.capacity}}</td>
      <td>{{ lineup.price}}</td>
      <td><button class="btn btn-light btn-block">Delete</button></td>
    </tr>
    
  </tbody>
</table>


<table class="table">
  <thead>
    <tr>
      <th scope="col">
      <input type="text" class="form-control"  v-model="event.ticket_type" placeholder="Ticket Type">
      </th>
      <th scope="col">
      <input type="text" class="form-control" placeholder="Capacity" v-model="event.capacity">
      </th>
      <th scope="col">
      <input type="text" class="form-control" placeholder="Price"  v-model="event.price">
      </th>
      <th scope="col"><button type="button" @click="addTicket()" class="btn btn-light btn-block">Add</button></th>
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



      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchEvents(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchEvents(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    <div class="card card-body mb-2" v-for="event in events" v-bind:key="event.id">
      <h3>{{ event.title }}</h3>
      <p>{{ event.description }}</p>
      <p>{{ event.event_start_date }}</p>
      <p>{{ event.event_end_date }}</p>
      <hr>
      <button @click="editEvent(event)" class="btn btn-warning mb-2">Edit</button>
      <button @click="deleteEvent(event.id)" class="btn btn-danger">Delete</button>
    </div>
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
        ticket_type:'',
        capacity:'',
        price:'',
        lineups:[{"topic":"Java","Speaker":"Shijith","Time":"10:00 AM"}],
        tickets:[],
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
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
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
          method: 'delete'
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
      if (this.edit === false) {
        // Add
        fetch('api/event', {
          method: 'post',
          body: JSON.stringify(this.event),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Event Added');
            this.fetchEvents();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/event', {
          method: 'put',
          body: JSON.stringify(this.event),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Event Updated');
            this.fetchEvents();
          })
          .catch(err => console.log(err));
      }
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
    },
    addTicket(){
     this.event.tickets = [...this.event.tickets,{'ticket_type':this.event.ticket_type,'capacity':this.event.capacity,'price':this.event.price}];
    },
    deleteTicket(index){
       if (confirm('Are You Sure?')) {
         this.event.tickets = this.event.tickets.filter((ticket,i)=>(index != i));
       }
    }

  }
};
</script>
