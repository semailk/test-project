<?php

namespace App\Services;

class SanctionService
{
    /**
     * @param $response
     * @return array
     */
    public function responseDTO($response): array
    {
        $result = [];
        $array = json_decode($response->body(), true)['result']['data'];

        foreach ($array as $key => $value) {
            if (isset($array[$key]['source_links'][0]) &&
                isset($array[$key]['entity_name']) &&
                isset($array[$key]['birthdate'])
            ) {
                $result[$key]['url'] = $array[$key]['source_links'][0]['url'];
                $result[$key]['entity_name'] = $array[$key]['entity_name'][0]['value'];
                $result[$key]['birthdate'] = $array[$key]['birthdate'][count($array[$key]['birthdate']) - 1]['value']['dateOfBirth'];
            } else {
                $result[$key]['entity_name'] = $array[$key]['name_alias'][0]['value']['whole_name'];
                $result[$key]['url'] = $array[$key]['publication_url'][0]['value'];
                $result[$key]['birthdate'] = $array[$key]['birthdate'][0]['value']['birthdate'];
            }
        }

        return $result;
    }
}
