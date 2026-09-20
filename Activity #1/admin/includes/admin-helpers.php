<?php

/**
 * Generate the next readable ID for a resort record.
 */
function next_record_id($table, $id_column, $prefix, $starting_number)
{
    global $connection;

    $allowedColumns = [
        'services' => 'service_id',
        'customers' => 'customer_id',
        'staff' => 'employee_id',
    ];

    if (!isset($allowedColumns[$table]) || $allowedColumns[$table] !== $id_column) {
        die('Invalid record type.');
    }

    $result = mysqli_query(
        $connection,
        "SELECT $id_column FROM $table ORDER BY $id_column DESC LIMIT 1"
    );
    confirm_query($result);
    $row = mysqli_fetch_assoc($result);
    $lastId = $row[$id_column] ?? null;
    $lastNumber = $lastId === null
        ? $starting_number
        : (int) substr($lastId, strlen($prefix));

    return sprintf('%s%04d', $prefix, $lastNumber + 1);
}

/**
 * Fetch one summary row for the dashboard cards.
 */
function fetch_record_summary($sql)
{
    global $connection;

    $result = mysqli_query($connection, $sql);
    confirm_query($result);
    $record = mysqli_fetch_assoc($result);

    return is_array($record) ? $record : [];
}

/**
 * Validate an admin form before calling the shared save() function.
 */
function validate_form($entity_name, $form_data)
{
    if ($entity_name === 'service') {
        if (
            trim($form_data['service_name'] ?? '') === ''
            || trim($form_data['category'] ?? '') === ''
            || trim($form_data['duration'] ?? '') === ''
        ) {
            return 'Service name, category, and duration are required.';
        }

        $price = (float) ($form_data['price'] ?? 0);

        if ($price <= 0 || $price > 99999999.99) {
            return 'Enter a valid Service price greater than zero.';
        }

        return in_array($form_data['status'] ?? '', ['Available', 'Limited', 'Unavailable'], true)
            ? null
            : 'Select a valid Service status.';
    }

    if ($entity_name === 'staff') {
        foreach (['name', 'position', 'department', 'email', 'phone'] as $field) {
            if (trim($form_data[$field] ?? '') === '') {
                return 'All Staff fields are required.';
            }
        }

        if (filter_var($form_data['email'], FILTER_VALIDATE_EMAIL) === false) {
            return 'Enter a valid Staff email address.';
        }

        return in_array($form_data['status'] ?? '', ['On Duty', 'On Leave', 'Off Duty'], true)
            ? null
            : 'Select a valid Staff status.';
    }

    if ($entity_name === 'customer') {
        foreach (['name', 'email', 'phone', 'last_stay'] as $field) {
            if (trim($form_data[$field] ?? '') === '') {
                return 'All Customer fields are required.';
            }
        }

        if (filter_var($form_data['email'], FILTER_VALIDATE_EMAIL) === false) {
            return 'Enter a valid Customer email address.';
        }

        if (!in_array($form_data['guest_type'] ?? '', ['VIP Guest', 'Returning Guest', 'New Guest', 'Loyalty Member'], true)) {
            return 'Select a valid Customer guest type.';
        }

        return in_array($form_data['status'] ?? '', ['Active', 'Inactive'], true)
            ? null
            : 'Select a valid Customer status.';
    }

    return 'Unknown record type.';
}
