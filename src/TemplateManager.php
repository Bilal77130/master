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

        $quote = (isset($data['quote']) and $data['quote'] instanceof Quote) ? $data['quote'] : null;

        if ($quote)
        {       
            //init objects
            $_quoteFromRepository = QuoteRepositoryFactory::create();
            $usefulObject = SiteRepositoryFactory::create();
            $destinationOfQuote = DestinationRepositoryFactory::create();


            if(strpos($text, '[quote:destination_link]') !== false){
                $destination = DestinationRepository::getInstance()->getById($quote->destinationId);
            }

            $containsSummaryHtml = strpos($text, '[quote:summary_html]');
            $containsSummary     = strpos($text, '[quote:summary]');
            

            if ($containsSummaryHtml !== false || $containsSummary !== false) {
                if ($containsSummaryHtml !== false) {
                    $text = str_replace(
                        '[quote:summary_html]',
                        Quote::renderHtml($_quoteFromRepository),
                        $text
                    );
                }
                if ($containsSummary !== false) {
                    $text = str_replace(
                        '[quote:summary]',
                        Quote::renderText($_quoteFromRepository),
                        $text
                    );
                }
            }



        $text = $_quoteFromRepository->calculatePlaceOrder($text,'[quote:destination_name]',$destinationOfQuote->getCountryName());

        $text = $_quoteFromRepository->calculatePlaceOrder($text,'[quote:dateQuoted]',$_quoteFromRepository->getDateTime()->format('d-m-Y H:i:s'));

        }


        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if($_user) {

           $text = $_quoteFromRepository->calculatePlaceOrder($text,'[user:first_name]',ucfirst(mb_strtolower($_user->firstname)));
        }


        return $text;
    }



}
