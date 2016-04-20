<?php
// create_task.php
require_once "bootstrap.php";

$newProductName = $argv[1];

$product = new Task();
$product->setName($newProductName);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Task with ID " . $product->getId() . ": " . $product->getName() . "\n";