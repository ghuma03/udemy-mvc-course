<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
use Framework\Controller;
use Framework\Response;

class Products extends Controller {

    private Product $model;

    public function __construct(Product $model) {
        $this->model = $model;
    }
    public function index(): Response {

        $products = $this->model->getData();

        return $this->view(
            "Products/index.mvc.php", array("products" => $products, "total" => $this->model->getTotal())
        );
    }

    public function show(string $id): Response {
        $product = $this->getProduct($id);
        return $this->view("Products/show.mvc.php", array("product" => $product));
    }

    public function edit(string $id): Response {
        $product = $this->getProduct($id);
        return $this->view("Products/edit.mvc.php", array("product" => $product));
    }

    public function showPage(string $title, string $id, string $page) {
        echo "title: " . $title . "\n";
        echo "id: " . $id . "\n";
        echo "page: " . $page;
        die();
    }

    public function new(): Response {
        return $this->view("Products/new.mvc.php");
    }

    public function create(): Response {

        $data = array(
            "name" => $this->request->post["name"],
            "description" => (empty($this->request->post["description"]))? null : $this->request->post["description"]
        );

        if ($this->model->insert($data)) {
            return $this->redirect("/products/{$this->model->getInsertID()}/show");
        }
        else {
            return $this->view("Products/new.mvc.php", array("errors" => $this->model->getErrors(), "product" => $data));
        }
    }

    public function update(string $id): Response {

        $product = $this->getProduct($id);

        $product["name"] = $this->request->post["name"];
        $product["description"] = (empty($this->request->post["description"]))? null : $this->request->post["description"];

        if ($this->model->update($id, $product)) {
            return $this->redirect("/products/{$id}/show");
        }
        else {
            return $this->view("Products/edit.mvc.php", array("errors" => $this->model->getErrors(), "product" => $product));
        }
    }

    private function getProduct(string $id): array {

        $product = $this->model->find($id);

        if ($product === false) {
            throw new PageNotFoundException("Product not found");
        }

        return $product;
    }

    public function delete(string $id): Response {
        $product = $this->getProduct($id);
        return $this->view("Products/delete.mvc.php", array("product" => $product));
    }

    public function destroy(string $id): Response {

        $product = $this->getProduct($id);

        $this->model->delete($id);
        
        return $this->redirect("/products/index");
    }

    public function responseCodeExample(): Response {
        $this->response->setStatusCode(451);
        $this->response->setBody("Unavailable for legal reasons");
        return $this->response;
    }
}