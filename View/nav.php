<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $siteName ?></title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="/">Home</a>
            </li>
            <li>
                <a href="<?php $routeur->generateUri('car.addCar') ?>">Ajouter un véhicule</a>
            </li>
        </ul>
    </nav>
</body>

</html>