<?php
// Your existing db_connect function

define('DB_SERVER', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', (int) (getenv('DB_PORT') ?: 3306));
define('DB_USER', getenv('DB_USER') ?: 'resort_app');
define('DB_PASS', getenv('DB_PASSWORD') ?: 'ResortLocal2026!');
define('DB_NAME', getenv('DB_NAME') ?: 'de_guzman_resort');

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if (mysqli_connect_errno()) {
    die(
        'Database connection failed: '
        . mysqli_connect_error()
        . ' ('
        . mysqli_connect_errno()
        . ')'
    );
}

mysqli_set_charset($connection, 'utf8mb4');

function confirm_query($result_set)
{
    if (!$result_set) {
        die('Database query failed');
    }
}

// Reusable redirect function
function redirect_to($location)
{
    header('Location: ' . $location);
    exit();
}

// Version 1
// function save($insertQuery)
// {
//     global $connection;
//     $sql = mysqli_query($connection, $insertQuery) or die(mysqli_error($connection));
//     confirm_query($sql);
//     mysqli_close($connection);
// }

// Version 2: one save function for every record type.
function save($insertQuery)
{
    global $connection;

    $sql = mysqli_query($connection, $insertQuery) or die(mysqli_error($connection));
    $pid = mysqli_insert_id($connection);

    if (isset($_FILES['fileField']) && ($_FILES['fileField']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
        $newname = $GLOBALS['uploadFileName'] ?? "$pid.jpg";
        $imageDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images';

        if (!is_dir($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        move_uploaded_file(
            $_FILES['fileField']['tmp_name'],
            $imageDirectory . DIRECTORY_SEPARATOR . $newname
        );
    }

    confirm_query($sql);
    mysqli_close($connection);
}

function display_all($sql, $column_mappings, $url)
{
    global $connection;

    $result = mysqli_query($connection, $sql);
    confirm_query($result);
    $rowCount = mysqli_num_rows($result);
    $directoryName = match (basename($url)) {
        'services.php' => 'Service',
        'customers.php' => 'Customer',
        'staff-records.php' => 'Staff',
        default => 'Record',
    };

    $safeDirectoryName = htmlspecialchars($directoryName, ENT_QUOTES, 'UTF-8');
    $recordLabel = $rowCount === 1 ? 'record' : 'records';
    $output_list = "<section class='data-panel'>
        <div class='panel-heading'>
            <div>
                <h2>$safeDirectoryName Directory</h2>
                <p>Showing $rowCount $recordLabel</p>
            </div>
        </div>";

    if ($rowCount > 0) {
        $output_list .= "<div class='table-scroll'>
            <table class='records-table records-table-generic'>
                <thead><tr>";

        foreach ($column_mappings as $label) {
            $safeLabel = htmlspecialchars((string) $label, ENT_QUOTES, 'UTF-8');
            $output_list .= "<th scope='col'>$safeLabel</th>";
        }

        $output_list .= "<th scope='col'>Actions</th></tr></thead><tbody>";

        while ($row = mysqli_fetch_array($result)) {
            $output_list .= '<tr>';

            foreach ($column_mappings as $column_name => $label) {
                $value = $row[$column_name];

                if (strpos($column_name, 'date') !== false) {
                    $value = date('M d, Y', strtotime($value));
                }

                $safeValue = htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
                $output_list .= "<td>$safeValue</td>";
            }

            $id = $row['id']
                ?? $row['service_id']
                ?? $row['customer_id']
                ?? $row['employee_id']
                ?? '';
            $safeId = rawurlencode((string) $id);
            $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

            $output_list .= "<td>
                <div class='record-actions'>
                    <a class='row-action' href='edit.php?id=$safeId' aria-label='Edit record' title='Edit'>
                        <i class='fa-solid fa-pen'></i>
                    </a>
                    <a class='row-action row-action-danger' href='$safeUrl?deleteid=$safeId' aria-label='Delete record' title='Delete'>
                        <i class='fa-solid fa-trash'></i>
                    </a>
                </div>
            </td></tr>";
        }

        $output_list .= '</tbody></table></div>';
    } else {
        $output_list .= "<p class='records-empty'>No records found.</p>";
    }

    $output_list .= "<div class='table-footer'>
        <p>Showing <strong>$rowCount</strong> of <strong>$rowCount</strong> $recordLabel</p>
    </div></section>";

    echo $output_list;
}

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

function fetch_record_summary($sql)
{
    global $connection;

    $result = mysqli_query($connection, $sql);
    confirm_query($result);
    $record = mysqli_fetch_assoc($result);

    return is_array($record) ? $record : [];
}

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
?>
