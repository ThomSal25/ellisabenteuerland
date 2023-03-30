<template>
    <div id="counter-border">
        <div class="counter" v-html="counter"></div>
        <div class="button-orientation">
            <ButtonComponent :buttonName="Plus" @click="countUp()" />
            <ButtonComponent :buttonName="Minus" @click="countDown()" />
        </div>
    </div>
</template>

<script>
export default {
    props: ["count"],
    data() {
        return {
            Plus: "+",
            Minus: "-",
        };
    },
    computed: {
        counter() {
            return this.count;
        },
    },
    methods: {
        countUp() {
            this.$emit("logCountUp");
        },
        countDown() {
            this.$emit("logCountDown");
        },
    },
};
</script>

<style>
#counter-border {
    width: 5rem;
    border: 0.1rem solid black;
    display: flex;
    justify-content: center;
    align-items: center;
}

.button-orientation {
    display: grid;
}
</style>
