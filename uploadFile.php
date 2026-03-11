<?php
return function (array $files): ?string {
    $uploadedFiles = [];
    $targetDir = __DIR__ . '/../uploads/';

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Check if it's multiple files
    $fileCount = is_array($files['name']) ? count($files['name']) : 0;
    for ($i = 0; $i < $fileCount; $i++) {
        $name = $files['name'][$i];
        $tmpName = $files['tmp_name'][$i];
        $size = $files['size'][$i];

        if (empty($name))
            continue;

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm', 'ogg'];
        if (!in_array($ext, $allowed))
            continue;
        if ($size > 2 * 1024 * 1024)
            continue;

        $uniqueName = uniqid() . '-' . basename($name);
        $targetFile = $targetDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $uploadedFiles[] = $uniqueName;
        }
    }

    return !empty($uploadedFiles) ? implode(',', $uploadedFiles) : null;
};