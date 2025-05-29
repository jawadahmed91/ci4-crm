<h2>Customers</h2>
<a href="<?= site_url('customers/create') ?>">Add New</a>
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
        <?php foreach ($customers as $cust): ?>
        <tr>
            <td><?= $cust['id'] ?></td>
            <td><?= $cust['name'] ?></td>
            <td><?= $cust['email'] ?></td>
            <td><?= $cust['phone'] ?></td>
            <td>
                <a href="<?= site_url("customers/edit/{$cust['id']}") ?>">Edit</a>
                <a href="<?= site_url("customers/delete/{$cust['id']}") ?>"
                    onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>