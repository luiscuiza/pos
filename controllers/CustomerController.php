<?php

class CustomerController {

    /* Pagina mostrar todos los clientes */
    static public function renderCustomers() {
        $customers = CustomerModel::alls();
        $data = [
            'title' => 'POS - Clientes',
            'customers' => $customers
        ];
        TemplateController::render('./views/customers/list.php', './views/layout/sidebar.php', $data);
    }
    
    /* Formulario nuevo cliente */
    static public function renderNewForm() {
        include 'views/customers/formNew.php';
    }
    
    /* Formulario editar cliente */
    static public function renderEditForm() {
        $customerId = $_GET['id'] ?? null;
        if (!$customerId) {
            echo "ID de cliente no proporcionado.";
            return;
        }
        $customer = CustomerModel::getCustomerById($customerId);
        if (!$customer) {
            echo "Cliente no encontrado.";
            return;
        }
        include 'views/customers/formEdit.php';
    }

    /* Crear un nuevo cliente */
    public static function createCustomer() {
        $razon_social = $_POST['razon_social'] ?? null;
        $nit_ci = $_POST['nit_ci'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $telefono = $_POST['telefono'] ?? null;
        $email = $_POST['email'] ?? null;

        if (empty($razon_social) || empty($nit_ci) || empty($direccion) || empty($nombre) || empty($telefono) || empty($email)) {
            echo json_encode(["status" => "ERROR", "message" => "Todos los campos son obligatorios."]);
            return;
        }

        $result = CustomerModel::createCustomer($razon_social, $nit_ci, $direccion, $nombre, $telefono, $email);
        if ($result) {
            echo json_encode(["status" => "OK", "message" => "Cliente creado exitosamente."]);
        } else {
            echo json_encode(["status" => "ERROR", "message" => "No se pudo crear el cliente."]);
        }
    }

    /* Editar cliente */
    public static function editCustomer() {
        $id = $_POST['id'] ?? null;
        $razon_social = $_POST['razon_social'] ?? null;
        $nit_ci = $_POST['nit_ci'] ?? null;
        $direccion = $_POST['direccion'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $telefono = $_POST['telefono'] ?? null;
        $email = $_POST['email'] ?? null;

        if ($id && $razon_social && $nit_ci && $direccion && $nombre && $telefono && $email) {
            try {
                CustomerModel::updateCustomer($id, $razon_social, $nit_ci, $direccion, $nombre, $telefono, $email);
                echo json_encode(['status' => 'OK', 'message' => 'Cliente actualizado exitosamente']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'ERROR', 'message' => 'Error al actualizar el cliente: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'ERROR', 'message' => 'Todos los campos son requeridos']);
        }
    }

    /* Eliminar cliente */
    public static function removeCustomer() {
        $customerId = $_POST['id'] ?? null;
        if (empty($customerId)) {
            echo json_encode(["status" => "ERROR", "message" => "El ID del cliente es requerido."]);
            return;
        }
        try {
            $result = CustomerModel::removeCustomer($customerId);
            if ($result) {
                echo json_encode(["status" => "OK", "message" => "Cliente eliminado exitosamente."]);
            } else {
                echo json_encode(["status" => "ERROR", "message" => "No se pudo eliminar el cliente."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "ERROR", "message" => "Error al eliminar el cliente: " . $e->getMessage()]);
        }
    }

}
