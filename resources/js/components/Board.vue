<template>
    <div class="board">
        <draggable v-model="columns" v-bind="dragOptions" @end="onDrop" class="flex gap-4">
            <Column v-for="column in columns" :key="column.id" :column="column"/>
        </draggable>
        <div class="column" v-show="formVisible">
            <textarea v-model="newColumnTitle" ref="columnTitleInput"
                      @keydown="handleKeydown"
                      class="input input--column"
                      spellcheck="false"
                      dir="auto"
                      maxlength="255"
                      autocomplete="off"
                      placeholder="Enter column title…"
                      aria-label="Enter column title…">
            </textarea>
            <div class="actions">
                <button @click="addColumn" class="button button--primary">Add column</button>
                <div @click="hideAddColumnForm">
                    <i class="fas fa-close fa-xl icon icon--cancel"></i>
                </div>
            </div>
        </div>
        <button
            v-show="!formVisible"
            @click="showAddColumnForm"
            class="button button--ghost">
            <i class="fas fa-plus me-3"></i>
            Add another column
        </button>
        <div class="spacer" ref="spacer"></div>
        <Modal/>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import Column from './Column.vue';
import Modal from './Modal.vue';
import Card from "./Card.vue";

export default {
    components: {
        draggable, Card,
        Column,
        Modal,
    },
    data() {
        return {
            columns: [],
            formVisible: false,
            newColumnTitle: '',
            dragOptions: {
                animation: 500,
                group: 'columns',
            },
        };
    },
    created() {
        this.fetchBoardData();
        Event.$on('delete-column', this.deleteColumn);
        Event.$on('add-card-form-visible', this.hideAddColumnForm);
        Event.$on('move-card', this.moveCard)
    },
    methods: {
        fetchBoardData() {
            // Get the data from backend
            axios.get('/api/columns')
                .then(response => {
                    this.columns = response.data.columns;
                })
                .catch(error => {
                    console.error('Error fetching board data:', error);
                });
        },

        showAddColumnForm() {
            Event.$emit('add-column-form-visible');
            this.formVisible = true;
            this.newColumnTitle = ''

            // Set focus on the column title textarea using the ref
            this.$nextTick(() => {
                this.$refs.columnTitleInput.focus();
                this.$refs.spacer.scrollIntoView({behavior: "smooth"});
            });
        },

        hideAddColumnForm() {
            this.formVisible = false;
            this.newColumnTitle = '';
        },

        handleKeydown(event) {
            if (event.keyCode === 13) {
                event.preventDefault()
                this.addColumn()
            }
        },

        addColumn() {
            this.newColumnTitle = this.newColumnTitle.trim();
            if (this.newColumnTitle === '') {
                return;
            }

            // Send request to backend to add the column
            axios.post('/api/columns/store', {title: this.newColumnTitle})
                .then(response => {
                    const newColumn = {
                        id: response.data.column.id,
                        title: this.newColumnTitle.trim(),
                        cards: [],
                    };

                    this.columns.push(newColumn);
                    this.showAddColumnForm();

                    console.log('Column added successfully:', response.data);
                })
                .catch(error => {
                    console.error('Error adding column:', error);
                });
        },

        deleteColumn(columnId) {
            const confirmed = confirm('Are you sure you want to delete this column?');
            if (confirmed) {
                this.columns = this.columns.filter(column => column.id !== columnId);

                // Send request to backend to delete the column
                axios.delete(`/api/columns/${columnId}/delete`)
                    .then(response => {
                        console.log('Column deleted successfully:', response.data);
                    })
                    .catch(error => {
                        console.error('Error deleting column:', error);
                    });
            }
        },

        onDrop() {
            const sortedColumnIds = this.columns.map(col => col.id);
            axios.put(`/api/columns/reorder`, {
                column_ids: sortedColumnIds,
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error moving card:', error);
                });
        },

        moveCard(event) {
            const cardId = event.item.dataset.cardId;

            const oldColumnId = event.from.dataset.columnId;
            const newColumnId = event.to.dataset.columnId;

            const oldColumn = this.columns.find((c) => parseInt(c.id) === parseInt(oldColumnId));
            const newColumn = this.columns.find((c) => parseInt(c.id) === parseInt(newColumnId));

            const oldColumnSortedCardIds = oldColumn.cards.map(card => card.id);
            const newColumnSortedCardIds = newColumn.cards.map(card => card.id);

            axios.put(`/api/cards/${cardId}/reorder`, {
                card_id: cardId,
                new_column_id: newColumnId,
                old_column_sorted_card_ids: oldColumnSortedCardIds,
                new_column_sorted_card_ids: newColumnSortedCardIds,
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error('Error moving card:', error);
                });
        },
    },
};
</script>
