<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
    <?php if (!empty($extraCss) && is_array($extraCss)): ?>
        <?php foreach ($extraCss as $cssPath): ?>
            <link rel="stylesheet" href="<?= base_url($cssPath) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

