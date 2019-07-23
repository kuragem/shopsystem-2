<template>
    <nav class="navbar">
        <RouterLink class="navbar__brand" to="/">
            商品管理システム
        </RouterLink>
        <div class="navbar__menu">
            <div class="navbar__item">
                <button class="button" @click="showForm =! showForm">
                    <i class="icon ion-md-add"></i>
                    商品追加
                </button>
            </div>
            <div class="navbar__item">
                <RouterLink class="button button--link" to="/">
                    商品一覧
                </RouterLink>
            </div>
            <div class="navbar__item">
            <RouterLink class="button button--link" to="/shops">
                店舗一覧
            </RouterLink>
        </div>
        </div>
        <ProductForm v-model="showForm" />
    </nav>
</template>

<script>
    import ProductForm from './ProductForm.vue'

    export default {
        components: {
            ProductForm
        },
        data () {
            return {
                showForm: false
            }
        },
    }
</script>