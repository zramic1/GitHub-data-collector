<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <div class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="px-10 px-12">
          <h1 class="text-center font-bold text-3xl mt-6">Welcome!</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <button class="btn-indigo my-6 w-full" @click.prevent="login()">Login via GitHub</button>
          <button class="btn-indigo my-6 w-full bg-indigo-900" @click.prevent="home()">Continue without login</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  metaInfo: { title: 'Login' },
  methods: {
    login() {
      this.$inertia.get(this.route('github.login.redirect'))
    },
    home() {
      this.$inertia.get(this.route('web.home'))
    },
  },
}
</script>
