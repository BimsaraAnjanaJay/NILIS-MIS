<?php
$role = "DR";
$data['role'] = $role;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>temp3 Dashboard</title>

</head>

<body>
    <?php $this->view('common/settings/settings', $data) ?>
</body>

</html>