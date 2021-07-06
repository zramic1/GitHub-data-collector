<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('web.home')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="route().current('web.home') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="route().current('web.home') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Home</div>
      </inertia-link>
      <inertia-link class="flex items-center group py-3" :href="route('web.repositories.index')">
        <icon name="folder" class="w-4 h-4 mr-2" :class="route().current('web.repositories.index') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="route().current('web.repositories.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Repositories</div>
      </inertia-link>
      <inertia-link v-if="$page.props.auth.user" class="flex items-center group py-3" :href="route('web.followers.index')">
        <icon name="users" class="w-4 h-4 mr-2" :class="route().current('web.followers.index') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="route().current('web.followers.index') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Followers</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '../Shared/Icon'

export default {
  components: {
    Icon,
  },
}
</script>
