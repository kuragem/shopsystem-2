<template>
    <div v-show="value" class="product-form" >
        <h2 class="title">新規商品の追加</h2>
        <div v-show="loading" class="panel">
            <Loader>処理中...</Loader>
        </div>
        <form v-show="!loading" class="form" @submit.prevent="submit">
            <div class="errors" v-if="errors">
                <ul v-if="errors">
                    <li v-for="msg in errors" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            <div class="form-group">
                <label for="name">商品名（50文字以内）</label>
                <input class="form__item" type="text" v-model="name" name="name" id="name" required maxlength="50">
            </div>
            <div class="form-group">
                <label for="description">商品説明（500文字以内）</label>
                <textarea class="form__item" type="text" v-model="description" name="description" id="description" required maxlength="500" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="price">価格（半角数字）</label>
                <input class="form__item" type="text" v-model="price" name="description" id="price" required>
            </div>
            <div class="form-group">
                <label for="image">商品画像（.jpg/.jpeg/.png/.gif）</label>
                <input class="form__item" type="file" title="image" id="image" required @change="onFileChange">
                <output class="form__output" v-if="preview">
                    <img :src="preview" alt="プレビュー画像">
                </output>
            </div>
            <div class="form__button">
                <button type="submit" class="button button--inverse">追加</button>
            </div>
        </form>
    </div>
</template>

<script>
    import { CREATED, UNPROCESSABLE_ENTITY } from '../util'
    import Loader from './Loader.vue'

    export default {
        components: {
            Loader
        },
        props: {
            value: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                loading: false,
                preview: null,
                name: null,
                description: null,
                price: null,
                image: null,
                errors: null
            }
        },
        methods: {
            // フォームでファイルが選択されたら実行される
            onFileChange (event) {
                // 何も選択されていなかったら処理中断
                if (event.target.files.length === 0) {
                    this.reset()
                    return false
                }

                // ファイルが画像でなかったら処理中断
                if (!event.target.files[0].type.match('image.*')) {
                    this.reset()
                    return false
                }

                // FileReaderクラスのインスタンスを取得
                const reader = new FileReader()

                // ファイルを読み込み終わった段階で実行する処理
                reader.onload = e => {
                    // previewに読み込み結果（データURL）を代入する
                    // previewに値が入ると<output>につけたv-ifがtrueと判定される
                    // また<output>内部の<img>のsrc属性はpreviewの値を参照しているので
                    // 結果として画像が表示される
                    this.preview = e.target.result
                }

                // ファイルを読み込む
                // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
                reader.readAsDataURL(event.target.files[0])

                this.image = event.target.files[0]
            },
            // 入力欄の値とプレビュー表示をクリアするメソッド
            reset() {
                this.preview = ''
                this.image = null
                this.$el.querySelector('input[type="file"]').value = null
            },
            async submit() {
                this.loading = true

                let formData;
                formData = new FormData();

                formData.append('name', this.name)
                formData.append('description', this.description)
                formData.append('price', this.price)
                formData.append('image', this.image)

                const response = await axios.post('/api/products', formData)

                this.loading = false

                if (response.status === UNPROCESSABLE_ENTITY) {
                    this.errors = response.data.errors
                    return false
                }

                this.reset()
                this.$emit('input', false)

                if (response.status !== CREATED) {
                    this.$store.commit('error/setCode', response.status)
                    return false
                }

                // メッセージ登録
                this.$store.commit('message/setContent', {
                    content: '商品が追加されました。',
                    timeout: 6000
                })

                this.$router.push(`/products/${response.data.id}`)
            }
        }
    }
</script>