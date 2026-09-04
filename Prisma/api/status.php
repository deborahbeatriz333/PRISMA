<?php
// Endpoint simples para verificar se a API do Prisma está funcionando.
header('Content-Type: application/json');
$status = [
  'status' => 'ok',
  'message' => 'API Prisma está funcionando',
  'timestamp' => time(),
];
echo json_encode($status);
