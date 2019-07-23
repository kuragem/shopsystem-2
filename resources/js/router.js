import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import ProductList from './pages/ProductList.vue'
import ShopList from './pages/ShopList.vue'
import ProductDetail from './pages/ProductDetail.vue'

import SystemError from './pages/errors/System.vue'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: ProductList
    },
    {
        path: '/shops',
        component: ShopList
    },
    {
        path: '/products/:id',
        component: ProductDetail,
        props: true
    },
    {
        path: '/500',
        component: SystemError
    },
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router