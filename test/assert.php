<?php

function assert_equal($a, $b)
{
    if ($a != $b)
        throw new Exception("Assert equal error");
}