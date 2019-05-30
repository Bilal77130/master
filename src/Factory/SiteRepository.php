<?php
class SiteRepositoryFactory
{
    public static function create()
    {
        return new SiteRepository();
    }
}