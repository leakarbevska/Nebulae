<?php

interface AccountStorage{
    function checkAuth($login, $password);
}