<?php

class DestinationRepository implements Repository
{
    use SingletonTrait;

    private $country;
    private $conjunction;
    private $computerName;

    /**
     * DestinationRepository constructor.
     */
    public function __construct()
    {
        $this->country = Faker\Factory::create()->country;
        $this->conjunction = 'en';
        $this->computerName = Faker\Factory::create()->slug();
    }

    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Destination(
            $id,
            $this->country,
            $this->conjunction,
            $this->computerName
        );
    }

    public function calculatePlaceOrder($text,$PlaceOrderName,$PlaceOrderElement){

        $text = str_replace($PlaceOrderName,$PlaceOrderElement,$text);

        return $text;

    }
    /**
     *
     *
     * @return string
     */
   
    public function getCountryName(){
       return $this->country;
    }

 /**
     *
     *
     * @return string
     */
   
    public function getComputerName(){
       return $this->computerName;
    }

}

