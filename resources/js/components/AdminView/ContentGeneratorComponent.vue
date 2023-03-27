<template>
    <form action="">
        <ul>
            <li v-for="content in Subs" :key="content.id">
                {{ content.content }}
                <ButtonComponent />
                <!-- Edit -->
            </li>
        </ul>
    </form>
    <form action="">
        <TiptapComponent />
        <ButtonComponent />
        <!-- Save -->
        <ButtonComponent />
        <!-- Cancel -->
    </form>
</template>

<script></script>

<style></style>
