<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct($request)
    {
        return $this->updateOrCreate($request);
    }

    public function updateProduct($request, $id)
    {
        return $this->updateOrCreate($request, $id);
    }

    public function updateOrCreate($request, $id = null)
    {
        if (!isset($id)) {
            $product = $this->productRepository->updateOrCreate($request);
        } else {
            $product = $this->productRepository->updateOrCreate($request, $id);
        }

        if (!isset($product)) {
            return ResponseMessage::createFail('Product');
        }

        return ResponseMessage::createSuccess('Product', $product);
    }

    public function deleteProduct($id)
    {
        try {
            $product = $this->productRepository->deleteProduct($id);
        } catch (\Exception $ex) {
            return ResponseMessage::deleteFail('Product');
        }

        if (!isset($product)) {
            return ResponseMessage::deleteFail('Product');
        }

        return ResponseMessage::deleteSuccess('Product');
    }
}