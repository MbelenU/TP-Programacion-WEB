<?php

function paginateArray(array $items, int $itemsPerPage, int $currentPage): array {
    $totalItems = count($items);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($totalPages, $currentPage)); // Validar el número de página

    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedItems = array_slice($items, $offset, $itemsPerPage);

    return [
        'items' => $paginatedItems,
        'totalPages' => $totalPages,
        'currentPage' => $currentPage
    ];
}
?> 