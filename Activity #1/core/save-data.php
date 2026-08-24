<?php

// Version 1: Reusable functions for saving Service, Staff, and Customer records.
// Version 2: Saves entity images locally using the generated database record ID.

declare(strict_types=1);

/**
 * Execute a reusable prepared INSERT statement.
 *
 * @param array<int|string, mixed> $values
 */
function saveRecord(PDO $connection, string $sql, array $values): void
{
    $statement = $connection->prepare($sql);
    $statement->execute($values);
}

/**
 * Generate the next readable ID for any supported entity table.
 */
function generateRecordId(
    PDO $connection,
    string $table,
    string $idColumn,
    string $prefix,
    int $startingNumber
): string {
    $statement = $connection->query(
        "SELECT {$idColumn}
        FROM {$table}
        ORDER BY {$idColumn} DESC
        LIMIT 1"
    );
    $lastId = $statement->fetchColumn();

    $lastNumber = $lastId === false
        ? $startingNumber
        : (int) substr((string) $lastId, strlen($prefix));

    return sprintf('%s%04d', $prefix, $lastNumber + 1);
}

/**
 * Version 1: Validate and save one Service record.
 */
function saveService(PDO $connection, array $formData, array $image): ?string
{
    $serviceName = trim((string) ($formData['service_name'] ?? ''));
    $category = trim((string) ($formData['category'] ?? ''));
    $duration = trim((string) ($formData['duration'] ?? ''));
    $price = (float) ($formData['price'] ?? 0);
    $status = trim((string) ($formData['status'] ?? ''));

    if ($serviceName === '' || $category === '' || $duration === '') {
        return 'Service name, category, and duration are required.';
    }

    if ($price <= 0 || $price > 99999999.99) {
        return 'Enter a valid Service price greater than zero.';
    }

    if (mb_strlen($serviceName) > 100 || mb_strlen($category) > 100 || mb_strlen($duration) > 50) {
        return 'One or more Service fields are too long.';
    }

    if (!in_array($status, ['Available', 'Limited', 'Unavailable'], true)) {
        return 'Select a valid Service status.';
    }

    $savedImage = null;

    try {
        $connection->beginTransaction();
        $serviceId = generateRecordId(
            $connection,
            'services',
            'service_id',
            'SER-',
            3000
        );

        $sql = 'INSERT INTO services
            (service_id, service_name, category, duration, price, status)
            VALUES (?, ?, ?, ?, ?, ?)';

        saveRecord(
            $connection,
            $sql,
            [$serviceId, $serviceName, $category, $duration, $price, $status]
        );

        $savedImage = saveEntityImage($image, 'service', $serviceId);
        $connection->commit();
        return null;
    } catch (PDOException $exception) {
        if ($connection->inTransaction()) {
            $connection->rollBack();
        }

        if ($savedImage !== null) {
            $savedImagePath = dirname(__DIR__) . '/' . $savedImage;

            if (is_file($savedImagePath)) {
                unlink($savedImagePath);
            }
        }

        error_log($exception->getMessage());

        return (string) $exception->getCode() === '23000'
            ? 'That Service record already exists.'
            : 'The Service could not be saved. Check the database permissions.';
    } catch (RuntimeException $exception) {
        if ($connection->inTransaction()) {
            $connection->rollBack();
        }

        return $exception->getMessage();
    }
}

/**
 * Version 1: Validate and save one Staff record.
 */
function saveStaff(PDO $connection, array $formData): ?string
{
    $name = trim((string) ($formData['name'] ?? ''));
    $position = trim((string) ($formData['position'] ?? ''));
    $department = trim((string) ($formData['department'] ?? ''));
    $email = trim((string) ($formData['email'] ?? ''));
    $phone = trim((string) ($formData['phone'] ?? ''));
    $status = trim((string) ($formData['status'] ?? ''));

    if ($name === '' || $position === '' || $department === '' || $email === '' || $phone === '') {
        return 'All Staff fields are required.';
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return 'Enter a valid Staff email address.';
    }

    if (
        mb_strlen($name) > 100
        || mb_strlen($position) > 100
        || mb_strlen($department) > 100
        || mb_strlen($email) > 100
        || mb_strlen($phone) > 30
    ) {
        return 'One or more Staff fields are too long.';
    }

    if (!in_array($status, ['On Duty', 'On Leave', 'Off Duty'], true)) {
        return 'Select a valid Staff status.';
    }

    try {
        $connection->beginTransaction();
        $employeeId = generateRecordId(
            $connection,
            'staff',
            'employee_id',
            'DGR-',
            1000
        );

        $sql = 'INSERT INTO staff
            (employee_id, name, position, department, email, phone, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)';

        saveRecord(
            $connection,
            $sql,
            [$employeeId, $name, $position, $department, $email, $phone, $status]
        );

        $connection->commit();
        return null;
    } catch (PDOException $exception) {
        if ($connection->inTransaction()) {
            $connection->rollBack();
        }

        error_log($exception->getMessage());

        return (string) $exception->getCode() === '23000'
            ? 'That Staff email address already exists.'
            : 'The Staff record could not be saved. Check the database permissions.';
    }
}

/**
 * Version 1: Validate and save one Customer record.
 */
function saveCustomer(PDO $connection, array $formData): ?string
{
    $name = trim((string) ($formData['name'] ?? ''));
    $email = trim((string) ($formData['email'] ?? ''));
    $phone = trim((string) ($formData['phone'] ?? ''));
    $lastStay = trim((string) ($formData['last_stay'] ?? ''));
    $guestType = trim((string) ($formData['guest_type'] ?? ''));
    $status = trim((string) ($formData['status'] ?? ''));

    if ($name === '' || $email === '' || $phone === '' || $lastStay === '') {
        return 'All Customer fields are required.';
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return 'Enter a valid Customer email address.';
    }

    if (
        mb_strlen($name) > 100
        || mb_strlen($email) > 100
        || mb_strlen($phone) > 30
        || mb_strlen($lastStay) > 50
    ) {
        return 'One or more Customer fields are too long.';
    }

    $guestTypes = ['VIP Guest', 'Returning Guest', 'New Guest', 'Loyalty Member'];

    if (!in_array($guestType, $guestTypes, true)) {
        return 'Select a valid Customer guest type.';
    }

    if (!in_array($status, ['Active', 'Inactive'], true)) {
        return 'Select a valid Customer status.';
    }

    try {
        $connection->beginTransaction();
        $customerId = generateRecordId(
            $connection,
            'customers',
            'customer_id',
            'CUS-',
            2000
        );

        $sql = 'INSERT INTO customers
            (customer_id, name, email, phone, last_stay, guest_type, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)';

        saveRecord(
            $connection,
            $sql,
            [$customerId, $name, $email, $phone, $lastStay, $guestType, $status]
        );

        $connection->commit();
        return null;
    } catch (PDOException $exception) {
        if ($connection->inTransaction()) {
            $connection->rollBack();
        }

        error_log($exception->getMessage());

        return (string) $exception->getCode() === '23000'
            ? 'That Customer email address already exists.'
            : 'The Customer record could not be saved. Check the database permissions.';
    }
}

/**
 * Version 2: Save an entity image locally using its database record ID.
 */
function saveEntityImage(array $image, string $entityName, string $recordId): string
{
    $uploadError = $image['error'] ?? UPLOAD_ERR_NO_FILE;

    if ($uploadError === UPLOAD_ERR_NO_FILE) {
        throw new RuntimeException('Please choose an image.');
    }

    if ($uploadError !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The image could not be uploaded.');
    }

    $temporaryFile = (string) ($image['tmp_name'] ?? '');
    $fileSize = (int) ($image['size'] ?? 0);

    if ($fileSize < 1 || $fileSize > 5 * 1024 * 1024) {
        throw new RuntimeException('The image must not exceed 5 MB.');
    }

    if (!is_uploaded_file($temporaryFile) || getimagesize($temporaryFile) === false) {
        throw new RuntimeException('The selected file is not a valid image.');
    }

    $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryFile);
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($extensions[$mimeType])) {
        throw new RuntimeException('Only JPG, PNG, and WebP images are allowed.');
    }

    // Exact local folder: Activity #1/images
    $imageDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images';

    if (
        !is_dir($imageDirectory)
        && !mkdir($imageDirectory, 0755, true)
        && !is_dir($imageDirectory)
    ) {
        throw new RuntimeException('The local images folder could not be created.');
    }

    $safeEntityName = preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($entityName));
    $safeRecordId = preg_replace('/[^a-z0-9_-]+/i', '-', strtolower($recordId));
    $fileName = $safeEntityName . '_' . $safeRecordId . '.' . $extensions[$mimeType];
    $destination = $imageDirectory . DIRECTORY_SEPARATOR . $fileName;

    if (!move_uploaded_file($temporaryFile, $destination)) {
        throw new RuntimeException('The image could not be saved locally.');
    }

    return 'images/' . $fileName;
}
