<?php 
class QuoteRepositoryFactory{
    public static function create()
    {
        return new QuoteRepository();
    }
}