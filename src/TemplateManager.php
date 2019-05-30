<?php

class TemplateManager
{
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    private function computeText($text, array $data)
    {
        $APPLICATION_CONTEXT = ApplicationContext::getInstance();

        $oQuote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;

        if ($oQuote)
        {       
            $OQuoteFromRepository = QuoteRepository::getInstance()->getById($oQuote->id);
            $usefulObject = SiteRepository::getInstance()->getById($oQuote->siteId);
            $destinationOfQuote = DestinationRepository::getInstance()->getById($oQuote->destinationId);

            if(strpos($text, '[quote:destination_link]') !== false){
                $destination = DestinationRepository::getInstance()->getById($oQuote->destinationId);       
            }

            // var_dump($destinationOfQuote->countryName);die;

        $text = $this->calculatePlaceOrder($text,'[quote:destination_link]',$destinationOfQuote->computerName);
        $text = $this->calculatePlaceOrder($text,'[quote:destination_name]',$destinationOfQuote->countryName);

        }


        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if($_user) {

           $text = $this->calculatePlaceOrder($text,'[user:first_name]',ucfirst(mb_strtolower($_user->firstname)));
        }


        return $text;
    }

  /**
     * @param string $text
     * @param string $PlaceOrderName
     * @return String
     */

    public function calculatePlaceOrder($text,$PlaceOrderName,$PlaceOrderElement){

        $text = str_replace($PlaceOrderName,$PlaceOrderElement,$text);

        return $text;

    }

}
