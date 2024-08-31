<?php

class ProductController {

    static private function uuidImage($fileName) {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $timestamp = round(microtime(true) * 1000);
        $uuid = sprintf(
            '%08x%04x%04x%04x%012x',
            mt_rand(0, 0xffffffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff) & 0x0fff | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            $timestamp
        );
        return "$uuid.$ext";
    }

    /* Página con todos los productos */
    static public function renderProducts() {
        $products = ProductModel::alls();
        $data = [
            'title' => 'POS - Productos',
            'products' => $products
        ];
        TemplateController::render('./views/products/list.php', './views/layout/sidebar.php', $data);
    }

    /* Página catalogo SIN */
    static public function renderCatalog() {
        TemplateController::render('./views/products/catalog.php', './views/layout/sidebar.php');
    }

    /* Página Unidad de Medidas SIN */
    static public function renderUMSin() {
        TemplateController::render('./views/products/umsin.php', './views/layout/sidebar.php');
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

    public static function renderViewForm() {
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
        include 'views/products/formView.php';
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
        #$disponible = isset($_POST['disponible']) ? 1 : 0;
        $disponible = 1;
        if (empty($codigo) || empty($codigo_sin) || empty($nombre) || empty($precio) || empty($unidad_medida) || empty($unidad_medida_sin) || empty($imagen)) {
            echo json_encode(["status" => "ERROR", "message" => "Todos los campos son obligatorios."]);
            return;
        }
        $imageName = self::uuidImage($imagen);
        $uploadDir = 'uploads/products/';
        $uploadFile = $uploadDir . $imageName;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
            echo json_encode(["status" => "ERROR", "message" => "Error al subir la imagen."]);
            return;
        }
        $result = ProductModel::createProduct($codigo, $codigo_sin, $nombre, $precio, $unidad_medida, $unidad_medida_sin, $imageName, $disponible);
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
            $imageName = self::uuidImage($imagen);
            $uploadDir = 'uploads/products/';
            $uploadFile = $uploadDir . $imageName;
            $uploadFile = $uploadDir . basename($imageName);
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                echo json_encode(["status" => "ERROR", "message" => "Error al subir la imagen."]);
                return;
            }
        } else {
            $imageName = null;
        }
        try {
            ProductModel::updateProduct($id, $codigo, $codigo_sin, $nombre, $precio, $unidad_medida, $unidad_medida_sin, $imageName, $disponible);
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

    /* Informacion de producto */
    public static function infoProduct() {
        $data = json_decode(file_get_contents('php://input'), true);
        $codprod = $data['codprod'] ?? null;
        if (empty($codprod)) {
            echo json_encode(["status" => "ERROR", "message" => "El codigo de producto es requerido."]);
            return;
        }
        try {
            $producto = ProductModel::infoProduct($codprod);
            if ($producto) {
                echo json_encode(["status" => "OK", "data" => $producto]);
            } else {
                echo json_encode(["status" => "ERROR", "message" => "No se pudo obtener informacion del producto."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "ERROR", "message" => "Error al obtener informacion del producto: " . $e->getMessage()]);
        }
    }
}