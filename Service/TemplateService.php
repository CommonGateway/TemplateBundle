<?php

// src/Service/TemplateService.php

namespace CommonGateway\TemplateBundle\Service;

class TemplateService
{

    /*
     * Returns a welcoming string
     * 
     * @return array 
     */
    public function templateHandler(array $data, array $configuration): array
    {
        return ['response' => 'Hello. Your TemplateBundle works'];
    }
}
