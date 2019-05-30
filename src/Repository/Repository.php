<?php

interface Repository
{
    public function getById($id);

    public function calculatePlaceOrder($text,$PlaceOrderName,$PlaceOrderElement);

    
}