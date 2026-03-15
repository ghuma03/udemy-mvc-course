<label for="name">Name</label>
<input type="text" id="name" name="name" value="<?= $product["name"] ?? "" ?>">

<?php if (isset($errors["name"])): ?>
    <p><?= $errors["name"] ?></p>
<?php endif ?>

<label for="name">Description</label>
<textarea id="description" name="description"><?= $product["description"] ?? "" ?></textarea>

<button>Save</button>