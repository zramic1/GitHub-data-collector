<template>
  <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 mb-6">
    <h3 class="text-lg leading-6 font-medium text-gray-900 pb-6 flex flex-row justify-between">
      <span>{{ form.name }}</span>
      <button title="Delete" @click.prevent="showDeleteModal = true">
        <icon name="trash" class="fill-indigo-600 h-5 w-5" />
      </button>
    </h3>
    <div>
      <form class="flex flex-col gap-4" @input.prevent="emitChanges">
        <text-input v-model="form.name" label="Name" />
      </form>
    </div>
    <delete-modal v-if="showDeleteModal"
                  :heading="'Delete follower'"
                  :text="'Are you sure you want to delete this follower?'"
                  :first-button-text="'No'"
                  :second-button-text="'Yes'"
                  @close="showDeleteModal = false"
                  @confirm="$emit('deleteFollower'); showDeleteModal = false"
    />
  </div>
</template>

<script>
import TextInput from '../../Shared/TextInput'
import DeleteModal from '../../Shared/DeleteModal'
import Icon from '../../Shared/Icon'
export default {
  name: 'FollowerCard',
  components: { TextInput, DeleteModal, Icon },
  props: {
    follower: Object,
  },
  data() {
    return {
      form: {
        id: this.follower.id,
        name: this.follower.name,
      },
      showDeleteModal: false,
    }
  },
  methods: {
    emitChanges() {
      this.$emit('input', this.form)
    },
  },
}
</script>

<style scoped>

</style>
