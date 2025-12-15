<table class="table is-fullwidth is-striped">
<tr>
    <th>Día</th>
    <th>Hora</th>
    <th>Materia</th>
    <th>Grupo</th>
</tr>

<?php foreach($q as $row): ?>
<tr>
    <td><?= $row['dia'] ?></td>
    <td><?= $row['hora_inicio'] ?> - <?= $row['hora_fin'] ?></td>
    <td><?= $row['materia'] ?></td>
    <td><?= $row['semestre'] ?? '' ?> <?= $row['especialidad'] ?? '' ?></td>
</tr>
<?php endforeach; ?>
</table>
