{% extends "base.mvc.php" %}

{% block title %}Delete product{% endblock %}

{% block body %}

    <h1>Delete product</h1>

    <form method="post" action="/products/{{ product["id"] }}/destroy">
        <p>Delete this product?</p>
        <button>Yes</button>
    </form>

    <p><a href="/products/{{ product["id"] }}/show">Cancel</a></p>

{% endblock %}