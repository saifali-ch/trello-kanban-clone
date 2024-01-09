<template>
    <li class="card" @click="openModal">
        <span class="card__title">{{ card.title }}</span>
    </li>
</template>

<script>
export default {
    props: {
        card: Object,
    },
    methods: {
        openModal() {
            Event.$emit('open-modal', this.card);
        },
    },
};
</script>
