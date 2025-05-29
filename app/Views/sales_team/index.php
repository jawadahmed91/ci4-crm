<h2>Sales Team</h2>
<a href="<?= site_url('sales_team/create') ?>">Add New</a>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($teams as $team): ?>
        <tr>
            <td><?= $team['id'] ?></td>
            <td><?= $team['name'] ?></td>
            <td><?= $team['email'] ?></td>
            <td><?= $team['phone'] ?></td>
            <td>
                <a href="<?= site_url("sales_team/edit/{$team['id']}") ?>">Edit</a>
                <a href="<?= site_url("sales_team/delete/{$team['id']}") ?>"
                    onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>