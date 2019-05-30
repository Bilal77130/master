<?php

class QuoteRepository implements Repository
{
    use SingletonTrait;

    private $siteId;
    private $destinationId;
    private $date;

    /**
     * QuoteRepository constructor.
     */
    public function __construct()
    {
        // DO NOT MODIFY THIS METHOD
        $generator = Faker\Factory::create();

        $this->siteId = $generator->numberBetween(1, 10);
        $this->destinationId = $generator->numberBetween(1, 200);
        $this->date = new DateTime();
    }

    /**
     * @param int $id
     *
     * @return Quote
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Quote(
            $id,
            $this->siteId,
            $this->destinationId,
            $this->date
        );
    }

    public function calculatePlaceOrder($text,$PlaceOrderName,$PlaceOrderElement){

        $text = str_replace($PlaceOrderName,$PlaceOrderElement,$text);

        return $text;

    }

    /**
     * 
     *
     * @return int
     */
    public function getDestinationId()
    {
    
        return  $this->destinationId;
    } 

    /**
     * exemple of a new placeorder
     *
     * @return dateFormat
     */
    public function getDateTime()
    {
    
        return  $this->date;
    }



}

