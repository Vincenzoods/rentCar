<!-- La propriété enctype est définie sur "multipart/form-data",
 ce qui signifie que le formulaire peut inclure des données de fichier (comme une image) ainsi que des données de formulaire standard.
 Cette propriété est nécessaire pour utiliser la superglobale $_FILES pour récupérer les données de fichier envoyées -->
<form action="" method="POST" enctype="multipart/form-data">
    <label for="model">Modèle</label>
    <input name="modele" id="modele" type="text">
    <label for="marque">Marque</label>
    <input name="marque" id="marque" type="text">
    <label for="color">Couleur</label>
    <input name="color" id="color" type="color">
    <input type="file" name="img" id="img">
    <input type="submit" value="Ajouter">
</form>