<template>
  <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
    <div class="container">
      <router-link :to="{ name: 'dashboard' }"  class="navbar-brand">Dashboard</router-link>
      <router-link :to="{ name: 'event' }"  class="navbar-brand">Create Event</router-link>
      <router-link :to="{ name: 'register' }"  class="navbar-brand">Register Event</router-link>
    </div>
  </nav>
</template>
