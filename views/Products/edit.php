<h1>Edit product</h1>

<form method="post" action="/products/<?= $product["id"] ?>/update">

    <?php require "form.php" ?>

</form>

<p><a href="/products/<?= $product["id"] ?>/show">Cancel</a></p>



</body>
</html>