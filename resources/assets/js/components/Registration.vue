<template>
  <div>
    <h2>Registrer Event</h2>
    <form @submit.prevent="registerEvent" class="mb-3">

     <div class="form-group">
    <label for="exampleFormControlSelect1">Select Event</label>
    <select class="form-control"  @change="selectEvent()" v-model="register.event_id">
      <option v-for="event in events" :value="event.id" >{{ event.title }}</option>
    </select>
  </div>
  
  
     <div class="form-group">

     <div class="row">
  <div class="col-sm-6" v-for="ticket in tickets">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ ticket.ticket_type }}</h5>
        <p class="card-text">Capacity {{ ticket.capacity }}</p>
        <p class="card-text">Price {{ ticket.price }} AED</p>
        <button type="button" @click="selectTicket(ticket.id)" class="btn btn-primary">Select</button>
      </div>
    </div>
  </div>
 
</div>

     </div>

      <div class="form-group">
        <input type="text" class="form-control" placeholder="Name" v-model="register.name">
      </div>
      <div class="form-group">
        <input class="form-control" placeholder="Email" v-model="register.email"></input>
      </div>
       <div class="form-group">
        <input class="form-control" placeholder="Mobile" v-model="register.mobile"></input>
      </div>
      

      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      events: [],
      lineups:[],
      tickets:[],
      selectedEvent : null,
      register: {
        id: '',
        event_id: '',
        ticket_id: '',
        name: '',
        mobile: '',
        email:'',
      },
      
    };
  },

  created() {
    this.fetchEvents();
  },

  methods: {

    selectTicket(id){
      this.register.ticket_id = id;
    },
    fetchEvents(page_url) {
      let vm = this;
      page_url = page_url || '/api/events';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.events = res.data;
        })
        .catch(err => console.log(err));
    },
    registerEvent() {

      console.log(this.register)

        fetch('api/registration', {
          method: 'post',
          body: JSON.stringify(this.register),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Registration Success');
          })
          .catch(err => console.log(err));
      
    },
    clearForm() {
      this.register.id = null;
      this.register.event_id = null;
      this.register.ticket_id = null;
      this.register.name = '';
      this.register.email = '';
      this.register.mobile = '';
      this.register.tickets = [];
      this.register.lineups = [];
    },
    selectEvent(){
      console.log(this.register);

      fetch('/api/event/'+this.register.event_id+'/tickets', {
          method: 'get',
          headers: {
            'content-type': 'application/json'
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
