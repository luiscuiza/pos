<?php

class ProductController {

    /* Página con todos los productos */
    static public function renderProducts() {
        $products = ProductModel::alls();
        $data = [
            'title' => 'POS - Productos',
            'products' => $products
        ];
        TemplateController::render('./views/products/list.php', './views/layout/sidebar.php', $data);
    }

    /* Formulario nuevo producto */
    static public function renderNewForm() {
        include 'views/products/formNew.php';
    }

    /* Formulario editar producto */
    static public function renderEditForm() {
        $productId = $_GET['id'] ?? null;
        if (!$productId) {
            echo "ID de producto no proporcionado.";
            return;
        }
        $product = ProductModel::getProductById($productId);
        if (!$product) {
            echo "Producto no encontrado.";
            return;
        }
        include 'views/products/formEdit.php';
    }

    /* Crear un nuevo producto */
    public static function createProduct() {
        $codigo = $_POST['codigo'] ?? null;
        $codigo_sin = $_POST['codigo_sin'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $unidad_medida = $_POST['unidad_medida'] ?? null;
        $unidad_medida_sin = $_POST['unidad_medida_sin'] ?? null;
        $imagen = $_FILES['imagen']['name'] ?? null;
        $disponible = isset($_POST['disponible']) ? 1 : 0;
        if (empty($codigo) || empty($codigo_sin) || empty($nombre) || empty($precio) || empty($unidad_medida) || empty($unidad_medida_sin) || empty($imagen)) {
            echo json_encode(["status" => "ERROR", "message" => "Todos los campos son obligatorios."]);
            return;
        }
        $uploadDir = 'uploads/products/';
        $uploadFile = $uploadDir . basename($imagen);
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
            echo json_encode(["status" => "ERROR", "message" => "Error al subir la imagen."]);
            return;
        }
        $result = ProductModel::createProduct($codigo, $codigo_sin, $nombre, $precio, $unidad_medida, $unidad_medida_sin, $imagen, $disponible);
        if ($result) {
            echo json_encode(["status" => "OK", "message" => "Producto creado exitosamente."]);
        } else {
            echo json_encode(["status" => "ERROR", "message" => "No se pudo crear el producto."]);
        }
    }

    /* Editar producto */
    public static function editProduct() {
        $id = $_POST['id'] ?? null;
        $codigo = $_POST['codigo'] ?? null;
        $codigo_sin = $_POST['codigo_sin'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $unidad_medida = $_POST['unidad_medida'] ?? null;
        $unidad_medida_sin = $_POST['unidad_medida_sin'] ?? null;
        $imagen = $_FILES['imagen']['name'] ?? null;
        $disponible = isset($_POST['disponible']) ? 1 : 0;
        if (empty($id) || empty($codigo) || empty($codigo_sin) || empty($nombre) || empty($precio) || empty($unidad_medida) || empty($unidad_medida_sin)) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Todos los campos son requeridos']);
            return;
        }
        if ($imagen) {
            $uploadDir = 'uploads/products/';
            $uploadFile = $uploadDir . basename($imagen);
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                echo json_encode(["status" => "ERROR", "message" => "Error al subir la imagen."]);
                return;
            }
        } else {
            $imagen = null;
        }
        try {
            ProductModel::updateProduct($id, $codigo, $codigo_sin, $nombre, $precio, $unidad_medida, $unidad_medida_sin, $imagen, $disponible);
            echo json_encode(['status' => 'OK', 'message' => 'Producto actualizado exitosamente']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Error al actualizar el producto: ' . $e->getMessage()]);
        }
    }

    /* Eliminar producto */
    public static function removeProduct() {
        $productId = $_POST['id'] ?? null;
        if (empty($productId)) {
            echo json_encode(["status" => "ERROR", "message" => "El ID del producto es requerido."]);
            return;
        }
        try {
            $result = ProductModel::removeProduct($productId);
            if ($result) {
                echo json_encode(["status" => "OK", "message" => "Producto eliminado exitosamente."]);
            } else {
                echo json_encode(["status" => "ERROR", "message" => "No se pudo eliminar el producto."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "ERROR", "message" => "Error al eliminar el producto: " . $e->getMessage()]);
        }
    }

    

}