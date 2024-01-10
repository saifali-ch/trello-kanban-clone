<template>
    <div class="column">
        <div class="column__header">
            <h1 class="column__title">{{ column.title }}</h1>
            <div @click="deleteColumn(column.id)">
                <i class="fa-solid fa-trash fa-lg icon icon--trash"></i>
            </div>
        </div>
        <div class="column__content">
            <draggable v-model="column.cards" v-bind="dragOptions" :data-column-id="column.id" @end="onDrop">
                <Card v-for="card in column.cards" :key="card.id" :data-card-id="card.id" :card="card"/>
            </draggable>
            <div class="actions" v-show="!formVisible">
                <button @click="showAddCardForm" class="button button--dull">
                    <i class="fas fa-plus me-3"></i>
                    Add a card
                </button>
            </div>
            <div v-show="formVisible">
                <textarea v-model="newCardTitle" ref="cardTitleInput"
                          class="input input--card"
                          spellcheck="false"
                          dir="auto"
                          autocomplete="off"
                          placeholder="Enter a title for this card…"
                          aria-label="Enter a title for this card…">
                </textarea>
                <div class="actions">
                    <button @click="addCard" class="button button--primary">Add card</button>
                    <div @click="formVisible = false">
                        <i class="fas fa-close fa-xl icon icon--cancel"></i>
                    </div>
                </div>
            </div>
            <div class="spacer" ref="spacer"></div>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import Card from './Card.vue';

export default {
    props: {
        column: Object,
    },
    components: {
        draggable,
        Card,
    },
    data() {
        return {
            formVisible: false,
            newCardTitle: '',
            dragOptions: {
                animation: 150,
                group: 'cards',
            },
            columnId: this.column.id
        };
    },
    created() {
        Event.$on('add-column-form-visible', this.hideAddCardForm)
    },
    methods: {
        deleteColumn(columnId) {
            Event.$emit('delete-column', columnId)
        },

        showAddCardForm() {
            Event.$emit('add-card-form-visible');
            this.formVisible = true
            this.newCardTitle = ''

            // Set focus on the column title textarea using the ref
            this.$nextTick(() => {
                this.$refs.cardTitleInput.focus();
                this.$refs.spacer.scrollIntoView({behavior: "smooth"});
            });
        },

        hideAddCardForm() {
            this.formVisible = false;
            this.newCardTitle = '';
        },

        addCard() {
            this.newCardTitle = this.newCardTitle.trim();
            if (this.newCardTitle === '') {
                return;
            }

            const newCard = {
                title: this.newCardTitle,
                description: '',
            };

            // Send request to backend to add the card in specified column
            axios.post(`/api/cards/${this.column.id}/store`, newCard)
                .then(response => {
                    this.column.cards.push(response.data.card);
                    console.log('Card added successfully:', response.data);

                    Event.$emit('card-added', response.data.card);

                    this.showAddCardForm()
                })
                .catch(error => {
                    console.error('Error adding card:', error);
                });
        },

        onDrop(event) {
            Event.$emit('move-card', event)
        },
    },
};
</script>
