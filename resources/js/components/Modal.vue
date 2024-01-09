<template>
    <modal name="card-modal">
        <div class="modal">
            <div class="row">
                <i class="fa-solid fa-credit-card icon icon--description"></i>
                <textarea v-model="newTitle"
                          ref="title"
                          class="input input--modal-title"
                          @change="updateTitle"
                          @keydown="handleKeydown"/>
            </div>
            <div @click="closeModal">
                <i class="fa-solid fa-xmark fa-lg icon icon--close"></i>
            </div>
            <div>
                <div class="modal__description row">
                    <i class="fa-solid fa-bars icon icon--title"></i>
                    <label>Description</label>
                </div>
                <textarea v-model="newDescription"
                          ref="description"
                          rows="4" cols="50" class="input input--modal-description"
                          placeholder="Add a more detailed description..."></textarea>
                <div class="actions actions--modal">
                    <button @click="updateDescription" class="button button--primary">Save</button>
                    <button @click="blurDescription" class="button button--cancel">Cancel</button>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    data() {
        return {
            card: {
                title: '',
                description: ''
            },
            newTitle: '',
            newDescription: ''
        };
    },
    created() {
        Event.$on('open-modal', this.openModal)
    },
    methods: {
        openModal(card) {
            this.card = card;
            this.newTitle = card.title
            this.newDescription = card.description
            this.$modal.show('card-modal');
        },

        handleKeydown(event) {
            if (event.keyCode === 13) {
                event.preventDefault()
                this.$refs.title.blur()
            }
        },

        updateTitle() {
            const title = this.newTitle.trim()
            if (!title) return

            axios.post(`/api/cards/${this.card.id}/update-title`, {title})
                .then(response => {
                    this.card.title = title;
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error updating title', error);
                });
        },

        blurDescription() {
            this.newDescription = this.card.description
            this.$refs.description.blur()
        },

        updateDescription() {
            const description = this.newDescription.trim()

            axios.post(`/api/cards/${this.card.id}/update-description`, {description})
                .then(response => {
                    this.card.description = description;
                    this.$modal.hide('card-modal');
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error updating title', error);
                });
        },

        closeModal() {
            this.$modal.hide('card-modal');
        },
    },
};
</script>
