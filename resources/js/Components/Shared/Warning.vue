<template>
  <div class="bg-white shadow rounded-lg w-full m-auto">
    <div class="px-4 py-5 sm:p-6">
      <div class="text-center p-10">
        <icon name="exclamation-triangle" class="w-20 h-20 m-auto fill-red-600"></icon>
      </div>
      <h1 class="text-xl leading-6 font-medium text-gray-900 text-center">
        {{ text }}
      </h1>
    </div>
  </div>
</template>

<script>
import Icon from './Icon'
export default {
  name: 'Warning',
  components: { Icon },
  props: {
    text: String,
  },
}
</script>

<style scoped>

</style>
