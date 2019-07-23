<template>
    <div>
        <header>
            <Navbar />
        </header>
        <main>
            <div class="container">
                <Message />
                <RouterView />
            </div>
        </main>
        <Footer />
    </div>
</template>

<script>
    import Message from './components/Message.vue'
    import Navbar from './components/Navbar.vue'
    import Footer from './components/Footer.vue'
    import { INTERNAL_SERVER_ERROR } from './util'

    export default {
        components: {
            Message,
            Navbar,
            Footer
        }
    }
</script>