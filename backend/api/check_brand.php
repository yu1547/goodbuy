<?php
header("Content-Type: application/json");

include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = $_POST['brand_name'] ?? '';

    if (!empty($brand_name)) {
        $stmt = $conn->prepare("SELECT country FROM brands WHERE brand_name = ?");
        $stmt->bind_param("s", $brand_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($country);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            echo json_encode(['exists' => true, 'country' => $country]);
        } else {
            echo json_encode(['exists' => false]);
        }

        $stmt->close();
        $conn->close();
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
