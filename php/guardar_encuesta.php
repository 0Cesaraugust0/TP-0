<?php
$host = "localhost";
$usuario = "root";
$password = "";
$bd = "tpw-0";

$conn = new mysqli($host, $usuario, $password, $bd);

if ($conn->connect_error) {
  die("❌ Error de conexión: " . $conn->connect_error);
}

$datos = [];
for ($i = 1; $i <= 10; $i++) {
  $clave = "p" . $i;
  $datos[$clave] = isset($_POST[$clave]) ? $_POST[$clave] : null;
}

if (in_array(null, $datos)) {
  die("⚠️ Por favor, responde todas las preguntas.");
}

$stmt = $conn->prepare("INSERT INTO respuestas_encuesta (p1, p2, p3, p4, p5, p6, p7, p8, p9, p10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
  "ssssssssss",
  $datos["p1"],
  $datos["p2"],
  $datos["p3"],
  $datos["p4"],
  $datos["p5"],
  $datos["p6"],
  $datos["p7"],
  $datos["p8"],
  $datos["p9"],
  $datos["p10"]
);

if ($stmt->execute()) {
  echo "<script>alert('✅ ¡Gracias por responder la encuesta!'); window.location.href = '../../index.html';</script>";
} else {
  echo "❌ Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
