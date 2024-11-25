<template>
    <div class="content">
        <!-- {{ name }}
        {{ age }} -->
        <!-- Binding of Var -->
        <div class="input">
            <h2>Activity: Two Way Binding</h2>
            <h2>Input:</h2>
            <h4>Name:</h4>
            <input type="text" v-model="messageName" />
            <h4>Age:</h4>
            <input type="number" v-model="messageAge" />
            <!-- Binding on class -->
            <!-- <p
                class="text-uppercase"
                :class="{
                    'text-red': isError,
                    'text-blue': !isError,
                }"
            >Error</p> -->
        </div>
        <div class="output">
            <h2>Output:</h2>
            <h4>Name: {{ messageName }} </h4>
            <h4>Age: {{ messageAge }}</h4>
            <p
                :class="{
                    'text-green': messageAge >= 18,
                    'text-black': messageAge < 18,
                }"
            >Adult</p>
            <p
                :class="{
                    'text-red': messageAge < 18 && messageAge >= 1,

                }"  
            >Minor</p>
        </div>
    </div>
</template>
<script>
// import UsersComponent from './UsersComponent.vue';
export default {
    props: ["name", "age"],
    data() {
        return {
            messageName: null,
            messageAge: null,
        };
    },
    components: {},
    methods: {},

    mounted() {},
};
</script>
<style>
input{
    border-radius: 10px;
    border: solid 1px;
}
h2{
    font-weight: bold;
}

</style>