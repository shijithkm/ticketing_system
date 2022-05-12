<template>
  <div>
    <h3>Dashboard</h3>

    <hr />

    <h4>Sales Report</h4>
    <p>Last 6 months</p>
<div class="table-responsive">
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">Event</th>
          <th scope="col">Tiket Type</th>
          <th class="text-right" scope="col">Ticket Price (AED)</th>
          <th class="text-right" scope="col">Sold</th>
          <th class="text-right" scope="col">Remaning</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sale in sales">
          <td>{{ sale.title }}</td>
          <td>{{ sale.ticket_type }}</td>
          <td class="text-right">{{ sale.price }}</td>
          <td class="text-right">{{ sale.sold }}</td>
          <td class="text-right">{{ sale.capacity - sale.sold }}</td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      sales: [],
    };
  },

  created() {
    this.getSales();
  },

  methods: {
    getSales(page_url) {
      let vm = this;
      page_url = page_url || "/api/sales";
      fetch(page_url, {
        headers: {
          "content-type": "application/json",
          Authorization: localStorage.getItem("token"),
        },
      })
        .then((res) => res.json())
        .then((res) => {
          this.sales = res;
          console.log(this.sales);
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
