{% extends "base.mvc.php" %}

{% block title %}Edit product{% endblock %}

{% block body %}

    <h1>Edit product</h1>

    <form method="post" action="/products/{{ product["id"] }}/update">

    {% include "Products/form.mvc.php" %}

    </form>

    <p><a href="/products/{{ product["id"] }}/show">Cancel</a></p>

{% endblock %}