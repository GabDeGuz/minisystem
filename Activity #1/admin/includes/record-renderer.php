<?php

declare(strict_types=1);

/**
 * Display records for any entity using column keys and labels supplied by the page.
 *
 * @param string                           $entityName Singular entity name.
 * @param array<string, string>            $columns    Record key => table heading.
 * @param array<int, array<string, mixed>> $records    Associative record rows.
 */
function renderRecords(string $entityName, array $columns, array $records): void
{
    $recordCount = count($records);
    ?>
    <section class="data-panel">
        <div class="panel-heading">
            <div>
                <h2><?php echo htmlspecialchars($entityName, ENT_QUOTES, 'UTF-8'); ?> Directory</h2>
                <p>
                    Showing <?php echo $recordCount; ?>
                    <?php echo $recordCount === 1 ? 'record' : 'records'; ?>
                </p>
            </div>
        </div>

        <?php if ($recordCount === 0): ?>
            <p class="records-empty">No records are currently available.</p>
        <?php else: ?>
            <div class="table-scroll">
                <table class="records-table records-table-generic">
                    <thead>
                        <tr>
                            <?php foreach ($columns as $label): ?>
                                <th scope="col"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record): ?>
                            <tr>
                                <?php foreach ($columns as $key => $label): ?>
                                    <td>
                                        <?php
                                        $value = $record[$key] ?? '';
                                        echo htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="table-footer">
            <p>
                Showing <strong><?php echo $recordCount; ?></strong>
                of <strong><?php echo $recordCount; ?></strong>
                <?php echo $recordCount === 1 ? 'record' : 'records'; ?>
            </p>
        </div>
    </section>
    <?php
}
