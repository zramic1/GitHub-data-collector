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
        <div class="flex flex-row gap-4">
          <text-input v-model="form.owner" label="Owner" class="w-1/2" />
          <text-input v-model="form.language" label="Language" class="w-1/2" />
        </div>
        <textarea-input v-model="form.description" label="Description" />
      </form>
    </div>

    <delete-modal v-if="showDeleteModal"
                  :heading="'Delete repository'"
                  :text="'Are you sure you want to delete this repository?'"
                  :first-button-text="'No'"
                  :second-button-text="'Yes'"
                  @close="showDeleteModal = false"
                  @confirm="$emit('deleteRepository'); showDeleteModal = false"
    />
  </div>
</template>

<script>
import TextInput from '../../Shared/TextInput'
import TextareaInput from '../../Shared/TextareaInput'
import Icon from '../../Shared/Icon'
import DeleteModal from '../../Shared/DeleteModal'

export default {
  name: 'RepositoryCard',
  components: {TextareaInput, TextInput, Icon, DeleteModal},
  props: {
    repository: Object,
  },
  data() {
    return {
      form: {
        id: this.repository.id,
        name: this.repository.name,
        owner: this.repository.owner,
        language: this.repository.language,
        description: this.repository.description,
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
