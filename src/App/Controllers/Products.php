<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
use Framework\Controller;

class Products extends Controller {

    private Product $model;

    public function __construct(Product $model) {
        $this->model = $model;
    }
    public function index() {

        $products = $this->model->getData();

        echo $this->viewer->render("Products/index.mvc.php",
                                    array("title" => "Products", "products" => $products, "total" => $this->model->getTotal()));
    }

    public function show(string $id) {

        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", array("title" => "Product"));
        echo $this->viewer->render("Products/show.php", array("product" => $product));
    }

    public function edit(string $id) {

        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", array("title" => "Edit Product"));
        echo $this->viewer->render("Products/edit.php", array("product" => $product));
    }

    public function showPage(string $title, string $id, string $page) {
        echo "title: " . $title . "\n";
        echo "id: " . $id . "\n";
        echo "page: " . $page;
        die();
    }

    public function new() {
        echo $this->viewer->render("shared/header.php", array("title" => "New Product"));
        echo $this->viewer->render("Products/new.php");
    }

    public function create() {

        $data = array(
            "name" => $this->request->post["name"],
            "description" => (empty($this->request->post["description"]))? null : $this->request->post["description"]
        );

        if ($this->model->insert($data)) {
            header("Location:/products/{$this->model->getInsertID()}/show");
            exit;
        }
        else {

            echo $this->viewer->render("shared/header.php", array("title" => "New Product"));
            echo $this->viewer->render("Products/new.php", array("errors" => $this->model->getErrors(), "product" => $data));

        }
    }

    public function update(string $id) {

        $product = $this->getProduct($id);

        $product["name"] = $this->request->post["name"];
        $product["description"] = (empty($this->request->post["description"]))? null : $this->request->post["description"];

        if ($this->model->update($id, $product)) {
            header("Location:/products/{$id}/show");
            exit;
        }
        else {

            echo $this->viewer->render("shared/header.php", array("title" => "Edit Product"));
            echo $this->viewer->render("Products/edit.php", array("errors" => $this->model->getErrors(), "product" => $product));

        }
    }

    private function getProduct(string $id): array {

        $product = $this->model->find($id);

        if ($product === false) {
            throw new PageNotFoundException("Product not found");
        }

        return $product;
    }

    public function delete(string $id) {

        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", array("title" => "Delete product"));
        echo $this->viewer->render("Products/delete.php", array("product" => $product));
    }

    public function destroy(string $id) {

        $product = $this->getProduct($id);

        $this->model->delete($id);
        
        header("Location: /products/index");
        exit;
    }
}