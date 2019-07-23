<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequirement;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create(ProductRequirement $request)
    {
    //    商品写真の拡張子を取得する
        $extension = $request->image->extension();

        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

    //    インスタンス生成時に割り振られたランダムな値と
    //    本来の拡張子を組み合わせてファイル名とする
        $product->filename = $product->getRandomFileName().'.'.$extension;

    //    S3にファイルを保存する
        Storage::cloud()->putFileAs('', $request->image, $product->filename, 'public');

    //    データベースエラー時のS3との整合性確保のため
    //    トランザクションを利用する
        DB::beginTransaction();

        try {
            $product->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

        //    S3のファイルを削除
            Storage::cloud()->delete($product->filename);
            throw $exception;
        }

    //    レスポンスコード(CREATED)返却
        return response($product, 201);
    }
}
