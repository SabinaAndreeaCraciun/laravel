<?php
$path = __DIR__ . '/../database/database.sqlite';
if (!file_exists($path)) {
    echo "Database file not found: $path\n";
    exit(1);
}
try {
    $pdo = new PDO('sqlite:' . $path);
    echo "PRAGMA table_info(courses):\n";
    $res = $pdo->query('PRAGMA table_info(courses)');
    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        foreach ($rows as $r) {
            echo $r['cid'] . ': ' . $r['name'] . ' (' . $r['type'] . ')\n';
        }
    } else {
        echo "(no courses table)\n";
    }

    echo "\nPRAGMA table_info(students):\n";
    $res = $pdo->query('PRAGMA table_info(students)');
    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        foreach ($rows as $r) {
            echo $r['cid'] . ': ' . $r['name'] . ' (' . $r['type'] . ')\n';
        }
    } else {
        echo "(no students table)\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
