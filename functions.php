<?php
function test_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function verify($field, &$errors)
{
    if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
        return htmlspecialchars(trim($_POST[$field]));
    }
    $errors[$field] = "The $field field is required.";
    return '';
}